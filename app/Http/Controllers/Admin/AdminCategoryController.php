<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Services\ImageUploadService;

class AdminCategoryController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function index()
    {
        $categories = Category::with('parent')->latest()->get();
        
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $requestedSlug = $request->input('slug', $validated['name_en']);
        $slug = generate_unique_slug(Category::class, $requestedSlug);
        $validated['slug'] = $slug;
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                $imagePath = $this->imageUploadService->uploadCategoryImage(
                    $request->file('image'),
                    $slug
                );
                
                if ($imagePath) {
                    $validated['image'] = $imagePath;
                } else {
                    return back()->withErrors(['image' => 'فشل رفع صورة التصنيف. يرجى المحاولة مرة أخرى.'])->withInput();
                }
            } catch (\Exception $e) {
                \Log::error('Category image upload error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'حدث خطأ أثناء رفع الصورة: ' . $e->getMessage()])->withInput();
            }
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', __('messages.admin.category_created'));
    }

    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $slug = $category->slug;
        if ($request->boolean('force_slug_update')) {
            $newSlug = generate_unique_slug(Category::class, $request->input('slug', $validated['name_en']), $category->id);
            if ($newSlug !== $category->slug) {
                $validated['slug'] = $slug = $newSlug;
            }
        }
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($category->image) {
                    $this->imageUploadService->delete($category->image);
                }
                
                $imagePath = $this->imageUploadService->uploadCategoryImage(
                    $request->file('image'),
                    $slug
                );
                
                if ($imagePath) {
                    $validated['image'] = $imagePath;
                } else {
                    return back()->withErrors(['image' => 'فشل رفع صورة التصنيف. يرجى المحاولة مرة أخرى.'])->withInput();
                }
            } catch (\Exception $e) {
                \Log::error('Category image update error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'حدث خطأ أثناء تحديث الصورة: ' . $e->getMessage()])->withInput();
            }
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', __('messages.admin.category_updated'));
    }

    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'لا يمكن حذف التصنيف لأنه يحتوي على منتجات. قم بحذف أو نقل المنتجات أولاً.');
        }

        // Check if category has children
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'لا يمكن حذف التصنيف لأنه يحتوي على تصنيفات فرعية. قم بحذف التصنيفات الفرعية أولاً.');
        }

        try {
            // 🗑️ حذف صورة التصنيف قبل حذفه
            if ($category->image) {
                $this->imageUploadService->delete($category->image);
                
                // حذف مجلد التصنيف بالكامل
                $categoryFolder = 'categories/' . $category->slug;
                $this->imageUploadService->deleteDirectory($categoryFolder);
            }
            
            $category->delete();

            return redirect()->route('admin.categories.index')
                ->with('success', 'تم حذف التصنيف بنجاح');
                
        } catch (\Exception $e) {
            \Log::error('Category deletion error: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')
                ->with('error', 'حدث خطأ أثناء حذف التصنيف. يرجى المحاولة مرة أخرى.');
        }
    }
}

