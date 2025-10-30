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

    /**
     * العلاقة مع التصنيف
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * العلاقة مع تنويعات المنتج
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * العلاقة مع عناصر الطلبات
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * العلاقة مع حركات المخزون
     */
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    /**
     * الحصول على اسم المنتج حسب اللغة
     */
    public function getName(): string
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * الحصول على وصف المنتج حسب اللغة
     */
    public function getDescription(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    /**
     * الحصول على السعر الحالي (مع الخصم إن وُجد)
     */
    public function getCurrentPrice(): float
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * التحقق من وجود خصم على المنتج
     */
    public function hasDiscount(): bool
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    /**
     * الحصول على نسبة الخصم
     */
    public function getDiscountPercentage(): int
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    /**
     * التحقق من توفر المنتج في المخزون
     */
    public function isInStock(): bool
    {
        return $this->stock > 0 && $this->status === 'active';
    }

    /**
     * التحقق من أن المخزون منخفض
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_alert && $this->stock > 0;
    }

    /**
     * الحصول على الصورة الرئيسية
     */
    public function getMainImage(): ?string
    {
        if (!empty($this->image)) {
            return $this->image;
        }
        if (is_array($this->images) && !empty($this->images)) {
            return $this->images[0];
        }
        return null;
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
        
        // 🛡️ التأكد من أن الخصم لا يتجاوز 100% لمنع الأسعار السالبة
        $discount = min(100, max(0, $discount));
        
        $finalPrice = $this->price * (1 - $discount / 100);
        
        // 🛡️ التأكد من أن السعر النهائي ليس سالبًا أو صفر
        return max(0, $finalPrice);
    }

    /**
     * الحصول على شارة العرض (Badge)
     */
    public function getOfferBadge(): ?array
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

    /**
     * الحصول على جميع صور المنتج
     */
    public function getAllImages(): array
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

    /**
     * الحصول على المنتجات المشابهة
     */
    public function getRelatedProducts(int $limit = 4)
    {
        return self::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->active()
            ->inStock()
            ->limit($limit)
            ->get();
    }
}

