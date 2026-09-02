<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $all = Product::active()->get();
        $products = $all->groupBy('category');
        $ecosystemHub = $all->firstWhere('slug', 'dataclassic');
        $ecosystemSatellites = $ecosystemHub
            ? $all->reject(fn ($product) => $product->id === $ecosystemHub->id)
            : collect();

        return view('products.index', compact('products', 'ecosystemHub', 'ecosystemSatellites'));
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
