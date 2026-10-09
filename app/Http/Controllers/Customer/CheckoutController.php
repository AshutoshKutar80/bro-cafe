<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService,
    ) {}

    public function index()
    {
        $cart = $this->cartService->getForUser(auth()->id());
        $cart->load('items.product');
        if ($cart->items->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Cart is empty.');
        }
        $addresses = auth()->user()->addresses;
        $deliveryCharge = (float) (\App\Models\Setting::get('delivery_charge', 40));
        return view('customer.checkout', compact('cart', 'addresses', 'deliveryCharge'));
    }

    public function place(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_mobile' => 'required|digits:10',
            'delivery_address' => 'required|string|max:500',
            'delivery_lat' => 'nullable|numeric',
            'delivery_lng' => 'nullable|numeric',
            'payment_method' => 'required|in:cod,advance_qr',
            'notes' => 'nullable|string|max:500',
            'coupon_code' => 'nullable|string',
        ]);

        $deliveryCharge = (float) (\App\Models\Setting::get('delivery_charge', 40));
        $discount = 0;

        if (!empty($data['coupon_code'])) {
            $coupon = Coupon::where('code', $data['coupon_code'])->where('is_active', true)->first();
            if ($coupon) {
                $cart = $this->cartService->getForUser(auth()->id());
                $subtotal = $cart->items->sum(fn($i) => $i->price_snapshot * $i->quantity);
                if ($subtotal >= $coupon->min_order) {
                    $discount = $coupon->type === 'flat'
                        ? (float) $coupon->value
                        : ($subtotal * (float) $coupon->value / 100);
                    if ($coupon->max_discount && $discount > $coupon->max_discount) {
                        $discount = (float) $coupon->max_discount;
                    }
                    $coupon->increment('used_count');
                }
            }
        }

        $data['delivery_charge'] = $deliveryCharge;
        $data['discount'] = $discount;

        try {
            $order = $this->orderService->placeOrder(auth()->id(), $data);
            return redirect()->route('order.success', $order->order_number);
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function validateCoupon(Request $request)
    {
        $data = $request->validate(['code' => 'required|string']);
        $coupon = Coupon::where('code', $data['code'])->where('is_active', true)->first();
        if (!$coupon) return response()->json(['valid' => false, 'message' => 'Invalid coupon']);
        return response()->json(['valid' => true, 'type' => $coupon->type, 'value' => (float) $coupon->value]);
    }
}