<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function success(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)
            ->where('user_id', auth()->id())->firstOrFail();
        return view('customer.order-success', compact('order'));
    }

    public function track(string $orderNumber)
    {
        $order = Order::with(['items', 'delivery.partner.user'])
            ->where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return view('customer.track', compact('order'));
    }

    public function show(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)
            ->where('user_id', auth()->id())->firstOrFail();
        return view('customer.order-detail', compact('order'));
    }
}