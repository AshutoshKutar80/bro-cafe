<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->orderBy('sort_order')->get();
        $query = Product::available()->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('veg')) {
            $query->where('is_veg', $request->veg === '1');
        }

        $products = $query->orderBy('sort_order')->paginate(24)->withQueryString();

        return view('customer.menu', compact('categories', 'products'));
    }

    public function show(string $slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $related = Product::available()->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)->take(4)->get();
        return view('customer.product', compact('product', 'related'));
    }
}