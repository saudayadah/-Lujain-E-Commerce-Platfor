<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function __construct(protected PaymentGatewayInterface $paymentGateway)
    {
    }

    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('Payment Webhook Received', ['payload' => $payload]);

        $signature = $request->header('Signature')
            ?? $request->header('X-Webhook-Signature')
            ?? $request->header('X-Signature');

        if (!$signature || !$this->paymentGateway->verifyWebhook($payload, $signature)) {
            Log::warning('Payment webhook rejected due to invalid signature', [
                'signature_present' => (bool) $signature,
            ]);

            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $result = $this->paymentGateway->handleWebhook($payload);

        if ($result['success']) {
            return response()->json(['message' => 'Webhook processed successfully']);
        }

        return response()->json(['error' => $result['error'] ?? 'Failed'], 400);
    }
}

