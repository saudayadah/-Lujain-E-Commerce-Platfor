<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MoyasarPaymentGateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected MoyasarPaymentGateway $moyasar)
    {
    }

    public function callback(Request $request)
    {
        try {
            $orderId = $request->query('order_id');
            $paymentId = $request->query('id');
            $status = $request->query('status');

            if (!$orderId || !$paymentId) {
                return redirect()->route('checkout.cancel')
                    ->with('error', 'بيانات الدفع غير صحيحة');
            }

            $order = Order::findOrFail($orderId);

            if ($status === 'paid') {
                $paymentResult = $this->moyasar->processPayment(['id' => $paymentId]);

                if ($paymentResult['success']) {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'confirmed_at' => now(),
                    ]);

                    return redirect()->route('checkout.success', ['order' => $order->id])
                        ->with('success', 'تم الدفع بنجاح!');
                }
            }

            $order->update(['payment_status' => 'failed']);

            return redirect()->route('checkout.cancel')
                ->with('error', 'فشلت عملية الدفع. الرجاء المحاولة مرة أخرى.');

        } catch (\Exception $e) {
            \Log::error('Payment callback error: ' . $e->getMessage());
            
            return redirect()->route('checkout.cancel')
                ->with('error', 'حدث خطأ أثناء معالجة الدفع');
        }
    }

    public function webhook(Request $request)
    {
        try {
            $signature = $request->header('X-Moyasar-Signature');
            $payload = $request->all();

            if (!$this->moyasar->verifyWebhook($payload, $signature)) {
                \Log::warning('Invalid webhook signature');
                return response()->json(['error' => 'Invalid signature'], 401);
            }

            $result = $this->moyasar->handleWebhook($payload);

            return response()->json($result);

        } catch (\Exception $e) {
            \Log::error('Webhook error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus(Order $order)
    {
        try {
            $payment = $order->payments()->latest()->first();

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على معلومات الدفع',
                ]);
            }

            return response()->json([
                'success' => true,
                'payment_status' => $order->payment_status,
                'order_status' => $order->status,
                'payment' => $payment,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

