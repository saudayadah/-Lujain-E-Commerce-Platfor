<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Services\ImageUploadService;

class AdminProductController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        // البحث بالاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'LIKE', "%{$search}%")
                  ->orWhere('name_en', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        // فلتر بالفئة
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // فلتر بالحالة
        if ($request->filled('status')) {
            if ($request->status === 'out_of_stock') {
                $query->where('stock', 0);
            } else {
                $query->where('status', $request->status);
            }
        }

        // فلتر بالمخزون
        if ($request->filled('stock')) {
            if ($request->stock === 'low') {
                $query->where('stock', '<=', 10)->where('stock', '>', 0);
            } elseif ($request->stock === 'out') {
                $query->where('stock', 0);
            }
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock' => 'required|integer|min:0',
            'low_stock_alert' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'is_featured' => 'boolean',
            'is_special_offer' => 'boolean',
            'special_offer_start' => 'nullable|date',
            'special_offer_end' => 'nullable|date|after:special_offer_start',
            'badge_text' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ], [
            'sku.unique' => 'رمز المنتج (SKU) موجود بالفعل. الرجاء استخدام رمز مختلف أو اتركه فارغاً ليتم توليده تلقائياً.',
            'sale_price.lte' => 'يجب أن يكون سعر البيع أقل من أو يساوي السعر الأساسي.',
            'special_offer_end.after' => 'تاريخ نهاية العرض يجب أن يكون بعد تاريخ البداية.',
        ]);

        $validated['name_en'] = $validated['name_en'] ?? $validated['name_ar'];

        $requestedSlug = $request->input('slug', $validated['name_en']);
        $slug = generate_unique_slug(Product::class, $requestedSlug);
        $validated['slug'] = $slug;

        // معالجة وضغط صورة واحدة رئيسية
        if ($request->hasFile('image')) {
            try {
                $imagePath = $this->imageUploadService->uploadProductImage(
                    $request->file('image'),
                    $slug,
                    true
                );
                
                if ($imagePath) {
                    $validated['image'] = $imagePath;
                } else {
                    return back()->withErrors(['image' => 'فشل رفع الصورة الرئيسية. يرجى المحاولة مرة أخرى.'])->withInput();
                }
            } catch (\Exception $e) {
                \Log::error('Product image upload error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'حدث خطأ أثناء رفع الصورة: ' . $e->getMessage()])->withInput();
            }
        }

        // معالجة الصور المتعددة
        if ($request->hasFile('images')) {
            try {
                $uploadedImages = $this->imageUploadService->uploadMultiple(
                    $request->file('images'),
                    'products/' . $slug . '/'
                );
                
                if (!empty($uploadedImages)) {
                    $validated['images'] = $uploadedImages;
                } else {
                    \Log::warning('No product images were uploaded successfully');
                }
            } catch (\Exception $e) {
                \Log::error('Product images upload error: ' . $e->getMessage());
                // نستمر في العملية حتى لو فشلت الصور المتعددة
            }
        }

        $validated['unit'] = $validated['unit'] ?? 'قطعة';
        $validated['low_stock_alert'] = $validated['low_stock_alert'] ?? 5;
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_special_offer'] = $request->has('is_special_offer');
        // status already validated, no need to override

        $attributes = [];
        if ($request->filled('weight')) {
            $attributes['weight'] = $request->weight;
        }
        $validated['attributes'] = $attributes;
        unset($validated['weight']);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock' => 'required|integer|min:0',
            'low_stock_alert' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'is_featured' => 'boolean',
            'is_special_offer' => 'boolean',
            'special_offer_start' => 'nullable|date',
            'special_offer_end' => 'nullable|date|after:special_offer_start',
            'badge_text' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ], [
            'sku.unique' => 'رمز المنتج (SKU) موجود بالفعل. الرجاء استخدام رمز مختلف أو اتركه فارغاً.',
            'sale_price.lte' => 'يجب أن يكون سعر البيع أقل من أو يساوي السعر الأساسي.',
            'special_offer_end.after' => 'تاريخ نهاية العرض يجب أن يكون بعد تاريخ البداية.',
        ]);

        $validated['name_en'] = $validated['name_en'] ?? $validated['name_ar'];
        
        // 🔒 الحفاظ على slug القديم لعدم كسر الروابط (SEO + تجربة المستخدم)
        // فقط نُحدث slug إذا تغيّر الاسم الإنجليزي بشكل كبير
        $newSlug = $request->input('slug', $validated['name_en']);
        if ($request->boolean('force_slug_update') && $product->slug !== Str::slug($newSlug)) {
            $slug = generate_unique_slug(Product::class, $newSlug, $product->id);
            $validated['slug'] = $slug;
        } else {
            // الاحتفاظ بـ slug القديم
            $slug = $product->slug;
        }

        // معالجة الصورة في التحديث
        if ($request->hasFile('image')) {
            try {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($product->image) {
                    $this->imageUploadService->delete($product->image);
                }
                
                $imagePath = $this->imageUploadService->uploadProductImage(
                    $request->file('image'),
                    $slug,
                    true
                );
                
                if ($imagePath) {
                    $validated['image'] = $imagePath;
                } else {
                    return back()->withErrors(['image' => 'فشل رفع الصورة الرئيسية. يرجى المحاولة مرة أخرى.'])->withInput();
                }
            } catch (\Exception $e) {
                \Log::error('Product image update error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'حدث خطأ أثناء تحديث الصورة: ' . $e->getMessage()])->withInput();
            }
        }

        // معالجة الصور المتعددة في التحديث
        if ($request->hasFile('images')) {
            try {
                $uploadedImages = $this->imageUploadService->uploadMultiple(
                    $request->file('images'),
                    'products/' . $slug . '/'
                );
                
                if (!empty($uploadedImages)) {
                    // دمج الصور الجديدة مع الصور القديمة
                    $existingImages = $product->images ?? [];
                    $validated['images'] = array_merge($existingImages, $uploadedImages);
                } else {
                    \Log::warning('No product images were uploaded successfully during update');
                }
            } catch (\Exception $e) {
                \Log::error('Product images update error: ' . $e->getMessage());
                // نستمر في العملية حتى لو فشلت الصور المتعددة
            }
        }

        $validated['unit'] = $validated['unit'] ?? 'قطعة';
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_special_offer'] = $request->has('is_special_offer');
        // status already validated, no need to override

        $attributes = $product->attributes ?? [];
        if ($request->filled('weight')) {
            $attributes['weight'] = $request->weight;
        }
        $validated['attributes'] = $attributes;
        unset($validated['weight']);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        try {
            // 🗑️ حذف جميع صور المنتج قبل حذفه من قاعدة البيانات
            
            // 1. حذف الصورة الرئيسية
            if ($product->image) {
                $this->imageUploadService->delete($product->image);
            }
            
            // 2. حذف الصور المتعددة
            if (is_array($product->images) && !empty($product->images)) {
                $this->imageUploadService->deleteMultiple($product->images);
            }
            
            // 3. حذف مجلد المنتج بالكامل (إذا كان موجودًا)
            $productFolder = 'products/' . $product->slug;
            $this->imageUploadService->deleteDirectory($productFolder);
            
            // 4. حذف المنتج من قاعدة البيانات
            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', __('messages.admin.product_deleted'));
                
        } catch (\Exception $e) {
            \Log::error('Product deletion error: ' . $e->getMessage());
            return redirect()->route('admin.products.index')
                ->with('error', 'حدث خطأ أثناء حذف المنتج. يرجى المحاولة مرة أخرى.');
        }
    }

    public function bulkImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        // Implement CSV import logic here
        // Excel::import(new ProductsImport, $request->file('file'));

        return redirect()->route('admin.products.index')->with('success', __('messages.admin.products_imported'));
    }

    public function export()
    {
        // Implement CSV export logic
        // return Excel::download(new ProductsExport, 'products.xlsx');
    }
}

