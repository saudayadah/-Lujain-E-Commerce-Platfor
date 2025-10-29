<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentGatewayInterface;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService,
        protected PaymentGatewayInterface $paymentGateway
    ) {
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('items')->latest()->paginate(10);
        
        return response()->json($orders);
    }

    public function show(Request $request, $id)
    {
        $order = $request->user()->orders()->with(['items', 'payments'])->findOrFail($id);
        
        return response()->json($order);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|array',
            'payment_method' => 'required|in:cod,online',
        ]);

        $cart = $this->cartService->getCartWithDetails();
        
        if (empty($cart['items'])) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $order = $this->orderService->createOrder([
            'subtotal' => $cart['subtotal'],
            'tax' => $cart['tax'],
            'total' => $cart['total'],
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
        ], $cart['items']);

        $this->cartService->clear();

        if ($request->payment_method === 'online') {
            $paymentResult = $this->paymentGateway->createPayment($order);
            
            return response()->json([
                'order' => $order,
                'payment' => $paymentResult,
            ]);
        }

        return response()->json(['order' => $order]);
    }
}

