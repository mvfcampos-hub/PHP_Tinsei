@extends('layouts.app')

@section('title', 'Portfólio de produtos')
@section('description', 'Equipamentos de impressão novos e recondicionados, suprimentos e peças: mais de 1.800 itens no portfólio da Tinsei para revendas de todo o Brasil.')

@php $storeUrl = setting('store_url'); @endphp

@section('content')
<x-page-hero eyebrow="Portfólio" title="Portfólio de produtos"
    subtitle="{{ setting('portfolio_items') }} itens entre equipamentos novos, equipamentos recondicionados (Recon), suprimentos e peças — com estoque, procedência e suporte de quem é especialista em impressão.">
    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ $storeUrl }}" target="_blank" rel="noopener" class="btn-gold !px-7 !py-4 text-base" onclick="window.trackEvent && window.trackEvent('store_click', { location: 'portfolio_hero' })">
            <x-ico name="grid" class="h-5 w-5" /> Acessar a loja completa
        </a>
        <a href="{{ setting('store_reseller_url') }}" target="_blank" rel="noopener" class="btn-ghost-light !px-7 !py-4 text-base">Cadastre sua revenda para ver preços</a>
    </div>
</x-page-hero>

<section class="bg-white py-20 sm:py-24">
    <div class="container-site space-y-8">
        @foreach ($categories as $category)
            <article class="reveal card overflow-hidden lg:grid lg:grid-cols-5">
                <div class="relative min-h-[240px] overflow-hidden bg-white lg:col-span-2 lg:border-r lg:border-slate-100">
                    @if ($category->image)
                        <img src="{{ media_url($category->image) }}" alt="" loading="lazy" class="absolute inset-0 h-full w-full object-contain p-8 mix-blend-multiply">
                    @else
                        <span class="absolute inset-0 flex items-center justify-center text-brand-200"><x-ico :name="$category->icon ?: 'box'" class="h-24 w-24 opacity-80" /></span>
                    @endif
                    @if ($category->item_count_label)
                        <span class="absolute left-5 top-5 z-10 rounded-full bg-gold-400 px-3 py-1 text-xs font-bold text-brand-950">{{ $category->item_count_label }}</span>
                    @endif
                </div>
                <div class="p-7 sm:p-10 lg:col-span-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-800 text-gold-300"><x-ico :name="$category->icon ?: 'box'" class="h-5 w-5" /></span>
                    <h2 class="mt-4 text-2xl font-bold text-brand-900">{{ $category->name }}</h2>
                    @if ($category->tagline)<p class="mt-1 font-medium text-gold-600">{{ $category->tagline }}</p>@endif
                    @if ($category->description)<p class="mt-4 leading-relaxed text-slate-600">{{ $category->description }}</p>@endif
                    @if (! empty($category->highlights))
                        <ul class="mt-6 grid gap-2.5 sm:grid-cols-2">
                            @foreach ($category->highlights as $highlight)
                                <li class="flex items-start gap-2 text-sm text-slate-600"><x-ico name="check" class="mt-0.5 h-4 w-4 shrink-0 text-leaf-600" /> {{ $highlight }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <a href="{{ $category->storeUrl() }}" target="_blank" rel="noopener" class="btn-primary mt-8">Ver {{ \Illuminate\Support\Str::lower($category->name) }} na loja <x-ico name="arrow-up-right" class="h-4 w-4" /></a>
                </div>
            </article>
        @endforeach
    </div>
</section>

@if ($brands->isNotEmpty())
    <section class="bg-slate-50 py-20">
        <div class="container-site">
            <x-section-heading align="center" eyebrow="Marcas" title="Soluções para as principais marcas do mercado" subtitle="Equipamentos, suprimentos e peças compatíveis com os fabricantes mais presentes no parque de impressão brasileiro." />
            <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                @foreach ($brands as $brand)
                    <a href="{{ $brand->url ?: $storeUrl }}" target="_blank" rel="noopener" class="card flex h-24 flex-col items-center justify-center px-4 text-center transition hover:border-brand-300 hover:shadow-soft">
                        @if ($brand->logo)
                            <img src="{{ media_url($brand->logo) }}" alt="{{ $brand->name }}" class="max-h-10 w-auto">
                        @else
                            <span class="font-display text-lg font-bold uppercase tracking-wide text-brand-800">{{ $brand->name }}</span>
                        @endif
                        @if ($brand->note)<span class="mt-1 text-[11px] text-slate-400">{{ $brand->note }}</span>@endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="bg-white py-20">
    <div class="container-site grid gap-6 md:grid-cols-3">
        @foreach ([
            ['search', 'Busque do seu jeito', 'Por código, referência, nome, fabricante ou modelo do equipamento — exatamente como na loja.'],
            ['truck', 'Entrega em todo o Brasil', 'Distribuição a partir de Belo Horizonte para todas as regiões do país.'],
            ['handshake', 'Atendimento especializado', 'Equipe comercial e técnica que fala a língua da sua revenda.'],
        ] as [$icon, $title, $text])
            <div class="flex gap-4">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gold-100 text-gold-700"><x-ico :name="$icon" class="h-6 w-6" /></span>
                <div>
                    <h3 class="font-semibold text-brand-900">{{ $title }}</h3>
                    <p class="mt-1 text-sm leading-relaxed text-slate-500">{{ $text }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
