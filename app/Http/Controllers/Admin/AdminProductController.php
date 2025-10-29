<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminProductController extends Controller
{
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
        $validated['slug'] = Str::slug($validated['name_en']);
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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // حفظ الصور المتعددة
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('products', 'public');
            }
            $validated['images'] = $images;
        }

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
        $validated['slug'] = Str::slug($validated['name_en']);
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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // حفظ الصور المتعددة
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('products', 'public');
            }
            $validated['images'] = $images;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('messages.admin.product_deleted'));
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

