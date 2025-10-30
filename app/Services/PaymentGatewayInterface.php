<?php

namespace App\Services;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function createPayment(Order $order, array $data = []): array;
    
    public function verifyPayment(string $transactionId): array;
    
    public function refund(string $transactionId, float $amount): array;
    
    public function verifyWebhook(array $payload, string $signature): bool;

    public function handleWebhook(array $payload): array;
}

