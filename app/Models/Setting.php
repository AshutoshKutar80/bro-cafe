<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key','value'];
    protected $casts = ['value' => 'array'];

    public static function get(string $key, $default = null) {
        return optional(self::where('key', $key)->first())->value ?? $default;
    }
    public static function set(string $key, $value): void {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}