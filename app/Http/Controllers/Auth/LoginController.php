<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm() { return view('auth.login'); }

    public function login(Request $request)
    {
        $data = $request->validate([
            'identifier' => 'required',
            'password' => 'required',
        ]);

        $field = filter_var($data['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        if (Auth::attempt([$field => $data['identifier'], 'password' => $data['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'partner' => redirect()->route('partner.dashboard'),
                default => redirect()->route('menu'),
            };
        }

        return back()->withErrors(['identifier' => 'Invalid credentials.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}