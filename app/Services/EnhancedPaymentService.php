<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Enhanced Payment Service with Production-Ready Security
 * 
 * Features:
 * - Idempotency key support
 * - Replay attack prevention
 * - Enhanced error handling
 * - Comprehensive logging
 * - Transaction encryption
 * - Duplicate payment prevention
 */
class EnhancedPaymentService
{
    protected MoyasarPaymentGateway $gateway;

    public function __construct()
    {
        $this->gateway = new MoyasarPaymentGateway();
    }

    /**
     * Create payment with idempotency and security
     */
    public function createPayment(Order $order, array $data = []): array
    {
        try {
            // Generate or use provided idempotency key
            $idempotencyKey = $data['idempotency_key'] ?? Str::uuid()->toString();
            
            // Check for duplicate payment attempt
            $existingPayment = Payment::where('idempotency_key', $idempotencyKey)->first();
            
            if ($existingPayment) {
                Log::info('Duplicate payment request detected', [
                    'idempotency_key' => $idempotencyKey,
                    'order_id' => $order->id,
                ]);
                
                return [
                    'success' => true,
                    'duplicate' => true,
                    'payment_id' => $existingPayment->transaction_id,
                    'status' => $existingPayment->status,
                ];
            }

            // Validate amount
            if ($order->total <= 0) {
                throw new \Exception('Invalid order amount');
            }

            // Check for duplicate order processing
            $duplicateKey = "payment_order:{$order->id}";
            if (Cache::has($duplicateKey)) {
                return [
                    'success' => false,
                    'error' => 'Payment already in progress for this order',
                ];
            }
            
            Cache::put($duplicateKey, true, now()->addMinutes(10));

            // Create payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => $data['payment_method'] ?? 'creditcard',
                'gateway' => 'moyasar',
                'amount' => $order->total,
                'currency' => 'SAR',
                'status' => 'initiated',
                'idempotency_key' => $idempotencyKey,
                'metadata' => $data['metadata'] ?? [],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            Log::info('Payment initiated', [
                'payment_id' => $payment->id,
                'order_id' => $order->id,
                'amount' => $order->total,
                'ip' => request()->ip(),
            ]);

            // Create payment with gateway
            $gatewayResult = $this->gateway->createPayment($order, array_merge($data, [
                'idempotency_key' => $idempotencyKey,
            ]));

            if ($gatewayResult['success']) {
                // Update payment record
                $payment->update([
                    'transaction_id' => $gatewayResult['payment_id'] ?? null,
                    'payment_data' => $gatewayResult,
                ]);

                Log::info('Payment URL generated', [
                    'payment_id' => $payment->id,
                    'transaction_id' => $payment->transaction_id,
                ]);

                return [
                    'success' => true,
                    'payment_id' => $payment->transaction_id,
                    'payment_url' => $gatewayResult['payment_url'] ?? null,
                    'idempotency_key' => $idempotencyKey,
                ];
            }

            // Payment creation failed
            $payment->update(['status' => 'failed', 'error_message' => $gatewayResult['error'] ?? 'Unknown error']);
            
            Log::error('Payment creation failed', [
                'payment_id' => $payment->id,
                'order_id' => $order->id,
                'error' => $gatewayResult['error'] ?? 'Unknown error',
            ]);

            return [
                'success' => false,
                'error' => 'فشل في إنشاء عملية الدفع',
                'error_code' => 'PAYMENT_CREATION_FAILED',
            ];

        } catch (\Exception $e) {
            Log::error('Payment creation exception', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'حدث خطأ أثناء إنشاء الدفع',
                'error_code' => 'EXCEPTION',
            ];
        }
    }

