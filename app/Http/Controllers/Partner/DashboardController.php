<?php
namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Delivery;

class DashboardController extends Controller
{
    public function index()
    {
        $partner = auth()->user()->partner;
        $assigned = Delivery::with('order')
            ->where('partner_id', $partner->id)
            ->whereIn('status', ['assigned', 'picked_up', 'out_for_delivery'])
            ->latest()->get();
        $completed = Delivery::where('partner_id', $partner->id)->where('status', 'delivered')->count();
        return view('partner.dashboard', compact('partner', 'assigned', 'completed'));
    }
}