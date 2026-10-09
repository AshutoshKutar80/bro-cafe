<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OtpLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['mobile','action','ip','user_agent','created_at'];
}