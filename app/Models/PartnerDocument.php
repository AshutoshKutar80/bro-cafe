<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PartnerDocument extends Model
{
    protected $fillable = ['partner_id','type','file_path','status','reviewed_by','reviewed_at'];
    protected $casts = ['reviewed_at' => 'datetime'];
    public function partner() { return $this->belongsTo(DeliveryPartner::class, 'partner_id'); }
}