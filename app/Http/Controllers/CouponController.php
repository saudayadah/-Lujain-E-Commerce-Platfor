<?php

namespace App\Http\Controllers;

use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(protected CouponService $couponService)
    {
    }

    /**
     * تطبيق الكوبون
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        // الحصول على السلة
        $cartService = app(\App\Services\CartService::class);
        $cart = $cartService->getCartWithDetails();

        if (empty($cart['items'])) {
            return response()->json([
                'success' => false,
                'message' => 'السلة فارغة',
            ], 400);
        }

        // تطبيق الكوبون
        $result = $this->couponService->validateAndApply(
            $request->code,
            $cart['subtotal'],
            auth()->user()
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'discount' => $result['discount'],
                'coupon' => [
                    'code' => $result['coupon']->code,
                    'type_text' => $result['coupon']->type_text,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 400);
    }

    /**
     * إزالة الكوبون
     */
    public function remove()
    {
        $this->couponService->remove();

        return response()->json([
            'success' => true,
            'message' => 'تم إزالة الكوبون',
        ]);
    }
}
