<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number','user_id','address_id','subtotal','delivery_charge',
        'discount','total','advance_paid','payment_method','payment_status',
        'order_status','notes','customer_name','customer_mobile',
        'delivery_address','delivery_lat','delivery_lng',
    ];
    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'advance_paid' => 'decimal:2',
    ];

    public function items() { return $this->hasMany(OrderItem::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function delivery() { return $this->hasOne(Delivery::class); }
    public function address() { return $this->belongsTo(CustomerAddress::class, 'address_id'); }

    public static function generateOrderNumber(): string {
        return 'BRC-' . strtoupper(uniqid());
    }

    public function statusLabel(): string {
        return match($this->order_status) {
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'preparing' => 'Preparing',
            'ready' => 'Ready',
            'picked_up' => 'Picked Up',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'rejected' => 'Rejected',
            default => 'Unknown',
        };
    }
}