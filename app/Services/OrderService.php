<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\InventoryMovement;
use App\Events\OrderCreated;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(array $data, array $cartItems): Order
    {
        return DB::transaction(function () use ($data, $cartItems) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'subtotal' => $data['subtotal'],
                'tax' => $data['tax'],
                'shipping_fee' => $data['shipping_fee'] ?? 0,
                'discount' => $data['discount'] ?? 0,
                'total' => $data['total'],
                'status' => 'pending',
                'payment_status' => $data['payment_method'] === 'cod' ? 'cod' : 'pending',
                'payment_method' => $data['payment_method'],
                'shipping_address' => $data['shipping_address'],
                'billing_address' => $data['billing_address'] ?? $data['shipping_address'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($cartItems as $item) {
                $product = $item['product'];
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'variant_id' => $item['variant']->id ?? null,
                    'product_name' => $product->getName(),
                    'product_sku' => $product->sku,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['line_total'],
                    'snapshot' => [
                        'name_ar' => $product->name_ar,
                        'name_en' => $product->name_en,
                        'images' => $product->images,
                    ],
                ]);

                $this->updateStock($product, $item['quantity'], $order);
            }

            // إطلاق حدث إنشاء الطلب
            event(new OrderCreated($order));

            return $order;
        });
    }

    protected function updateStock(Product $product, int $quantity, Order $order): void
    {
        $oldStock = $product->stock;
        $newStock = $oldStock - $quantity;
        
        $product->update(['stock' => $newStock]);

        InventoryMovement::create([
            'product_id' => $product->id,
            'quantity_before' => $oldStock,
            'quantity_change' => -$quantity,
            'quantity_after' => $newStock,
            'type' => 'sale',
            'reference_type' => Order::class,
            'reference_id' => $order->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function updateOrderStatus(Order $order, string $status): Order
    {
        $oldStatus = $order->status;
        
        $order->update(['status' => $status]);

        match ($status) {
            'confirmed' => $order->update(['confirmed_at' => now()]),
            'shipped' => $order->update(['shipped_at' => now()]),
            'delivered' => $order->update(['delivered_at' => now()]),
            default => null,
        };

        // إطلاق حدث تحديث حالة الطلب
        event(new OrderStatusUpdated($order, $oldStatus, $status));

        return $order->fresh();
    }
}

