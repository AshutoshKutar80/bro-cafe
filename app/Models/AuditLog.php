<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id','action','model','model_id','changes','ip','created_at'];
    protected $casts = ['changes' => 'array','created_at' => 'datetime'];
}