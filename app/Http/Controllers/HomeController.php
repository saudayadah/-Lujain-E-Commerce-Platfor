<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $featuredProducts = $this->getFeaturedProducts();
            $categories = $this->getMainCategories();
            $newProducts = $this->getNewProducts();
            $specialOfferProducts = $this->getSpecialOfferProducts();
            $discountedProducts = $this->getDiscountedProducts();

            return view('home', compact(
                'featuredProducts',
                'categories',
                'newProducts',
                'specialOfferProducts',
                'discountedProducts'
            ));
        } catch (\Exception $e) {
            \Log::error('HomeController@index: ' . $e->getMessage());
            return view('home', [
                'featuredProducts' => collect(),
                'categories' => collect(),
                'newProducts' => collect(),
                'specialOfferProducts' => collect(),
                'discountedProducts' => collect(),
            ]);
        }
    }

    protected function getFeaturedProducts()
    {
        try {
            return Product::featured()->active()->latest()->limit(8)->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    protected function getMainCategories()
    {
        try {
            return Category::active()
                ->whereNull('parent_id')
                ->with(['children' => fn($q) => $q->active()])
                ->orderBy('sort_order')
                ->orderBy('name_ar')
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    protected function getNewProducts()
    {
        try {
            return Product::active()->inStock()->latest()->limit(12)->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    protected function getSpecialOfferProducts()
    {
        try {
            return Product::activeOffers()
                ->inStock()
                ->orderBy('priority', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    protected function getDiscountedProducts()
    {
        try {
            return Product::onSale()
                ->inStock()
                ->orderByRaw('(price - sale_price) / price DESC')
                ->limit(6)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }
}