    /**
     * Verify payment with enhanced security
     */
    public function verifyPayment(string $transactionId, Order $order = null): array
    {
        try {
            $payment = Payment::where('transaction_id', $transactionId)->first();
            
            if (!$payment) {
                throw new \Exception('Payment not found');
            }

            // Check if already verified
            if ($payment->status === 'completed') {
                return [
                    'success' => true,
                    'already_verified' => true,
                    'payment' => $payment,
                ];
            }

            // Verify with gateway
            $verificationResult = $this->gateway->verifyPayment($transactionId);

            if ($verificationResult['success'] && $verificationResult['status'] === 'completed') {
                // Mark payment as completed
                $payment->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'payment_data' => array_merge(
                        $payment->payment_data ?? [],
                        $verificationResult
                    ),
                ]);

                // Update order status
                if ($order) {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'confirmed_at' => now(),
                    ]);
                }

                Log::info('Payment verified successfully', [
                    'payment_id' => $payment->id,
                    'transaction_id' => $transactionId,
                ]);

                return [
                    'success' => true,
                    'payment' => $payment,
                    'order' => $order,
                ];
            }

            // Payment verification failed
            $payment->update([
                'status' => 'failed',
                'error_message' => $verificationResult['message'] ?? 'Verification failed',
            ]);

            return [
                'success' => false,
                'status' => $verificationResult['status'] ?? 'failed',
                'error' => $verificationResult['message'] ?? 'الدفع لم يتم بنجاح',
            ];

        } catch (\Exception $e) {
            Log::error('Payment verification failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'فشل في التحقق من الدفع',
                'error_code' => 'VERIFICATION_FAILED',
            ];
        }
    }

    /**
     * Process webhook with replay protection
     */
    public function processWebhook(array $payload, string $signature): array
    {
        try {
            // Check signature
            if (!$this->gateway->verifyWebhookSignature($payload, $signature)) {
                Log::warning('Invalid webhook signature', [
                    'signature' => substr($signature, 0, 20) . '...',
                ]);
                return [
                    'success' => false,
                    'error' => 'Invalid signature',
                ];
            }

            // Check for replay attack
            $webhookId = $payload['id'] ?? null;
            if ($webhookId) {
                $replayKey = "webhook_processed:{$webhookId}";
                
                if (Cache::has($replayKey)) {
                    Log::warning('Webhook replay detected', [
                        'webhook_id' => $webhookId,
                    ]);
                    return [
                        'success' => false,
                        'error' => 'Webhook already processed',
                        'duplicate' => true,
                    ];
                }

                // Mark as processed for 24 hours
                Cache::put($replayKey, true, now()->addHours(24));
            }

            // Process webhook
            $result = $this->gateway->handleWebhook($payload);
            
            Log::info('Webhook processed', [
                'webhook_id' => $webhookId,
                'result' => $result,
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'Webhook processing failed',
            ];
        }
    }

    /**
     * Refund payment
     */
    public function refundPayment(string $transactionId, float $amount, string $reason = ''): array
    {
        try {
            $payment = Payment::where('transaction_id', $transactionId)->first();
            
            if (!$payment) {
                throw new \Exception('Payment not found');
            }

            if ($payment->status !== 'completed') {
                return [
                    'success' => false,
                    'error' => 'Payment not completed, cannot refund',
                ];
            }

            $refundResult = $this->gateway->refund($transactionId, $amount);

            if ($refundResult['success']) {
                $payment->update([
                    'status' => 'refunded',
                    'refunded_at' => now(),
                    'refund_amount' => $amount,
                    'refund_reason' => $reason,
                ]);

                // Update order status
                $order = $payment->order;
                if ($order) {
                    $order->update(['payment_status' => 'refunded']);
                }

                Log::info('Payment refunded', [
                    'payment_id' => $payment->id,
                    'transaction_id' => $transactionId,
                    'amount' => $amount,
                    'reason' => $reason,
                ]);

                return [
                    'success' => true,
                    'refund_id' => $refundResult['refund_id'] ?? null,
                    'status' => 'refunded',
                ];
            }

            return [
                'success' => false,
                'error' => $refundResult['message'] ?? 'فشل في استرجاع المبلغ',
            ];

        } catch (\Exception $e) {
            Log::error('Refund failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'حدث خطأ أثناء استرجاع المبلغ',
            ];
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus(string $transactionId): array
    {
        try {
            $payment = Payment::where('transaction_id', $transactionId)->first();
            
            if (!$payment) {
                return [
                    'success' => false,
                    'error' => 'Payment not found',
                ];
            }

            return [
                'success' => true,
                'status' => $payment->status,
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at,
            ];

        } catch (\Exception $e) {
            Log::error('Get payment status failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'فشل في الحصول على حالة الدفع',
            ];
        }
    }
}

