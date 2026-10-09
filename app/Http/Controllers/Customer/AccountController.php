<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = Order::with('items')->where('user_id', $user->id)->latest()->take(10)->get();
        $addresses = $user->addresses;
        return view('customer.account', compact('user', 'orders', 'addresses'));
    }

    public function updateTheme(Request $request)
    {
        $data = $request->validate(['theme_preference' => 'required|in:light,dark,system']);
        auth()->user()->update(['theme_preference' => $data['theme_preference']]);
        return response()->json(['success' => true]);
    }

    public function storeAddress(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'landmark' => 'nullable|string|max:100',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);
        $data['user_id'] = auth()->id();
        if (auth()->user()->addresses()->count() === 0) $data['is_default'] = true;
        CustomerAddress::create($data);
        return back()->with('success', 'Address saved.');
    }

    public function deleteAddress(int $id)
    {
        CustomerAddress::where('user_id', auth()->id())->where('id', $id)->delete();
        return back()->with('success', 'Address removed.');
    }
}