<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $mobile, string $message): bool
    {
        $provider = config('services.sms.provider', 'msg91');
        try {
            if ($provider === 'msg91') {
                return $this->sendViaMsg91($mobile, $message);
            }
            return $this->sendVia2Factor($mobile, $message);
        } catch (\Throwable $e) {
            Log::error('SMS send failed', ['mobile' => $mobile, 'error' => $e->getMessage()]);
            // Dev fallback: log only
            if (app()->environment('local')) {
                Log::info("OTP SMS (dev) to {$mobile}: {$message}");
                return true;
            }
            return false;
        }
    }

    protected function sendViaMsg91(string $mobile, string $message): bool
    {
        $apiKey = config('services.sms.msg91_key');
        if (!$apiKey) {
            Log::info("SMS (no key) to {$mobile}: {$message}");
            return app()->environment('local');
        }
        $response = Http::withHeaders(['authkey' => $apiKey])
            ->post('https://api.msg91.com/api/v2/sendsms', [
                'sender' => config('services.sms.sender_id'),
                'route' => '4',
                'country' => '91',
                'sms' => [['message' => $message, 'to' => [$mobile]]],
            ]);
        return $response->successful();
    }

    protected function sendVia2Factor(string $mobile, string $message): bool
    {
        $apiKey = config('services.sms.2factor_key');
        if (!$apiKey) return app()->environment('local');
        $response = Http::get("https://2factor.in/API/V1/{$apiKey}/SMS/{$mobile}/{$message}");
        return $response->successful();
    }
}