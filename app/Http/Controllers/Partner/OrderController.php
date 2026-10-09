<?php
namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Delivery $delivery)
    {
        if ($delivery->partner_id !== auth()->user()->partner->id) abort(403);
        $delivery->load('order.items');
        return view('partner.order-show', compact('delivery'));
    }

    public function updateStatus(Request $request, Delivery $delivery)
    {
        if ($delivery->partner_id !== auth()->user()->partner->id) abort(403);
        $data = $request->validate([
            'status' => 'required|in:picked_up,out_for_delivery,delivered',
        ]);
        $updates = ['status' => $data['status']];
        if ($data['status'] === 'picked_up') $updates['picked_up_at'] = now();
        if ($data['status'] === 'delivered') $updates['delivered_at'] = now();
        $delivery->update($updates);

        $orderStatus = match($data['status']) {
            'picked_up' => 'picked_up',
            'out_for_delivery' => 'out_for_delivery',
            'delivered' => 'delivered',
        };
        $delivery->order->update(['order_status' => $orderStatus, 'payment_status' => $orderStatus === 'delivered' ? 'paid' : $delivery->order->payment_status]);

        return back()->with('success', 'Status updated.');
    }

    public function toggleOnline()
    {
        $partner = auth()->user()->partner;
        $partner->update(['is_online' => !$partner->is_online]);
        return back()->with('success', $partner->is_online ? 'You are online' : 'You are offline');
    }
}