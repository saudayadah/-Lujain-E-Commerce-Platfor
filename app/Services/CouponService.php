<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class CouponService
{
    /**
     * التحقق من صلاحية الكوبون وتطبيقه
     */
    public function validateAndApply(string $code, float $subtotal, ?User $user = null): array
    {
        $coupon = Coupon::where('code', strtoupper($code))->first();

        if (!$coupon) {
            return [
                'success' => false,
                'message' => 'كود الكوبون غير صحيح',
            ];
        }

        // التحقق من صلاحية الكوبون
        if (!$coupon->isValid()) {
            return [
                'success' => false,
                'message' => 'هذا الكوبون غير صالح أو منتهي الصلاحية',
            ];
        }

        // التحقق من الحد الأدنى للطلب
        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return [
                'success' => false,
                'message' => 'الحد الأدنى للطلب لاستخدام هذا الكوبون هو ' . number_format($coupon->min_order_amount, 2) . ' ر.س',
            ];
        }

        // التحقق من استخدام المستخدم (إذا كان مسجل دخول)
        if ($user && !$coupon->canBeUsedBy($user)) {
            return [
                'success' => false,
                'message' => 'لقد استنفدت عدد مرات استخدام هذا الكوبون',
            ];
        }

        // حساب قيمة الخصم
        $discount = $coupon->calculateDiscount($subtotal);

        // حفظ في الجلسة
        Session::put('applied_coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $discount,
        ]);

        return [
            'success' => true,
            'message' => 'تم تطبيق الكوبون بنجاح! خصم ' . number_format($discount, 2) . ' ر.س',
            'discount' => $discount,
            'coupon' => $coupon,
        ];
    }

    /**
     * إزالة الكوبون من الجلسة
     */
    public function remove(): void
    {
        Session::forget('applied_coupon');
    }

    /**
     * الحصول على الكوبون المطبق من الجلسة
     */
    public function getAppliedCoupon(): ?array
    {
        return Session::get('applied_coupon');
    }

    /**
     * الحصول على قيمة الخصم
     */
    public function getDiscount(): float
    {
        $coupon = $this->getAppliedCoupon();
        return $coupon ? $coupon['discount'] : 0;
    }

    /**
     * تطبيق الكوبون على الطلب (بعد إنشائه)
     *
     * ⚠️ ملاحظة: يجب استدعاء هذه الدالة داخل DB::transaction()
     * لضمان أن تسجيل الاستخدام وتحديث الطلب يحدثان atomically
     * 
     * مثال:
     * DB::transaction(function() {
     *     $order = $this->orderService->createOrder(...);
     *     $this->couponService->applyToOrder($order, $user); // ✅ داخل transaction
     * });
     * 
     * @param \App\Models\Order $order
     * @param User $user
     * @return void
     */
    public function applyToOrder(\App\Models\Order $order, User $user): void
    {
        $appliedCoupon = $this->getAppliedCoupon();

        if (!$appliedCoupon) {
            return;
        }

        $coupon = Coupon::find($appliedCoupon['id']);

        if ($coupon) {
            // تسجيل استخدام الكوبون
            $coupon->recordUsage($user, $order, $appliedCoupon['discount']);
            
            // تحديث الطلب
            $order->update([
                'coupon_code' => $coupon->code,
                'discount' => $appliedCoupon['discount'],
            ]);
        }

        // إزالة من الجلسة بعد الاستخدام
        $this->remove();
    }
}
