<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    /**
     * عرض قائمة العملاء
     */
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin')
                    ->orWhereNull('role');

        // البحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // الترتيب
        $sortBy = $request->get('sort', 'newest');
        switch($sortBy) {
            case 'name':
                $query->orderBy('name', 'ASC');
                break;
            case 'orders':
                $query->withCount('orders')
                      ->orderBy('orders_count', 'DESC');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $customers = $query->withCount('orders')
                          ->with(['orders' => function($q) {
                              $q->latest()->take(5);
                          }])
                          ->paginate(20);

        // إحصائيات
        $stats = [
            'total_customers' => User::where('role', '!=', 'admin')
                ->orWhereNull('role')
                ->count(),
            'active_customers' => User::where(function($q) {
                    $q->where('role', '!=', 'admin')->orWhereNull('role');
                })
                ->whereHas('orders', function($q) {
                    $q->where('created_at', '>=', now()->subDays(30));
                })->count(),
            'new_this_month' => User::where(function($q) {
                    $q->where('role', '!=', 'admin')->orWhereNull('role');
                })
                ->whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    /**
     * عرض تفاصيل عميل
     */
    public function show(User $customer)
    {
        // التأكد من أنه ليس أدمن
        if ($customer->isAdmin()) {
            abort(404);
        }

        $customer->load(['orders' => function($q) {
            $q->latest();
        }]);

        // إحصائيات العميل
        $stats = [
            'total_orders' => $customer->orders()->count(),
            'total_spent' => $customer->orders()->where('payment_status', 'paid')->sum('total'),
            'pending_orders' => $customer->orders()->where('status', 'pending')->count(),
            'completed_orders' => $customer->orders()->where('status', 'delivered')->count(),
            'last_order' => $customer->orders()->latest()->first(),
        ];

        return view('admin.customers.show', compact('customer', 'stats'));
    }

    /**
     * تعديل عميل
     */
    public function edit(User $customer)
    {
        if ($customer->isAdmin()) {
            abort(404);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * تحديث بيانات عميل
     */
    public function update(Request $request, User $customer)
    {
        if ($customer->isAdmin()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
        ]);

        $customer->update($validated);

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with('success', 'تم تحديث بيانات العميل بنجاح');
    }

    /**
     * حذف عميل
     */
    public function destroy(User $customer)
    {
        if ($customer->isAdmin()) {
            abort(403);
        }

        $name = $customer->name;
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', "تم حذف العميل {$name} بنجاح");
    }
}
