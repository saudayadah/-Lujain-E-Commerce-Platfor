<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name_ar',
        'name_en',
        'sku',
        'price',
        'stock',
        'attributes',
        'is_active',
        'sort_order',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'attributes' => 'array',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'variant_id');
    }

    public function isInStock(): bool
    {
        return $this->stock > 0 && $this->is_active;
    }

    public function getName()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getMainImage()
    {
        return $this->image ?? $this->product->image;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

