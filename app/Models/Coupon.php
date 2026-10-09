<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code','type','value','min_order','max_discount','valid_from','valid_to','usage_limit','used_count','is_active'];
    protected $casts = [
        'value' => 'decimal:2','min_order' => 'decimal:2','max_discount' => 'decimal:2',
        'valid_from' => 'date','valid_to' => 'date','is_active' => 'boolean',
    ];
}