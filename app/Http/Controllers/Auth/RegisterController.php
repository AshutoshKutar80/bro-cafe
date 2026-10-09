<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm() { return view('auth.register'); }

    public function register(Request $request, OtpService $otpService)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $result = $otpService->generate($data['mobile'], 'register', [
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        if (!$result['success']) {
            return back()->withErrors(['mobile' => $result['message']])->withInput();
        }

        return redirect()->route('otp.verify.form', ['mobile' => $data['mobile']])
            ->with('success', 'OTP sent to your mobile.');
    }
}