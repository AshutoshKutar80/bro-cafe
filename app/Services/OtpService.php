<?php
namespace App\Services;

use App\Models\OtpVerification;
use App\Models\OtpLog;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OtpService
{
    public const EXPIRY_MINUTES = 5;
    public const MAX_ATTEMPTS = 3;
    public const RESEND_COOLDOWN = 30;

    public function __construct(protected SmsService $sms) {}

    public function generate(string $mobile, string $purpose = 'register', array $payload = []): array
    {
        // Rate limit
        $recent = OtpVerification::where('mobile', $mobile)
            ->where('created_at', '>', now()->subSeconds(self::RESEND_COOLDOWN))
            ->exists();
        if ($recent) {
            return ['success' => false, 'message' => 'Please wait before requesting another OTP.'];
        }

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        OtpVerification::where('mobile', $mobile)->whereNull('verified_at')->delete();

        OtpVerification::create([
            'mobile' => $mobile,
            'otp_hash' => Hash::make($otp),
            'purpose' => $purpose,
            'payload' => $payload,
            'expires_at' => now()->addMinutes(self::EXPIRY_MINUTES),
            'attempts' => 0,
        ]);

        OtpLog::create([
            'mobile' => $mobile,
            'action' => 'send',
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->sms->send($mobile, "Your BRO CAFE OTP is {$otp}. Valid for " . self::EXPIRY_MINUTES . " minutes.");

        return ['success' => true, 'message' => 'OTP sent successfully.'];
    }

    public function verify(string $mobile, string $otp): array
    {
        $record = OtpVerification::where('mobile', $mobile)->whereNull('verified_at')
            ->latest()->first();

        if (!$record) {
            return ['success' => false, 'message' => 'OTP not found. Please request a new one.'];
        }

        if ($record->expires_at->isPast()) {
            return ['success' => false, 'message' => 'OTP expired.'];
        }

        if ($record->attempts >= self::MAX_ATTEMPTS) {
            return ['success' => false, 'message' => 'Maximum attempts exceeded. Try again later.'];
        }

        $record->increment('attempts');

        if (!Hash::check($otp, $record->otp_hash)) {
            OtpLog::create(['mobile' => $mobile, 'action' => 'failed', 'ip' => request()->ip()]);
            return ['success' => false, 'message' => 'Invalid OTP.'];
        }

        $record->update(['verified_at' => now()]);
        OtpLog::create(['mobile' => $mobile, 'action' => 'verified', 'ip' => request()->ip()]);

        return ['success' => true, 'payload' => $record->payload, 'record' => $record];
    }
}