<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id','product_id','quantity','price_snapshot'];
    protected $casts = ['price_snapshot' => 'decimal:2'];

    public function product() { return $this->belongsTo(Product::class); }
    public function cart() { return $this->belongsTo(Cart::class); }
    public function getLineTotalAttribute() { return $this->price_snapshot * $this->quantity; }
}