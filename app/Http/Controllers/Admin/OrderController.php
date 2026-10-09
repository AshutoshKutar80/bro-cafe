<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DeliveryPartner;
use App\Models\Delivery;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();
        if ($request->filled('status')) $query->where('order_status', $request->status);
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->q . '%')
                  ->orWhere('customer_mobile', 'like', '%' . $request->q . '%');
            });
        }
        $orders = $query->paginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items', 'user', 'delivery.partner.user']);
        $partners = DeliveryPartner::with('user')->where('is_active', true)->get();
        return view('admin.orders.show', compact('order', 'partners'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'order_status' => 'required|in:pending,accepted,preparing,ready,picked_up,out_for_delivery,delivered,cancelled,rejected',
        ]);
        $order->update(['order_status' => $data['order_status']]);
        return back()->with('success', 'Order status updated.');
    }

    public function assignPartner(Request $request, Order $order)
    {
        $data = $request->validate(['partner_id' => 'required|exists:delivery_partners,id']);
        Delivery::updateOrCreate(
            ['order_id' => $order->id],
            ['partner_id' => $data['partner_id'], 'assigned_at' => now(), 'status' => 'assigned']
        );
        $order->update(['order_status' => 'accepted']);
        return back()->with('success', 'Delivery partner assigned.');
    }
}