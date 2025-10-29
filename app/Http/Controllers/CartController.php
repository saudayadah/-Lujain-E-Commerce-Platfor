<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Http\Requests\StoreCartItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index()
    {
        try {
            $cart = $this->cartService->getCartWithDetails();
        } catch (\Exception $e) {
            $cart = ['items' => [], 'subtotal' => 0, 'tax' => 0, 'total' => 0];
        }
        
        return view('cart.index', compact('cart'));
    }

    public function add(StoreCartItemRequest $request)
    {
        try {
            $result = $this->cartService->addItem(
                $request->product_id,
                $request->quantity ?? 1,
                $request->variant_id
            );

            if ($request->expectsJson()) {
                if ($result['success']) {
                    $cart = $this->cartService->getCartWithDetails();
                    return response()->json([
                        'success' => true,
                        'message' => $result['message'],
                        'cart' => $cart
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }

            return back()
                ->with($result['success'] ? 'success' : 'error', $result['message']);
        } catch (\Exception $e) {
            Log::error('CartController@add: ' . $e->getMessage());
            
            $message = 'حدث خطأ أثناء إضافة المنتج للسلة';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 500);
            }

            return back()->with('error', $message);
        }
    }

    public function count()
    {
        $cart = $this->cartService->getCartWithDetails();
        $count = 0;
        
        foreach ($cart['items'] as $item) {
            $count += $item['quantity'];
        }

        return response()->json(['count' => $count]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->updateQuantity($id, $request->quantity);

        return redirect()->back()->with('success', __('messages.cart.updated'));
    }

    public function remove(string $id)
    {
        $this->cartService->removeItem($id);

        return redirect()->back()->with('success', __('messages.cart.removed'));
    }

    public function clear()
    {
        $this->cartService->clear();

        return redirect()->back()->with('success', __('messages.cart.cleared'));
    }
}

