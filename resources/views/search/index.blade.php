@extends('layouts.app')

@section('title', $term !== '' ? 'Busca: '.$term : 'Buscar')
@section('description', 'Busque sistemas, serviços, novidades e páginas institucionais da Databit.')
@section('canonical', route('search'))
@section('robots', 'noindex, follow')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Buscar no site</h1>

            <form action="{{ route('search') }}" method="GET" class="mt-6 max-w-xl">
                <label for="search-q" class="sr-only">Buscar</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    <input
                        id="search-q"
                        type="search"
                        name="q"
                        value="{{ $term }}"
                        placeholder="Buscar sistemas, serviços, novidades..."
                        autofocus
                        class="w-full rounded-xl border border-slate-300 bg-white pl-11 pr-28 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none"
                    >
                    <button type="submit" class="absolute right-1.5 top-1.5 rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800 transition">
                        Buscar
                    </button>
                </div>
            </form>

            @if ($term !== '')
                <p class="text-slate-500 mt-4 text-sm">
                    {{ $totalResults }} {{ $totalResults === 1 ? 'resultado encontrado' : 'resultados encontrados' }} para
                    <strong class="text-slate-700">&ldquo;{{ $term }}&rdquo;</strong>
                </p>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 space-y-14">
        @if ($term === '')
            <p class="text-slate-500">Digite um termo acima para buscar em sistemas, DataCloud, serviços de TI, novidades, agenda e páginas institucionais.</p>
        @elseif ($totalResults === 0)
            <div class="text-center py-12">
                <p class="text-lg font-semibold text-slate-800">Nenhum resultado encontrado</p>
                <p class="text-slate-500 mt-2">Tente buscar por outro termo ou navegue pelo menu principal.</p>
            </div>
        @else
            @if ($products->isNotEmpty())
                <div>
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wide mb-4">Sistemas ({{ $products->count() }})</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($news->isNotEmpty())
                <div>
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wide mb-4">Notícias ({{ $news->count() }})</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($news as $item)
                            <x-news-card :news="$item" />
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($articles->isNotEmpty())
                <div>
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wide mb-4">Base de Conhecimento ({{ $articles->count() }})</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($articles as $article)
                            <x-kb-article-card :article="$article" />
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($events->isNotEmpty())
                <div>
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wide mb-4">Agenda ({{ $events->count() }})</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($events as $event)
                            <x-event-card :event="$event" />
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($pages->isNotEmpty())
                <div>
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wide mb-4">Páginas ({{ $pages->count() }})</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($pages as $page)
                            <a href="{{ route('pages.show', $page->slug) }}" class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-5 hover:shadow-md hover:border-brand-200 transition">
                                <span class="font-semibold text-slate-900">{{ $page->title }}</span>
                                <svg class="h-4 w-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </section>
@endsection
