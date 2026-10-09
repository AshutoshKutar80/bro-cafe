<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'cafe_name' => Setting::get('cafe_name', 'BRO CAFE'),
            'cafe_phone' => Setting::get('cafe_phone', '+91 9999999999'),
            'cafe_address' => Setting::get('cafe_address', ''),
            'delivery_charge' => Setting::get('delivery_charge', 40),
            'delivery_radius_km' => Setting::get('delivery_radius_km', 5),
            'min_order' => Setting::get('min_order', 100),
        ];
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'cafe_name' => 'required|string|max:100',
            'cafe_phone' => 'nullable|string',
            'cafe_address' => 'nullable|string',
            'delivery_charge' => 'required|numeric|min:0',
            'delivery_radius_km' => 'required|numeric|min:0',
            'min_order' => 'required|numeric|min:0',
        ]);
        foreach ($data as $key => $value) Setting::set($key, $value);
        return back()->with('success', 'Settings updated.');
    }
}