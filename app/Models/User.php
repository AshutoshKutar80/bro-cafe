<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'mobile', 'email', 'password', 'role', 'status',
        'theme_preference', 'mobile_verified_at',
    ];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function addresses() { return $this->hasMany(CustomerAddress::class); }
    public function cart() { return $this->hasOne(Cart::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function partner() { return $this->hasOne(DeliveryPartner::class); }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isPartner(): bool { return $this->role === 'partner'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }
}