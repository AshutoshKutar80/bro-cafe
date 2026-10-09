<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LocationUpdate extends Model
{
    public $timestamps = false;
    protected $fillable = ['partner_id','order_id','lat','lng','recorded_at'];
    protected $casts = ['recorded_at' => 'datetime','lat' => 'decimal:7','lng' => 'decimal:7'];
}