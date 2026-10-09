<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\LocationUpdate;

class RiderLocationController extends Controller
{
    public function show(Order $order)
    {
        // Customer can only track their own order
        if (auth()->check() && auth()->user()->role === 'customer' && $order->user_id !== auth()->id()) {
            abort(403);
        }
        $delivery = $order->delivery;
        if (!$delivery) return response()->json(['success' => false, 'message' => 'No partner assigned']);

        $location = LocationUpdate::where('partner_id', $delivery->partner_id)
            ->where('order_id', $order->id)
            ->latest('recorded_at')->first();

        return response()->json([
            'success' => true,
            'order_status' => $order->order_status,
            'partner' => [
                'name' => optional($delivery->partner->user)->name,
                'phone' => optional($delivery->partner->user)->mobile,
            ],
            'location' => $location ? ['lat' => (float)$location->lat, 'lng' => (float)$location->lng] : null,
            'updated_at' => optional($location)->recorded_at,
        ]);
    }
}