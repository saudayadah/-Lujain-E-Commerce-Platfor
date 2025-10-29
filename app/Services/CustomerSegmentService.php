<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

/**
 * خدمة تقسيم العملاء (Customer Segmentation)
 * لاستهداف العملاء بالحملات التسويقية
 */
class CustomerSegmentService
{
    /**
     * الحصول على العملاء VIP (ذوي القيمة العالية)
     */
    public function getVIPCustomers(float $minSpent = 5000): Collection
    {
        return User::select('users.*')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('users.id')
            ->havingRaw('SUM(orders.total) >= ?', [$minSpent])
            ->get();
    }

    /**
     * العملاء النشطين (اشتروا في آخر 30 يوم)
     */
    public function getActiveCustomers(int $days = 30): Collection
    {
        return User::whereHas('orders', function ($query) use ($days) {
            $query->where('created_at', '>=', now()->subDays($days))
                  ->where('payment_status', 'paid');
        })->get();
    }

    /**
     * العملاء الخاملين (لم يشتروا منذ فترة)
     */
    public function getInactiveCustomers(int $days = 90): Collection
    {
        return User::whereHas('orders')
            ->whereDoesntHave('orders', function ($query) use ($days) {
                $query->where('created_at', '>=', now()->subDays($days));
            })->get();
    }

    /**
     * العملاء الجدد (أول طلب خلال آخر 7 أيام)
     */
    public function getNewCustomers(int $days = 7): Collection
    {
        return User::whereHas('orders', function ($query) use ($days) {
            $query->where('created_at', '>=', now()->subDays($days))
                  ->whereRaw('orders.id = (SELECT MIN(id) FROM orders WHERE orders.user_id = users.id)');
        })->get();
    }

    /**
     * العملاء المتكررين (أكثر من طلب واحد)
     */
    public function getRepeatCustomers(int $minOrders = 2): Collection
    {
        return User::select('users.*')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('users.id')
            ->havingRaw('COUNT(orders.id) >= ?', [$minOrders])
            ->get();
    }

    /**
     * العملاء المهددين بالمغادرة (اشتروا سابقاً لكن توقفوا)
     */
    public function getChurnRiskCustomers(): Collection
    {
        // العملاء الذين اشتروا منذ 60-120 يوم ولم يشتروا مؤخراً
        return User::whereHas('orders', function ($query) {
            $query->whereBetween('created_at', [now()->subDays(120), now()->subDays(60)])
                  ->where('payment_status', 'paid');
        })
        ->whereDoesntHave('orders', function ($query) {
            $query->where('created_at', '>=', now()->subDays(60));
        })->get();
    }

    /**
     * العملاء حسب المنتج المشترى
     */
    public function getCustomersByProduct(int $productId): Collection
    {
        return User::whereHas('orders.items', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })->get();
    }

    /**
     * العملاء حسب الفئة
     */
    public function getCustomersByCategory(int $categoryId): Collection
    {
        return User::whereHas('orders.items.product', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->get();
    }

    /**
     * العملاء حسب المدينة
     */
    public function getCustomersByCity(string $city): Collection
    {
        return User::where('city', $city)
            ->whereHas('orders')
            ->get();
    }

    /**
     * العملاء حسب نطاق الإنفاق
     */
    public function getCustomersBySpendingRange(float $min, float $max): Collection
    {
        return User::select('users.*')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('users.id')
            ->havingRaw('SUM(orders.total) BETWEEN ? AND ?', [$min, $max])
            ->get();
    }

    /**
     * العملاء الذين تركوا السلة (Cart Abandonment)
     */
    public function getCartAbandonmentCustomers(): Collection
    {
        // هذا يتطلب تتبع السلات المهجورة
        // يمكن تنفيذه لاحقاً
        return collect([]);
    }

    /**
     * تحليل شامل للعميل
     */
    public function getCustomerAnalytics(User $user): array
    {
        $orders = $user->orders()->where('payment_status', 'paid')->get();
        
        return [
            'total_orders' => $orders->count(),
            'total_spent' => $orders->sum('total'),
            'average_order_value' => $orders->avg('total'),
            'first_order_date' => $orders->min('created_at'),
            'last_order_date' => $orders->max('created_at'),
            'customer_lifetime_days' => $orders->min('created_at') 
                ? now()->diffInDays($orders->min('created_at')) 
                : 0,
            'favorite_categories' => $this->getFavoriteCategories($user),
            'favorite_products' => $this->getFavoriteProducts($user),
            'segment' => $this->getCustomerSegment($user),
            'churn_risk' => $this->calculateChurnRisk($user),
        ];
    }

    /**
     * الفئات المفضلة للعميل
     */
    protected function getFavoriteCategories(User $user): array
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.user_id', $user->id)
            ->where('orders.payment_status', 'paid')
            ->select('categories.name_ar', 'categories.name_en', DB::raw('COUNT(*) as count'))
            ->groupBy('categories.id', 'categories.name_ar', 'categories.name_en')
            ->orderByDesc('count')
            ->limit(3)
            ->get()
            ->toArray();
    }

    /**
     * المنتجات المفضلة للعميل
     */
    protected function getFavoriteProducts(User $user): array
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $user->id)
            ->where('orders.payment_status', 'paid')
            ->select('product_id', 'product_name', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get()
            ->toArray();
    }

    /**
     * تحديد شريحة العميل
     */
    protected function getCustomerSegment(User $user): string
    {
        $totalSpent = $user->orders()->where('payment_status', 'paid')->sum('total');
        $orderCount = $user->orders()->where('payment_status', 'paid')->count();
        $lastOrderDays = $user->orders()->latest()->first()?->created_at?->diffInDays(now()) ?? 999;

        if ($totalSpent >= 5000 && $orderCount >= 5) {
            return 'VIP';
        } elseif ($totalSpent >= 2000 && $orderCount >= 3) {
            return 'Loyal';
        } elseif ($orderCount >= 2 && $lastOrderDays <= 30) {
            return 'Active';
        } elseif ($orderCount === 1 && $lastOrderDays <= 7) {
            return 'New';
        } elseif ($lastOrderDays >= 90) {
            return 'Inactive';
        } else {
            return 'Regular';
        }
    }

    /**
     * حساب احتمالية ترك العميل
     */
    protected function calculateChurnRisk(User $user): string
    {
        $lastOrderDays = $user->orders()->latest()->first()?->created_at?->diffInDays(now()) ?? 999;
        
        if ($lastOrderDays >= 120) {
            return 'High';
        } elseif ($lastOrderDays >= 60) {
            return 'Medium';
        } else {
            return 'Low';
        }
    }

    /**
     * الحصول على شرائح العملاء مع الإحصائيات
     */
    public function getSegmentStatistics(): array
    {
        return [
            'vip' => [
                'count' => $this->getVIPCustomers()->count(),
                'total_revenue' => $this->getVIPCustomers()->sum(fn($u) => $u->orders()->where('payment_status', 'paid')->sum('total')),
            ],
            'active' => [
                'count' => $this->getActiveCustomers()->count(),
                'percentage' => 0, // سيتم حسابه
            ],
            'inactive' => [
                'count' => $this->getInactiveCustomers()->count(),
                'percentage' => 0,
            ],
            'new' => [
                'count' => $this->getNewCustomers()->count(),
                'percentage' => 0,
            ],
            'repeat' => [
                'count' => $this->getRepeatCustomers()->count(),
                'percentage' => 0,
            ],
            'churn_risk' => [
                'count' => $this->getChurnRiskCustomers()->count(),
                'percentage' => 0,
            ],
        ];
    }
}

