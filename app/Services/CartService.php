<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartService
{
    public function getForUser(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public function addItem(int $userId, int $productId, int $qty = 1): CartItem
    {
        $cart = $this->getForUser($userId);
        $product = Product::findOrFail($productId);

        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
        if ($item) {
            $item->increment('quantity', $qty);
            return $item->fresh();
        }
        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'quantity' => $qty,
            'price_snapshot' => $product->price,
        ]);
    }

    public function updateQty(int $userId, int $itemId, int $qty): void
    {
        $cart = $this->getForUser($userId);
        $item = CartItem::where('cart_id', $cart->id)->findOrFail($itemId);
        if ($qty <= 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => $qty]);
        }
    }

    public function removeItem(int $userId, int $itemId): void
    {
        $cart = $this->getForUser($userId);
        CartItem::where('cart_id', $cart->id)->where('id', $itemId)->delete();
    }

    public function clear(int $userId): void
    {
        $cart = $this->getForUser($userId);
        $cart->items()->delete();
    }
}