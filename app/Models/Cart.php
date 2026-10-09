<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];
    public function items() { return $this->hasMany(CartItem::class); }
    public function user() { return $this->belongsTo(User::class); }

    public function getSubtotalAttribute() {
        return $this->items->sum(fn($i) => $i->price_snapshot * $i->quantity);
    }
    public function getCountAttribute() {
        return $this->items->sum('quantity');
    }
}