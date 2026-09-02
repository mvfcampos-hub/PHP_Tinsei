@extends('layouts.app')

@section('title', $product->name)
@section('description', $product->summary ?? '')

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-200 hover:text-white mb-6">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
                Voltar para produtos
            </a>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                {{ $product->categoryLabel() }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white max-w-3xl">{{ $product->name }}</h1>
            @if ($product->tagline)
                <p class="text-brand-200 mt-4 max-w-2xl text-lg">{{ $product->tagline }}</p>
            @endif

            <div class="flex flex-wrap gap-3 mt-8">
                <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Tenho interesse no produto ' . $product->name . '.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-5 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                    Falar com um especialista
                </a>
                @if ($product->external_url)
                    <a href="{{ $product->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg border border-white/20 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                        Acessar site do produto
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    </a>
                @endif
            </div>
        </div>
    </section>

    @if ($product->cover_image)
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
            <img src="{{ Storage::url($product->cover_image) }}" alt="{{ $product->name }}" class="w-full rounded-2xl shadow-xl object-cover max-h-[420px]">
        </div>
    @endif

    <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-16">
        @if ($product->description)
            <div class="prose prose-slate max-w-none prose-headings:font-semibold prose-a:text-brand-700">
                {!! $product->description !!}
            </div>
        @else
            <p class="text-slate-500">Conteúdo detalhado deste produto em atualização.</p>
        @endif
    </article>

    @if ($related->isNotEmpty())
        <section class="bg-white border-t border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Outros produtos de {{ $product->categoryLabel() }}</h2>
                <div class="grid sm:grid-cols-3 gap-6">
                    @foreach ($related as $item)
                        <x-product-card :product="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
