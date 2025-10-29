<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

trait HasProductFiltering
{
    /**
     * تطبيق فلاتر البحث على استعلام المنتجات
     */
    protected function applyProductFilters(Builder $query, $request = null): Builder
    {
        $request = $request ?? request();

        // البحث النصي
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%")
                  ->orWhere('description_ar', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // الفئة
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // التصنيفات الفرعية
        if ($request->filled('subcategories')) {
            $subcategoryIds = is_array($request->subcategories) 
                ? $request->subcategories 
                : explode(',', $request->subcategories);
            $query->whereIn('category_id', $subcategoryIds);
        }

        // نطاق السعر
        if ($request->filled('min_price')) {
            $query->whereRaw('COALESCE(sale_price, price) >= ?', [$request->min_price]);
        }

        if ($request->filled('max_price')) {
            $query->whereRaw('COALESCE(sale_price, price) <= ?', [$request->max_price]);
        }

        // المنتجات المتوفرة فقط
        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0)->where('status', 'active');
        }

        // المنتجات المخفضة فقط
        if ($request->boolean('on_sale')) {
            $query->whereNotNull('sale_price')
                  ->whereRaw('sale_price < price');
        }

        return $query;
    }

    /**
     * تطبيق الترتيب على استعلام المنتجات
     */
    protected function applyProductSorting(Builder $query, string $sortBy = 'newest'): Builder
    {
        switch ($sortBy) {
            case 'price_low':
                return $query->orderByRaw('COALESCE(sale_price, price) ASC');
            case 'price_high':
                return $query->orderByRaw('COALESCE(sale_price, price) DESC');
            case 'name':
                return $query->orderBy('name_ar', 'ASC');
            case 'popular':
                return $query->orderBy('views', 'DESC');
            case 'newest':
            default:
                return $query->latest();
        }
    }

    /**
     * الحصول على إحصائيات الأسعار للفلترة
     */
    protected function getPriceRange(): array
    {
        try {
            $minPrice = Product::min(\DB::raw('COALESCE(sale_price, price)')) ?? 0;
            $maxPrice = Product::max(\DB::raw('COALESCE(sale_price, price)')) ?? 1000;
        } catch (\Exception $e) {
            $minPrice = 0;
            $maxPrice = 1000;
        }

        return [$minPrice, $maxPrice];
    }
}

