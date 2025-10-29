<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount',
        'usage_limit',
        'usage_count',
        'per_user_limit',
        'starts_at',
        'expires_at',
        'is_active',
        'description',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * المستخدمين الذين استخدموا الكوبون
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user')
            ->withPivot(['order_id', 'discount_amount'])
            ->withTimestamps();
    }

    /**
     * الطلبات المستخدم فيها الكوبون
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'coupon_user')
            ->withPivot(['user_id', 'discount_amount'])
            ->withTimestamps();
    }

    /**
     * التحقق من صلاحية الكوبون
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // التحقق من تاريخ البداية
        if ($this->starts_at && Carbon::now()->lt($this->starts_at)) {
            return false;
        }

        // التحقق من تاريخ الانتهاء
        if ($this->expires_at && Carbon::now()->gt($this->expires_at)) {
            return false;
        }

        // التحقق من عدد الاستخدامات
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * التحقق من إمكانية استخدام الكوبون من قبل مستخدم معين
     */
    public function canBeUsedBy(User $user): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        $userUsageCount = $this->users()
            ->where('user_id', $user->id)
            ->count();

        return $userUsageCount < $this->per_user_limit;
    }

    /**
     * حساب قيمة الخصم بناءً على المبلغ
     */
    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'percentage') {
            $discount = ($amount * $this->value) / 100;
            
            // تطبيق الحد الأقصى إن وجد
            if ($this->max_discount) {
                $discount = min($discount, $this->max_discount);
            }
            
            return round($discount, 2);
        }

        // Fixed amount
        return min($this->value, $amount);
    }

    /**
     * Scope للكوبونات النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', Carbon::now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', Carbon::now());
            });
    }

    /**
     * Scope للكوبونات المنتهية
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', Carbon::now());
    }

    /**
     * زيادة عداد الاستخدام
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * تسجيل استخدام الكوبون
     */
    public function recordUsage(User $user, Order $order, float $discountAmount): void
    {
        $this->users()->attach($user->id, [
            'order_id' => $order->id,
            'discount_amount' => $discountAmount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->incrementUsage();
    }

    /**
     * الحصول على نص نوع الخصم
     */
    public function getTypeTextAttribute(): string
    {
        return $this->type === 'percentage' 
            ? $this->value . '%' 
            : number_format($this->value, 2) . ' ر.س';
    }

    /**
     * الحصول على حالة الكوبون
     */
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'معطل';
        }

        if ($this->expires_at && Carbon::now()->gt($this->expires_at)) {
            return 'منتهي';
        }

        if ($this->starts_at && Carbon::now()->lt($this->starts_at)) {
            return 'لم يبدأ';
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return 'مكتمل';
        }

        return 'نشط';
    }
}
