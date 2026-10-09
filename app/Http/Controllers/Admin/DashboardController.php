<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\DeliveryPartner;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_sales' => (float) Order::whereDate('created_at', today())->sum('total'),
            'pending_orders' => Order::whereIn('order_status', ['pending', 'accepted', 'preparing', 'ready'])->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'active_riders' => DeliveryPartner::where('is_online', true)->count(),
            'total_products' => Product::count(),
        ];
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}