<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('profile.index', compact('user', 'orders'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
        ], [
            'name.required' => 'الاسم الكامل مطلوب',
            'name.max' => 'الاسم الكامل يجب أن لا يتجاوز 255 حرف',
            'phone.max' => 'رقم الجوال يجب أن لا يتجاوز 20 رقم',
            'address.max' => 'العنوان يجب أن لا يتجاوز 500 حرف',
            'city.max' => 'المدينة يجب أن لا تتجاوز 100 حرف',
        ]);

        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'تم تحديث البيانات بنجاح ✓');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة',
            'password.required' => 'كلمة المرور الجديدة مطلوبة',
            'password.min' => 'يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل',
            'password.confirmed' => 'كلمة المرور الجديدة وتأكيد كلمة المرور غير متطابقتين',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.index')->with('success', 'تم تغيير كلمة المرور بنجاح ✓');
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('profile.orders', compact('orders'));
    }

    public function orderDetails(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'غير مصرح لك بعرض هذا الطلب');
        }

        $order->load(['items.product', 'payments']);

        return view('profile.order-details', compact('order'));
    }
}

