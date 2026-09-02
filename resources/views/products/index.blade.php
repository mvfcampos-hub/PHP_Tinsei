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
                Soluções de sistemas, Cloud e Serviços de TI — cada frente com o seu próprio espaço,
                tudo integrado para simplificar a gestão da sua empresa.
            </p>
        </div>

        @if ($ecosystemHub)
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-16">
                <p class="hidden lg:block text-center text-sm text-brand-200 mb-8">
                    Clique em qualquer módulo para conhecer os detalhes
                </p>
                <x-ecosystem-diagram :hub="$ecosystemHub" :satellites="$ecosystemSatellites" />
            </div>
        @endif
    </section>

    {{-- Soluções de sistemas --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-10">
            <span class="text-xs font-semibold text-accent-600 uppercase tracking-wide">Soluções de sistemas</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">ERP, mobilidade, atendimento, fiscal, CRM e comunicação</h2>
            <p class="text-slate-500 mt-2 max-w-2xl">Módulos integrados ao redor do DataClassic, o núcleo do ecossistema Databit.</p>
        </div>

        <div class="space-y-14">
            @forelse ($systemProducts as $category => $items)
                <div>
                    <h3 class="text-lg font-bold text-slate-900 mb-6">
                        {{ \App\Models\Product::CATEGORIES[$category] ?? $category }}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($items as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-slate-500 text-center">Nenhuma solução de sistema cadastrada no momento.</p>
            @endforelse
        </div>
    </section>

    {{-- Cloud & Infraestrutura --}}
    @if ($cloudProducts->isNotEmpty())
        <section class="bg-brand-950 bg-grid-pattern">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                    <div>
                        <span class="text-xs font-semibold text-accent-400 uppercase tracking-wide">Infraestrutura, não sistema</span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white mt-1">Cloud & Infraestrutura</h2>
                        <p class="text-brand-200 mt-2 max-w-2xl">Máquinas virtuais e infraestrutura sob demanda para hospedar os seus sistemas — tratado à parte das soluções de sistemas.</p>
                    </div>
                    <a href="{{ route('cloud.show') }}" class="inline-flex items-center gap-1 text-accent-300 font-medium hover:text-accent-200 shrink-0">
                        Ver planos DataCloud
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($cloudProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Serviços de TI --}}
    @if ($tiProducts->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="mb-10">
                <span class="text-xs font-semibold text-accent-600 uppercase tracking-wide">Serviço, não sistema</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Serviços de TI</h2>
                <p class="text-slate-500 mt-2 max-w-2xl">Consultoria, suporte técnico e infraestrutura para manter sua operação no ar — tratado à parte das soluções de sistemas e do DataCloud.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($tiProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
