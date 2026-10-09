<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = ['order_id','partner_id','assigned_at','picked_up_at','delivered_at','status'];
    protected $casts = ['assigned_at' => 'datetime','picked_up_at' => 'datetime','delivered_at' => 'datetime'];
    public function order() { return $this->belongsTo(Order::class); }
    public function partner() { return $this->belongsTo(DeliveryPartner::class, 'partner_id'); }
}