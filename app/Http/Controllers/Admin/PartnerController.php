<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPartner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = DeliveryPartner::with('user')->latest()->paginate(20);
        return view('admin.partners.index', compact('partners'));
    }

    public function create() { return view('admin.partners.form', ['partner' => new DeliveryPartner()]); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'password' => 'required|min:6',
            'vehicle_type' => 'required|string',
            'vehicle_number' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
            'role' => 'partner',
            'mobile_verified_at' => now(),
        ]);

        DeliveryPartner::create([
            'user_id' => $user->id,
            'vehicle_type' => $data['vehicle_type'],
            'vehicle_number' => $data['vehicle_number'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner created.');
    }

    public function edit(DeliveryPartner $partner)
    {
        $partner->load('user');
        return view('admin.partners.form', compact('partner'));
    }

    public function update(Request $request, DeliveryPartner $partner)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'vehicle_type' => 'required|string',
            'vehicle_number' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);
        $partner->user->update(['name' => $data['name']]);
        $partner->update([
            'vehicle_type' => $data['vehicle_type'],
            'vehicle_number' => $data['vehicle_number'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return redirect()->route('admin.partners.index')->with('success', 'Partner updated.');
    }

    public function destroy(DeliveryPartner $partner)
    {
        $partner->user->delete();
        return back()->with('success', 'Partner removed.');
    }
}