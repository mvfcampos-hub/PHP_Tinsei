<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::active()->get()->groupBy('category');

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $related = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
