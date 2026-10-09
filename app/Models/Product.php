<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id','name','slug','description','price','image',
        'is_available','is_featured','is_veg','sort_order'
    ];
    protected $casts = [
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'is_veg' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function scopeAvailable($q) { return $q->where('is_available', true); }
}