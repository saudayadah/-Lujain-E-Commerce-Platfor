<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'sku',
        'name_ar',
        'name_en',
        'slug',
        'description_ar',
        'description_en',
        'price',
        'sale_price',
        'unit',
        'stock',
        'low_stock_alert',
        'image',
        'images',
        'attributes',
        'status',
        'is_featured',
        'is_special_offer',
        'special_offer_start',
        'special_offer_end',
        'special_discount_percentage',
        'is_flash_sale',
        'flash_sale_start',
        'flash_sale_end',
        'badge_text',
        'badge_color',
        'priority',
        'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock' => 'integer',
        'low_stock_alert' => 'integer',
        'images' => 'array',
        'attributes' => 'array',
        'is_featured' => 'boolean',
        'is_special_offer' => 'boolean',
        'special_offer_start' => 'datetime',
        'special_offer_end' => 'datetime',
        'special_discount_percentage' => 'decimal:2',
        'is_flash_sale' => 'boolean',
        'flash_sale_start' => 'datetime',
        'flash_sale_end' => 'datetime',
        'priority' => 'integer',
        'views' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name_en ?: $product->name_ar);
            }
            if (empty($product->sku)) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function getName()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getDescription()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getCurrentPrice()
    {
        return $this->sale_price ?? $this->price;
    }

    public function hasDiscount(): bool
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    public function getDiscountPercentage(): int
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function isInStock(): bool
    {
        return $this->stock > 0 && $this->status === 'active';
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_alert && $this->stock > 0;
    }

    public function getMainImage()
    {
        return $this->images[0] ?? null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')->whereRaw('sale_price < price');
    }

    public function scopeSpecialOffers($query)
    {
        return $query->where('is_special_offer', true)
                    ->where(function($q) {
                        $q->whereNull('special_offer_end')
                          ->orWhere('special_offer_end', '>', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('special_offer_start')
                          ->orWhere('special_offer_start', '<=', now());
                    });
    }

    public function scopeFlashSale($query)
    {
        return $query->where('is_flash_sale', true)
                    ->where(function($q) {
                        $q->whereNull('flash_sale_end')
                          ->orWhere('flash_sale_end', '>', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('flash_sale_start')
                          ->orWhere('flash_sale_start', '<=', now());
                    });
    }

    public function scopeActiveOffers($query)
    {
        return $query->where(function($q) {
            $q->where('is_special_offer', true)
              ->where(function($qq) {
                  $qq->whereNull('special_offer_end')
                    ->orWhere('special_offer_end', '>', now());
              })
              ->where(function($qq) {
                  $qq->whereNull('special_offer_start')
                    ->orWhere('special_offer_start', '<=', now());
              });
        })->orWhere(function($q) {
            $q->where('is_flash_sale', true)
              ->where(function($qq) {
                  $qq->whereNull('flash_sale_end')
                    ->orWhere('flash_sale_end', '>', now());
              })
              ->where(function($qq) {
                  $qq->whereNull('flash_sale_start')
                    ->orWhere('flash_sale_start', '<=', now());
              });
        })->orWhere(function($q) {
            $q->whereNotNull('sale_price')
              ->whereRaw('sale_price < price');
        });
    }

    public function isSpecialOfferActive(): bool
    {
        if (!$this->is_special_offer) return false;

        $now = now();
        $start = $this->special_offer_start;
        $end = $this->special_offer_end;

        return ($start === null || $start <= $now) && ($end === null || $end > $now);
    }

    public function isFlashSaleActive(): bool
    {
        if (!$this->is_flash_sale) return false;

        $now = now();
        $start = $this->flash_sale_start;
        $end = $this->flash_sale_end;

        return ($start === null || $start <= $now) && ($end === null || $end > $now);
    }

    public function getCurrentOfferDiscount(): float
    {
        if ($this->isSpecialOfferActive() && $this->special_discount_percentage) {
            return $this->special_discount_percentage;
        }

        if ($this->isFlashSaleActive()) {
            return $this->getDiscountPercentage();
        }

        return $this->getDiscountPercentage();
    }

    public function getCurrentOfferPrice(): float
    {
        $discount = $this->getCurrentOfferDiscount();
        return $this->price * (1 - $discount / 100);
    }

    public function getOfferBadge(): array
    {
        if ($this->isFlashSaleActive()) {
            return [
                'text' => 'تخفيضات سريعة',
                'color' => '#ef4444',
                'icon' => 'fas fa-bolt'
            ];
        }

        if ($this->isSpecialOfferActive()) {
            return [
                'text' => $this->badge_text ?: 'عرض خاص',
                'color' => $this->badge_color,
                'icon' => 'fas fa-star'
            ];
        }

        if ($this->hasDiscount()) {
            return [
                'text' => 'خصم ' . $this->getDiscountPercentage() . '%',
                'color' => '#10b981',
                'icon' => 'fas fa-tag'
            ];
        }

        return null;
    }

    public function getOfferTimeRemaining(): ?array
    {
        if ($this->isFlashSaleActive() && $this->flash_sale_end) {
            $now = now();
            $end = $this->flash_sale_end;

            if ($end > $now) {
                $diff = $now->diff($end);
                return [
                    'days' => $diff->days,
                    'hours' => $diff->h,
                    'minutes' => $diff->i,
                    'seconds' => $diff->s
                ];
            }
        }

        if ($this->isSpecialOfferActive() && $this->special_offer_end) {
            $now = now();
            $end = $this->special_offer_end;

            if ($end > $now) {
                $diff = $now->diff($end);
                return [
                    'days' => $diff->days,
                    'hours' => $diff->h,
                    'minutes' => $diff->i,
                    'seconds' => $diff->s
                ];
            }
        }

        return null;
    }

    public function getAllImages()
    {
        $images = [];
        if ($this->image) {
            $images[] = $this->image;
        }
        if ($this->images) {
            $images = array_merge($images, $this->images);
        }
        return array_unique($images);
    }

    public function getRelatedProducts($limit = 4)
    {
        return self::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->active()
            ->inStock()
            ->limit($limit)
            ->get();
    }
}

