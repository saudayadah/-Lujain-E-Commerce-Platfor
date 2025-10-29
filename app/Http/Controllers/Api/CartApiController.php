<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index()
    {
        return response()->json($this->cartService->getCartWithDetails());
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $result = $this->cartService->addItem(
            $request->product_id,
            $request->quantity,
            $request->variant_id
        );

        return response()->json($result);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $result = $this->cartService->updateQuantity($id, $request->quantity);

        return response()->json($result);
    }

    public function remove(string $id)
    {
        $result = $this->cartService->removeItem($id);

        return response()->json($result);
    }
}

