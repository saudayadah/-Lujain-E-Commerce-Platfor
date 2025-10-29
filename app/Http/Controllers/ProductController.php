<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\HasProductFiltering;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use HasProductFiltering;
    public function index(Request $request)
    {
        try {
            $query = Product::query()->with('category');
            $query = $this->applyProductFilters($query, $request);
            $query = $this->applyProductSorting($query, $request->get('sort', 'newest'));

            $perPage = $request->get('per_page', 24);
            $products = $query->paginate($perPage);

            $categories = Category::active()
                ->whereNull('parent_id')
                ->orderBy('sort_order')
                ->orderBy('name_ar')
                ->get();

            [$minPrice, $maxPrice] = $this->getPriceRange();

            return view('products.index', compact('products', 'categories', 'minPrice', 'maxPrice'));
        } catch (\Exception $e) {
            \Log::error('ProductController@index: ' . $e->getMessage());
            return view('products.index', [
                'products' => \Illuminate\Pagination\Paginator::empty(),
                'categories' => collect(),
                'minPrice' => 0,
                'maxPrice' => 1000,
            ]);
        }
    }

    public function show($product)
    {
        try {
            // Handle both ID and model binding
            if (!($product instanceof Product)) {
                $product = Product::findOrFail($product);
            }

            // Increment views (silently fail if needed)
            try {
                $product->increment('views');
            } catch (\Exception $e) {
                \Log::warning('Failed to increment product views: ' . $e->getMessage());
            }

            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->active()
                ->inStock()
                ->limit(4)
                ->get();

            return view('products.show', compact('product', 'relatedProducts'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('products.index')
                ->with('error', 'المنتج المطلوب غير موجود');
        } catch (\Exception $e) {
            \Log::error('ProductController@show: ' . $e->getMessage());
            return redirect()->route('products.index')
                ->with('error', 'حدث خطأ أثناء تحميل المنتج');
        }
    }

    public function byCategory($category)
    {
        try {
            // Handle both ID and model binding
            if (!($category instanceof Category)) {
                $category = Category::findOrFail($category);
            }

            $query = Product::with('category')->where(function($q) use ($category) {
                try {
                    $childrenIds = $category->getAllChildrenIds();
                    $q->where('category_id', $category->id)
                      ->orWhereIn('category_id', $childrenIds);
                } catch (\Exception $e) {
                    $q->where('category_id', $category->id);
                }
            });

            $query = $this->applyProductFilters($query);
            $query = $this->applyProductSorting($query, request()->get('sort', 'newest'));

            $perPage = request()->get('per_page', 24);
            $products = $query->paginate($perPage);

            [$minPrice, $maxPrice] = $this->getPriceRange();

            return view('products.category', compact('category', 'products', 'minPrice', 'maxPrice'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('categories.index')
                ->with('error', 'التصنيف المطلوب غير موجود');
        } catch (\Exception $e) {
            \Log::error('ProductController@byCategory: ' . $e->getMessage());
            return redirect()->route('categories.index')
                ->with('error', 'حدث خطأ أثناء تحميل المنتجات');
        }
    }

    public function shopByCategories()
    {
        try {
            $categories = Category::where('is_active', true)
                ->whereNull('parent_id')
                ->with(['children' => function($query) {
                    $query->where('is_active', true)
                          ->orderBy('sort_order')
                          ->orderBy('name_ar');
                }])
                ->orderBy('sort_order')
                ->orderBy('name_ar')
                ->get();
        } catch (\Exception $e) {
            $categories = collect();
        }

        return view('products.shop-by-categories', compact('categories'));
    }
}

