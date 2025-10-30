<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\PaymentWebhookController;

// Public API
Route::prefix('v1')->group(function () {
    // Auth routes - 🔒 Protected with strict rate limiting
    Route::post('/register', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'User registered successfully',
        ]);
    })->middleware('throttle:auth'); // 5 محاولات/دقيقة

    Route::post('/login', function (Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Check if user exists and verify credentials
        $user = \App\Models\User::where('email', $request->email)
            ->orWhere('phone', $request->email)
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'البريد الإلكتروني أو رقم الهاتف غير مسجل',
            ], 401);
        }

        if (!\Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'كلمة المرور غير صحيحة',
            ], 401);
        }

        // Generate token
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'token' => $token,
            'message' => 'Login successful',
        ]);
    })->middleware('throttle:auth'); // 5 محاولات/دقيقة
    
    // Products
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{id}', [ProductApiController::class, 'show']);
    
    // Categories
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::get('/categories/{id}', [CategoryApiController::class, 'show']);
    
    // Cart (guest & authenticated)
    Route::prefix('cart')->group(function () {
        Route::post('/add', [CartApiController::class, 'add']);
        Route::get('/', [CartApiController::class, 'index']);
        Route::patch('/update/{id}', [CartApiController::class, 'update']);
        Route::delete('/remove/{id}', [CartApiController::class, 'remove']);
    });
    
    // Authenticated API
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        
        Route::post('/logout', function (Request $request) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        });
        
        // Checkout
        Route::post('/checkout', [OrderApiController::class, 'checkout']);
        
        // Orders
        Route::get('/orders', [OrderApiController::class, 'index']);
        Route::get('/orders/{id}', [OrderApiController::class, 'show']);
    });
});

// Payment Webhooks (outside versioning)
Route::post('/webhooks/saudi-payments', [PaymentWebhookController::class, 'handle'])
    ->name('webhooks.saudi-payments');

