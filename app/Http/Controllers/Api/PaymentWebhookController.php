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
        Log::info('Payment Webhook Received', ['payload' => $request->all()]);

        $result = $this->paymentGateway->handleWebhook($request->all());

        if ($result['success']) {
            return response()->json(['message' => 'Webhook processed successfully']);
        }

        return response()->json(['error' => $result['error'] ?? 'Failed'], 400);
    }
}

