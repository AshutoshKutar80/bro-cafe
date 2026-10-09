<?php
namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\LocationUpdate;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'order_id' => 'nullable|exists:orders,id',
        ]);
        $partner = auth()->user()->partner;
        LocationUpdate::create([
            'partner_id' => $partner->id,
            'order_id' => $data['order_id'] ?? null,
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'recorded_at' => now(),
        ]);
        return response()->json(['success' => true]);
    }
}