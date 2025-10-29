<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name_ar',
        'name_en',
        'slug',
        'description_ar',
        'description_en',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name_en ?: $category->name_ar);
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getName()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getDescription()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getActiveProductsCount()
    {
        return $this->products()->where('status', 'active')->count();
    }

    public function getAllProductsCount()
    {
        $count = $this->products()->count();
        foreach ($this->children as $child) {
            $count += $child->getAllProductsCount();
        }
        return $count;
    }

    public function getAllChildrenIds()
    {
        $ids = [];
        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllChildrenIds());
        }
        return $ids;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeHasActiveProducts($query)
    {
        return $query->whereHas('products', function($q) {
            $q->where('status', 'active')->where('stock', '>', 0);
        });
    }

    public function scopeHasProducts($query)
    {
        return $query->whereHas('products', function($q) {
            $q->active();
        });
    }

    public function getAllProducts()
    {
        $productIds = [$this->id];
        $productIds = array_merge($productIds, $this->getAllChildrenIds());

        return Product::whereIn('category_id', $productIds)
            ->active()
            ->inStock()
            ->get();
    }

    public function getBreadcrumbs()
    {
        $breadcrumbs = [];
        $category = $this;

        while ($category) {
            array_unshift($breadcrumbs, $category);
            $category = $category->parent;
        }

        return $breadcrumbs;
    }
}

