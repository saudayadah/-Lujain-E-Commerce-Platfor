<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $cartKey = 'shopping_cart';

    public function getCart(): array
    {
        return Session::get($this->cartKey, []);
    }

    public function addItem(int $productId, int $quantity = 1, ?int $variantId = null): array
    {
        try {
            $product = Product::findOrFail($productId);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'المنتج غير موجود',
            ];
        }
        
        try {
            if (!$product->isInStock()) {
                return [
                    'success' => false,
                    'message' => 'المنتج غير متوفر في المخزن',
                ];
            }
        } catch (\Exception $e) {
            // Continue if isInStock check fails
        }

        $cart = $this->getCart();
        $key = $this->generateKey($productId, $variantId);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $price = $variantId 
                ? ProductVariant::find($variantId)->price 
                : $product->getCurrentPrice();

            $cart[$key] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        Session::put($this->cartKey, $cart);

        return [
            'success' => true,
            'cart' => $this->getCartWithDetails(),
        ];
    }

    public function updateQuantity(string $key, int $quantity): array
    {
        $cart = $this->getCart();

        if (!isset($cart[$key])) {
            return [
                'success' => false,
                'message' => 'Item not found in cart',
            ];
        }

        if ($quantity <= 0) {
            return $this->removeItem($key);
        }

        $cart[$key]['quantity'] = $quantity;
        Session::put($this->cartKey, $cart);

        return [
            'success' => true,
            'cart' => $this->getCartWithDetails(),
        ];
    }

    public function removeItem(string $key): array
    {
        $cart = $this->getCart();
        unset($cart[$key]);
        Session::put($this->cartKey, $cart);

        return [
            'success' => true,
            'cart' => $this->getCartWithDetails(),
        ];
    }

    public function clear(): void
    {
        Session::forget($this->cartKey);
    }

    public function getCartWithDetails(): array
    {
        try {
            $cart = $this->getCart();
            $items = [];
            $subtotal = 0;

            foreach ($cart as $key => $item) {
                try {
                    $product = Product::find($item['product_id']);
                    
                    if (!$product) {
                        continue;
                    }
                } catch (\Exception $e) {
                    continue;
                }

                try {
                    $variant = $item['variant_id'] ? ProductVariant::find($item['variant_id']) : null;
                } catch (\Exception $e) {
                    $variant = null;
                }
                
                $lineTotal = $item['price'] * $item['quantity'];
                $subtotal += $lineTotal;

                $items[$key] = [
                    'key' => $key,
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'line_total' => $lineTotal,
                ];
            }

            $discount = 0;
            try {
                $appliedCoupon = Session::get('applied_coupon');
                if ($appliedCoupon && isset($appliedCoupon['discount'])) {
                    $discount = $appliedCoupon['discount'];
                }
            } catch (\Exception $e) {
                $appliedCoupon = null;
            }

            $subtotalAfterDiscount = max(0, $subtotal - $discount);
            $tax = $subtotalAfterDiscount * 0.15;
            $total = $subtotalAfterDiscount + $tax;

            return [
                'items' => $items,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'coupon' => $appliedCoupon,
                'subtotal_after_discount' => $subtotalAfterDiscount,
                'tax' => $tax,
                'total' => $total,
                'count' => count($items),
            ];
        } catch (\Exception $e) {
            return [
                'items' => [],
                'subtotal' => 0,
                'discount' => 0,
                'coupon' => null,
                'subtotal_after_discount' => 0,
                'tax' => 0,
                'total' => 0,
                'count' => 0,
            ];
        }
    }

    public function getItemCount(): int
    {
        return array_sum(array_column($this->getCart(), 'quantity'));
    }

    protected function generateKey(int $productId, ?int $variantId): string
    {
        return $variantId ? "p{$productId}_v{$variantId}" : "p{$productId}";
    }
}

