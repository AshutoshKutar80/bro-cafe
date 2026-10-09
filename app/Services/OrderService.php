<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(protected CartService $cartService) {}

    public function placeOrder(int $userId, array $data): Order
    {
        return DB::transaction(function () use ($userId, $data) {
            $cart = Cart::with('items.product')->where('user_id', $userId)->firstOrFail();
            if ($cart->items->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            $subtotal = $cart->items->sum(fn($i) => $i->price_snapshot * $i->quantity);
            $deliveryCharge = (float) ($data['delivery_charge'] ?? 40);
            $discount = (float) ($data['discount'] ?? 0);
            $total = max(0, $subtotal + $deliveryCharge - $discount);

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $userId,
                'address_id' => $data['address_id'] ?? null,
                'subtotal' => $subtotal,
                'delivery_charge' => $deliveryCharge,
                'discount' => $discount,
                'total' => $total,
                'advance_paid' => 0,
                'payment_method' => $data['payment_method'] ?? 'cod',
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'notes' => $data['notes'] ?? null,
                'customer_name' => $data['customer_name'],
                'customer_mobile' => $data['customer_mobile'],
                'delivery_address' => $data['delivery_address'],
                'delivery_lat' => $data['delivery_lat'] ?? null,
                'delivery_lng' => $data['delivery_lng'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name ?? 'Item',
                    'price_snapshot' => $item->price_snapshot,
                    'quantity' => $item->quantity,
                    'line_total' => $item->price_snapshot * $item->quantity,
                ]);
            }

            $this->cartService->clear($userId);
            return $order->load('items');
        });
    }
}