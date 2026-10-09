<?php
namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Coffee', 'Cappuccino', 120], ['Coffee', 'Latte', 130], ['Coffee', 'Espresso', 90],
            ['Cold Coffee', 'Cold Coffee Classic', 150], ['Cold Coffee', 'Frappe', 180],
            ['Tea', 'Masala Chai', 60], ['Tea', 'Green Tea', 70],
            ['Shakes', 'Chocolate Shake', 160], ['Shakes', 'Oreo Shake', 170],
            ['Snacks', 'French Fries', 100], ['Snacks', 'Veg Sandwich', 120],
            ['Food', 'Paneer Wrap', 180], ['Food', 'Veg Burger', 140],
        ];
        foreach ($items as $i => [$catName, $name, $price]) {
            $cat = Category::where('name', $catName)->first();
            if (!$cat) continue;
            Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'category_id' => $cat->id,
                    'name' => $name,
                    'description' => "Freshly made $name at BRO CAFE.",
                    'price' => $price,
                    'is_available' => true,
                    'is_featured' => $i < 4,
                    'is_veg' => true,
                    'sort_order' => $i,
                ]
            );
        }
    }
}