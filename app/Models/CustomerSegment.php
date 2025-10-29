<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CustomerSegment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'conditions',
        'is_dynamic',
        'last_calculated_at',
        'customer_count',
        'is_active',
        'created_by',
        'color',
        'icon',
    ];

    protected $casts = [
        'conditions' => 'array',
        'is_dynamic' => 'boolean',
        'is_active' => 'boolean',
        'last_calculated_at' => 'datetime',
    ];

    // علاقة مع العملاء في هذه الشريحة
    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'customer_segment_assignments')
                    ->withTimestamps();
    }

    // علاقة مع منشئ الشريحة
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDynamic($query)
    {
        return $query->where('is_dynamic', true);
    }

    public function scopeStatic($query)
    {
        return $query->where('is_dynamic', false);
    }

    // حساب عدد العملاء في الشريحة
    public function calculateCustomerCount(): int
    {
        if ($this->is_dynamic) {
            // حساب ديناميكي بناءً على الشروط
            $count = $this->applyConditions()->count();
        } else {
            // حساب ثابت من الجدول الوسيط
            $count = $this->customers()->count();
        }

        $this->update([
            'customer_count' => $count,
            'last_calculated_at' => now(),
        ]);

        return $count;
    }

    // تطبيق شروط الشريحة على العملاء
    public function applyConditions()
    {
        $query = User::query();

        if (isset($this->conditions['min_orders'])) {
            $query->whereHas('orders', function ($q) {
                $q->where('payment_status', 'paid')
                  ->havingRaw('COUNT(*) >= ?', [$this->conditions['min_orders']]);
            }, '>=', $this->conditions['min_orders']);
        }

        if (isset($this->conditions['max_orders'])) {
            $query->whereHas('orders', function ($q) {
                $q->where('payment_status', 'paid')
                  ->havingRaw('COUNT(*) <= ?', [$this->conditions['max_orders']]);
            }, '<=', $this->conditions['max_orders']);
        }

        if (isset($this->conditions['min_spent'])) {
            $query->whereHas('orders', function ($q) {
                $q->where('payment_status', 'paid')
                  ->havingRaw('SUM(total) >= ?', [$this->conditions['min_spent']]);
            });
        }

        if (isset($this->conditions['max_spent'])) {
            $query->whereHas('orders', function ($q) {
                $q->where('payment_status', 'paid')
                  ->havingRaw('SUM(total) <= ?', [$this->conditions['max_spent']]);
            });
        }

        if (isset($this->conditions['last_order_days'])) {
            $days = $this->conditions['last_order_days'];
            $query->whereHas('orders', function ($q) use ($days) {
                $q->where('payment_status', 'paid')
                  ->where('created_at', '>=', now()->subDays($days));
            });
        }

        if (isset($this->conditions['no_orders_days'])) {
            $days = $this->conditions['no_orders_days'];
            $query->whereHas('orders', function ($q) use ($days) {
                $q->where('payment_status', 'paid')
                  ->where('created_at', '<', now()->subDays($days));
            });
        }

        if (isset($this->conditions['categories']) && is_array($this->conditions['categories'])) {
            $query->whereHas('orders.items.product', function ($q) {
                $q->whereIn('category_id', $this->conditions['categories']);
            });
        }

        if (isset($this->conditions['products']) && is_array($this->conditions['products'])) {
            $query->whereHas('orders.items', function ($q) {
                $q->whereIn('product_id', $this->conditions['products']);
            });
        }

        if (isset($this->conditions['registration_date_from'])) {
            $query->where('created_at', '>=', $this->conditions['registration_date_from']);
        }

        if (isset($this->conditions['registration_date_to'])) {
            $query->where('created_at', '<=', $this->conditions['registration_date_to']);
        }

        return $query;
    }

    // إضافة عميل إلى الشريحة
    public function addCustomer(User $user): void
    {
        if (!$this->customers()->where('user_id', $user->id)->exists()) {
            $this->customers()->attach($user->id);
            $this->increment('customer_count');
        }
    }

    // إزالة عميل من الشريحة
    public function removeCustomer(User $user): void
    {
        if ($this->customers()->where('user_id', $user->id)->exists()) {
            $this->customers()->detach($user->id);
            $this->decrement('customer_count');
        }
    }

    // تحديث الشريحة الديناميكية
    public function updateDynamicSegment(): void
    {
        if (!$this->is_dynamic) {
            return;
        }

        $currentCustomers = $this->customers()->pluck('user_id')->toArray();
        $newCustomers = $this->applyConditions()->pluck('id')->toArray();

        // إضافة العملاء الجدد
        $customersToAdd = array_diff($newCustomers, $currentCustomers);
        if (!empty($customersToAdd)) {
            $this->customers()->attach($customersToAdd);
        }

        // إزالة العملاء الذين لم يعودوا ينطبقون عليهم الشروط
        $customersToRemove = array_diff($currentCustomers, $newCustomers);
        if (!empty($customersToRemove)) {
            $this->customers()->detach($customersToRemove);
        }

        $this->update([
            'customer_count' => count($newCustomers),
            'last_calculated_at' => now(),
        ]);
    }

    // أنواع الشرائح المتاحة
    public static function getTypes(): array
    {
        return [
            'behavioral' => 'سلوكية',
            'demographic' => 'ديموغرافية',
            'geographic' => 'جغرافية',
            'psychographic' => 'نفسية',
            'transactional' => 'معاملاتية',
            'custom' => 'مخصصة',
        ];
    }

    // الأيقونات المتاحة للشرائح
    public static function getIcons(): array
    {
        return [
            'users' => 'مجموعة عملاء',
            'star' => 'عملاء مميزين',
            'trending-up' => 'عملاء نشطين',
            'clock' => 'عملاء خاملين',
            'user-plus' => 'عملاء جدد',
            'repeat' => 'عملاء متكررين',
            'alert-triangle' => 'عملاء في خطر',
            'map-pin' => 'عملاء حسب المنطقة',
            'shopping-bag' => 'عملاء حسب المنتجات',
        ];
    }

    // الألوان المتاحة للشرائح
    public static function getColors(): array
    {
        return [
            '#3B82F6', // أزرق
            '#10B981', // أخضر
            '#F59E0B', // أصفر
            '#EF4444', // أحمر
            '#8B5CF6', // بنفسجي
            '#EC4899', // وردي
            '#6B7280', // رمادي
            '#F97316', // برتقالي
        ];
    }
}
