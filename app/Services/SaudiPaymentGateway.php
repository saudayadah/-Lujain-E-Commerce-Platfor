<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SaudiPaymentGateway implements PaymentGatewayInterface
{
    protected string $baseUrl;
    protected string $clientId;
    protected string $clientSecret;

    public function __construct()
    {
        $mode = config('payment.mode', 'sandbox');
        $this->baseUrl = $mode === 'production'
            ? (config('payment.production_url') ?? '')
            : (config('payment.sandbox_url') ?? '');
        $this->clientId = config('payment.client_id') ?? '';
        $this->clientSecret = config('payment.client_secret') ?? '';
    }

    public function createPayment(Order $order, array $data = []): array
    {
        try {
            $payload = [
                'amount' => $order->total,
                'currency' => 'SAR',
                'order_id' => $order->order_number,
                'description' => "Order #{$order->order_number}",
                'callback_url' => config('payment.callback_url'),
                'success_url' => config('payment.success_url'),
                'cancel_url' => config('payment.cancel_url'),
                'customer' => [
                    'name' => $order->user->name ?? 'Guest',
                    'email' => $order->user->email ?? '',
                    'phone' => $order->user->phone ?? '',
                ],
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                ],
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/payments', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                // Create payment record
                Payment::create([
                    'order_id' => $order->id,
                    'gateway' => 'saudi_payments',
                    'transaction_id' => $data['transaction_id'] ?? null,
                    'reference_id' => $data['reference_id'] ?? null,
                    'status' => 'pending',
                    'amount' => $order->total,
                    'currency' => 'SAR',
                    'response_data' => $data,
                ]);

                return [
                    'success' => true,
                    'payment_url' => $data['payment_url'] ?? null,
                    'transaction_id' => $data['transaction_id'] ?? null,
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['message'] ?? 'Payment creation failed',
                'data' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('Payment Gateway Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function verifyPayment(string $transactionId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ])->get($this->baseUrl . "/payments/{$transactionId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => 'Payment verification failed',
            ];
        } catch (\Exception $e) {
            Log::error('Payment Verification Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function refund(string $transactionId, float $amount): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ])->post($this->baseUrl . "/payments/{$transactionId}/refund", [
                'amount' => $amount,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => 'Refund failed',
            ];
        } catch (\Exception $e) {
            Log::error('Refund Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function handleWebhook(array $payload): array
    {
        try {
            // Verify webhook signature if provided
            $transactionId = $payload['transaction_id'] ?? null;
            $status = $payload['status'] ?? null;
            $orderId = $payload['metadata']['order_id'] ?? null;

            if (!$transactionId || !$orderId) {
                return [
                    'success' => false,
                    'error' => 'Invalid webhook payload',
                ];
            }

            // Find payment
            $payment = Payment::where('transaction_id', $transactionId)->first();
            
            if (!$payment) {
                return [
                    'success' => false,
                    'error' => 'Payment not found',
                ];
            }

            // Update payment status
            $paymentStatus = match ($status) {
                'completed', 'success' => 'completed',
                'failed' => 'failed',
                'refunded' => 'refunded',
                default => 'pending',
            };

            $payment->update([
                'status' => $paymentStatus,
                'response_data' => $payload,
                'paid_at' => $paymentStatus === 'completed' ? now() : null,
            ]);

            // Update order
            $order = $payment->order;
            if ($paymentStatus === 'completed') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                ]);
            } elseif ($paymentStatus === 'failed') {
                $order->update([
                    'payment_status' => 'failed',
                ]);
            }

            return [
                'success' => true,
                'message' => 'Webhook processed successfully',
            ];
        } catch (\Exception $e) {
            Log::error('Webhook Error: ' . $e->getMessage(), ['payload' => $payload]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    protected function getAccessToken(): string
    {
        // In production, cache this token
        $response = Http::post($this->baseUrl . '/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Failed to get access token');
    }
}

