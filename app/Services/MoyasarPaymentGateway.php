<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Moyasar\Moyasar;
use Moyasar\Providers\PaymentService;

class MoyasarPaymentGateway implements PaymentGatewayInterface
{
    protected PaymentService $moyasar;
    protected string $apiKey;
    protected string $publishableKey;
    protected string $callbackUrl;
    protected string $webhookSecret;

    public function __construct()
    {
        $this->apiKey = config('payment.moyasar.secret_key') ?? '';
        $this->publishableKey = config('payment.moyasar.publishable_key') ?? '';
        $this->callbackUrl = config('payment.moyasar.callback_url') ?? '';
        $this->webhookSecret = config('payment.moyasar.webhook_secret') ?? '';

        Moyasar::setApiKey($this->apiKey);
        $this->moyasar = new PaymentService();
    }

    public function createPayment(Order $order, array $data = []): array
    {
        try {
            $payment = $this->moyasar->create([
                'amount' => (int)($order->total * 100), // Convert to halalas
                'currency' => 'SAR',
                'description' => "Order #{$order->order_number}",
                'callback_url' => $this->callbackUrl . '?order_id=' . $order->id,
                'source' => [
                    'type' => 'creditcard',
                ],
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_email' => $order->user->email ?? '',
                    'customer_name' => $order->user->name ?? '',
                ],
            ]);

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'moyasar',
                'transaction_id' => $payment->id,
                'amount' => $order->total,
                'currency' => 'SAR',
                'status' => 'initiated',
                'payment_data' => $payment,
            ]);

            return [
                'success' => true,
                'payment_id' => $payment->id,
                'payment_url' => "https://moyasar.com/pay/{$payment->id}",
                'payment_data' => $payment,
            ];
        } catch (\Exception $e) {
            \Log::error('Moyasar payment initiation failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'فشل في إنشاء عملية الدفع. الرجاء المحاولة مرة أخرى.',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function verifyPayment(string $transactionId): array
    {
        try {
            if (!$transactionId) {
                throw new \Exception('Payment ID is missing');
            }

            $payment = $this->moyasar->fetch($transactionId);
            
            if ($payment->status === 'paid') {
                return [
                    'success' => true,
                    'status' => 'completed',
                    'transaction_id' => $payment->id,
                    'amount' => $payment->amount / 100,
                    'payment_method' => $payment->source->type ?? 'creditcard',
                    'payment_data' => $payment,
                ];
            }

            return [
                'success' => false,
                'status' => $payment->status,
                'message' => 'الدفع لم يتم بنجاح',
            ];
        } catch (\Exception $e) {
            \Log::error('Moyasar payment processing failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'فشل في معالجة الدفع',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function refund(string $transactionId, float $amount): array
    {
        try {
            $refund = $this->moyasar->refund($transactionId, [
                'amount' => (int)($amount * 100),
            ]);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'status' => $refund->status,
                'amount' => $refund->amount / 100,
            ];
        } catch (\Exception $e) {
            \Log::error('Moyasar refund failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'فشل في استرجاع المبلغ',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function verifyWebhook(array $payload, string $signature): bool
    {
        $computedSignature = hash_hmac('sha256', json_encode($payload), $this->webhookSecret);
        return hash_equals($computedSignature, $signature);
    }

    public function handleWebhook(array $payload): array
    {
        try {
            $eventType = $payload['type'] ?? null;
            $paymentData = $payload['data'] ?? [];

            if ($eventType === 'payment_paid') {
                $orderId = $paymentData['metadata']['order_id'] ?? null;
                
                if (!$orderId) {
                    throw new \Exception('Order ID not found in webhook');
                }

                $order = Order::find($orderId);
                
                if (!$order) {
                    throw new \Exception('Order not found');
                }

                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                ]);

                Payment::where('transaction_id', $paymentData['id'])
                    ->update([
                        'status' => 'completed',
                        'payment_data' => $paymentData,
                    ]);

                return [
                    'success' => true,
                    'message' => 'Webhook processed successfully',
                ];
            }

            if ($eventType === 'payment_failed') {
                $orderId = $paymentData['metadata']['order_id'] ?? null;
                
                if ($orderId) {
                    $order = Order::find($orderId);
                    
                    if ($order) {
                        $order->update(['payment_status' => 'failed']);
                    }

                    Payment::where('transaction_id', $paymentData['id'])
                        ->update(['status' => 'failed']);
                }

                return [
                    'success' => true,
                    'message' => 'Payment failed webhook processed',
                ];
            }

            return [
                'success' => true,
                'message' => 'Webhook received but not processed',
            ];
        } catch (\Exception $e) {
            \Log::error('Moyasar webhook handling failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Webhook processing failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getPublishableKey(): string
    {
        return $this->publishableKey;
    }
}

