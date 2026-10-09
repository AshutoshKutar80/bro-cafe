<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DeliveryPartner extends Model
{
    protected $fillable = ['user_id','vehicle_type','vehicle_number','is_online','is_active','rating','earnings'];
    protected $casts = ['is_online' => 'boolean', 'is_active' => 'boolean', 'rating' => 'decimal:2', 'earnings' => 'decimal:2'];

    public function user() { return $this->belongsTo(User::class); }
    public function documents() { return $this->hasMany(PartnerDocument::class, 'partner_id'); }
    public function deliveries() { return $this->hasMany(Delivery::class, 'partner_id'); }
    public function locations() { return $this->hasMany(LocationUpdate::class, 'partner_id'); }
}