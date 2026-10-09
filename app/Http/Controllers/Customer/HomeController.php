<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->orderBy('sort_order')->take(6)->get();
        $featured = Product::available()->where('is_featured', true)->take(8)->get();
        return view('customer.home', compact('categories', 'featured'));
    }
}