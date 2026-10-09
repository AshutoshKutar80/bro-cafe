<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index()
    {
        $cart = $this->cartService->getForUser(auth()->id());
        $cart->load('items.product');
        return view('customer.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:20',
        ]);
        $item = $this->cartService->addItem(auth()->id(), $data['product_id'], $data['quantity'] ?? 1);

        if ($request->wantsJson()) {
            $cart = $this->cartService->getForUser(auth()->id());
            return response()->json([
                'success' => true,
                'message' => 'Added to cart',
                'cart_count' => $cart->fresh()->count,
                'item_id' => $item->id,
            ]);
        }
        return back()->with('success', 'Item added to cart.');
    }

    public function update(Request $request, int $itemId)
    {
        $data = $request->validate(['quantity' => 'required|integer|min:0|max:20']);
        $this->cartService->updateQty(auth()->id(), $itemId, $data['quantity']);
        if ($request->wantsJson()) {
            $cart = $this->cartService->getForUser(auth()->id());
            $cart->load('items.product');
            return response()->json(['success' => true, 'cart_count' => $cart->count, 'subtotal' => $cart->subtotal]);
        }
        return back();
    }

    public function remove(Request $request, int $itemId)
    {
        $this->cartService->removeItem(auth()->id(), $itemId);
        if ($request->wantsJson()) {
            $cart = $this->cartService->getForUser(auth()->id());
            return response()->json(['success' => true, 'cart_count' => $cart->fresh()->count]);
        }
        return back()->with('success', 'Item removed.');
    }
}