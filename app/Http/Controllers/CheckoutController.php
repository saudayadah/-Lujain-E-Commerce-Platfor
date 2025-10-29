<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Services\MoyasarPaymentGateway;
use App\Services\ZATCAService;
use App\Services\CouponService;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService,
        protected MoyasarPaymentGateway $moyasar,
        protected CouponService $couponService
    ) {
    }

    public function index()
    {
        try {
            $cart = $this->cartService->getCartWithDetails();
            
            if (empty($cart['items'])) {
                return redirect()->route('cart.index')
                    ->with('error', 'السلة فارغة. يرجى إضافة منتجات أولاً');
            }
            
            return view('checkout.index', compact('cart'));
        } catch (\Exception $e) {
            Log::error('CheckoutController@index: ' . $e->getMessage());
            return redirect()->route('cart.index')
                ->with('error', 'حدث خطأ أثناء تحميل صفحة الدفع');
        }
    }

    public function process(CheckoutRequest $request)
    {
        try {
            $cart = $this->cartService->getCartWithDetails();
            
            if (empty($cart['items'])) {
                return redirect()->route('cart.index')
                    ->with('error', 'السلة فارغة. يرجى إضافة منتجات أولاً');
            }

            DB::beginTransaction();

            $order = $this->orderService->createOrder([
                'subtotal' => $cart['subtotal'],
                'tax' => $cart['tax'],
                'discount' => $cart['discount'] ?? 0,
                'total' => $cart['total'],
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ], $cart['items']);

            if ($cart['discount'] > 0 && isset($cart['coupon'])) {
                $this->couponService->applyToOrder($order, auth()->user());
            }

            // إنشاء فاتورة ZATCA بشكل غير متزامن
            try {
                ZATCAService::createInvoice($order);
            } catch (\Exception $e) {
                Log::warning('Failed to create ZATCA invoice: ' . $e->getMessage(), [
                    'order_id' => $order->id,
                ]);
            }

            $this->cartService->clear();
            DB::commit();

            if ($request->payment_method === 'online') {
                return $this->handleOnlinePayment($order);
            }

            return $this->handleCashOnDelivery($order);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CheckoutController@process: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('checkout.index')
                ->with('error', 'حدث خطأ أثناء معالجة الطلب. يرجى المحاولة مرة أخرى');
        }
    }

    protected function handleOnlinePayment($order)
    {
        try {
            $paymentResult = $this->moyasar->initiatePayment($order);
            
            if ($paymentResult['success'] ?? false) {
                return redirect($paymentResult['payment_url']);
            }
            
            return redirect()->route('checkout.cancel')
                ->with('error', $paymentResult['message'] ?? 'فشل في إنشاء عملية الدفع');
        } catch (\Exception $e) {
            Log::error('Online payment initiation failed: ' . $e->getMessage());
            return redirect()->route('checkout.index')
                ->with('error', 'فشل في إنشاء عملية الدفع. يرجى المحاولة مرة أخرى');
        }
    }

    protected function handleCashOnDelivery($order)
    {
        $order->update([
            'status' => 'confirmed',
            'payment_status' => 'pending',
            'confirmed_at' => now(),
        ]);

        return redirect()->route('checkout.success', ['order' => $order->id])
            ->with('success', 'تم إنشاء طلبك بنجاح. سيتم التواصل معك قريباً');
    }

    public function success($orderId = null)
    {
        $order = null;
        if ($orderId) {
            $order = \App\Models\Order::where('id', $orderId)
                ->where('user_id', auth()->id())
                ->first();
        }
        
        return view('checkout.success', compact('order'));
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}

