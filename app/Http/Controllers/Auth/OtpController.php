<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function show(Request $request)
    {
        $mobile = $request->query('mobile');
        if (!$mobile) return redirect()->route('register');
        return view('auth.otp', compact('mobile'));
    }

    public function verify(Request $request, OtpService $otpService)
    {
        $data = $request->validate([
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);

        $result = $otpService->verify($data['mobile'], $data['otp']);
        if (!$result['success']) {
            return back()->withErrors(['otp' => $result['message']]);
        }

        $payload = $result['payload'] ?? [];

        // Registration flow
        if (isset($payload['password'])) {
            $user = User::create([
                'name' => $payload['name'],
                'email' => $payload['email'] ?? null,
                'mobile' => $data['mobile'],
                'password' => $payload['password'],
                'role' => 'customer',
                'mobile_verified_at' => now(),
            ]);
            Auth::login($user);
            return redirect()->route('menu')->with('success', 'Welcome to BRO CAFE!');
        }

        // Password reset flow
        if (($result['record']->purpose ?? '') === 'reset') {
            return redirect()->route('password.reset.form', ['mobile' => $data['mobile']]);
        }

        return redirect()->route('menu');
    }

    public function resend(Request $request, OtpService $otpService)
    {
        $mobile = $request->input('mobile');
        $otpService->generate($mobile, 'register', []);
        return back()->with('success', 'OTP resent.');
    }
}