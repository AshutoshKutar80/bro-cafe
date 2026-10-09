<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = ['user_id','label','address','landmark','lat','lng','is_default'];
    protected $casts = ['is_default' => 'boolean','lat' => 'decimal:7','lng' => 'decimal:7'];
    public function user() { return $this->belongsTo(User::class); }
}