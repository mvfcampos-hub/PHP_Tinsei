<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $all = Product::active()->get();

        // Soluções de sistemas (ERP, mobilidade, atendimento, fiscal, CRM,
        // comunicação) são apresentadas separadas de Cloud e Serviços de TI,
        // que são ofertas de infraestrutura/serviço, não módulos de sistema.
        $systemProducts = $all->filter(fn (Product $product) => $product->isSystem())->groupBy('category');
        $cloudProducts = $all->where('category', 'cloud')->values();
        $tiProducts = $all->where('category', 'ti')->values();

        $ecosystemHub = $all->firstWhere('slug', 'dataclassic');
        $ecosystemSatellites = $ecosystemHub
            ? $all->filter(fn (Product $product) => $product->isSystem() && $product->id !== $ecosystemHub->id)->values()
            : collect();

        return view('products.index', compact(
            'systemProducts',
            'cloudProducts',
            'tiProducts',
            'ecosystemHub',
            'ecosystemSatellites'
        ));
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
