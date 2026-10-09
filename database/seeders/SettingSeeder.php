<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('cafe_name', 'BRO CAFE');
        Setting::set('cafe_phone', '+91 9999999999');
        Setting::set('cafe_address', 'BRO CAFE, Main Road, Your City');
        Setting::set('delivery_charge', 40);
        Setting::set('delivery_radius_km', 5);
        Setting::set('min_order', 100);
    }
}