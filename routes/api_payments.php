<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentApiController;

// Payment API Routes (Secured)
Route::prefix('v1/payment')->middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    
    // Create payment
    Route::post('/create', [PaymentApiController::class, 'createPayment'])
        ->middleware(['validate.payment.request']);
    
    // Verify payment
    Route::post('/verify', [PaymentApiController::class, 'verifyPayment'])
        ->middleware(['validate.payment.request']);
    
    // Get payment status
    Route::get('/status/{transactionId}', [PaymentApiController::class, 'getPaymentStatus'])
        ->middleware(['validate.payment.id']);
    
    // Refund payment
    Route::post('/refund', [PaymentApiController::class, 'refundPayment'])
        ->middleware(['validate.refund.request', 'can:refund-payments']);
    
    // Get publishable key for client-side payment forms
    Route::get('/publishable-key', [PaymentApiController::class, 'getPublishableKey']);
});

// Webhook endpoints (no auth, but signature verified)
Route::prefix('v1/webhooks')->group(function () {
    Route::post('/moyasar', [PaymentApiController::class, 'handleWebhook'])
        ->middleware(['verify.webhook.signature']);
});

