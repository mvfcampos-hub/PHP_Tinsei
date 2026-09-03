@extends('layouts.app')

@section('title', $product->name)
@section('description', $product->summary ?? '')
@section('canonical', route('products.show', $product->slug))
@if ($product->cover_image)
    @section('og_image', Storage::url($product->cover_image))
@endif

@push('schema')
    <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => $product->name,
            'description' => $product->summary,
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'brand' => ['@type' => 'Brand', 'name' => 'Databit'],
            'url' => route('products.show', $product->slug),
            'image' => $product->cover_image ? Storage::url($product->cover_image) : null,
        ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-200 hover:text-white mb-6">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
                Voltar para sistemas
            </a>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                {{ $product->categoryLabel() }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white max-w-3xl">{{ $product->name }}</h1>
            @if ($product->tagline)
                <p class="text-brand-200 mt-4 max-w-2xl text-lg">{{ $product->tagline }}</p>
            @endif

            <div class="flex flex-wrap gap-3 mt-8">
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Tenho interesse no produto ' . $product->name . '.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-5 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
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

    @if ($product->youtubeEmbedUrl())
        <section class="py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-10 items-center">
                    <div>
                        @if ($product->logo_image)
                            <img src="{{ Storage::url($product->logo_image) }}" alt="{{ $product->name }}" class="h-10 sm:h-12 w-auto mb-6">
                        @endif
                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $product->tagline ?: $product->name }}</h2>
                        <p class="text-slate-600 mt-4 text-base sm:text-lg leading-relaxed">{{ $product->summary }}</p>
                        <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Tenho interesse no produto ' . $product->name . '.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 transition mt-6">
                            Falar com um especialista
                        </a>
                    </div>
                    <div class="relative aspect-video rounded-2xl overflow-hidden shadow-xl bg-slate-950">
                        <iframe
                            src="{{ $product->youtubeEmbedUrl() }}"
                            title="Vídeo demonstrativo — {{ $product->name }}"
                            class="absolute inset-0 h-full w-full"
                            loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        ></iframe>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (!empty($product->highlights))
        <section class="py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($product->highlights as $highlight)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-1 transition">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-500 text-white mb-4">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $highlight['icon'] }}" /></svg>
                            </span>
                            <h3 class="font-semibold text-slate-900 mb-2">{{ $highlight['title'] }}</h3>
                            <p class="text-sm text-slate-500">{{ $highlight['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 pb-16 {{ empty($product->highlights) ? 'pt-16' : '' }}">
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
