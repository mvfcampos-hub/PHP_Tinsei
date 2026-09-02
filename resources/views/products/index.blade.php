@extends('layouts.app')

@section('title', 'Produtos')
@section('description', 'Conheça todos os produtos Databit: ERP, Cloud, mobilidade, atendimento ao cliente, documentos fiscais, CRM e serviços de TI.')

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                Ecossistema Databit
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white">Tudo que a Databit tem para o seu negócio</h1>
            <p class="text-brand-200 mt-4 max-w-2xl mx-auto">
                Sistemas de gestão, cloud, mobilidade, atendimento ao cliente, documentos fiscais e serviços de TI —
                tudo integrado para simplificar a gestão da sua empresa.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 space-y-16">
        @forelse ($products as $category => $items)
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-6">
                    {{ \App\Models\Product::CATEGORIES[$category] ?? $category }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($items as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-slate-500 text-center">Nenhum produto cadastrado no momento.</p>
        @endforelse
    </section>
@endsection
