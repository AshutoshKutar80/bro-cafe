<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = ['mobile','otp_hash','purpose','payload','expires_at','attempts','verified_at'];
    protected $casts = ['payload' => 'array','expires_at' => 'datetime','verified_at' => 'datetime'];
}