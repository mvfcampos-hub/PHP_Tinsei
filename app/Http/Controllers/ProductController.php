<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $all = Product::active()->get();

        // Soluções de sistemas (ERP, mobilidade, atendimento, fiscal, CRM,
        // comunicação, integrações) são apresentadas separadas do DataCloud, que
        // é infraestrutura, não um módulo de sistema. Serviços de TI e Produtos
        // (hardware) têm páginas próprias fora deste catálogo.
        $systemProducts = $all->filter(fn (Product $product) => $product->isSystem())->groupBy('category');
        $cloudProducts = $all->where('category', 'cloud')->values();

        $ecosystemHub = $all->firstWhere('slug', 'dataclassic');
        $ecosystemSatellites = $all->where('is_ecosystem_node', true)->values();

        return view('products.index', compact(
            'systemProducts',
            'cloudProducts',
            'ecosystemHub',
            'ecosystemSatellites'
        ));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        if ($product->opens_externally && $product->external_url) {
            return redirect()->away($product->external_url);
        }

        $related = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
