<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureMobileVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->mobile_verified_at) {
            return redirect()->route('otp.verify.form', ['mobile' => auth()->user()->mobile]);
        }
        return $next($request);
    }
}