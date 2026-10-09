<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function requestForm() { return view('auth.forgot-password'); }

    public function sendOtp(Request $request, OtpService $otpService)
    {
        $data = $request->validate(['mobile' => 'required|digits:10|exists:users,mobile']);
        $otpService->generate($data['mobile'], 'reset', []);
        return redirect()->route('otp.verify.form', ['mobile' => $data['mobile']])
            ->with('success', 'OTP sent for password reset.');
    }

    public function showResetForm(Request $request)
    {
        $mobile = $request->query('mobile');
        if (!$mobile) return redirect()->route('password.request');
        return view('auth.reset-password', compact('mobile'));
    }

    public function reset(Request $request)
    {
        $data = $request->validate([
            'mobile' => 'required|digits:10|exists:users,mobile',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = User::where('mobile', $data['mobile'])->firstOrFail();
        $user->update(['password' => Hash::make($data['password'])]);
        return redirect()->route('login')->with('success', 'Password reset successful. Please login.');
    }
}