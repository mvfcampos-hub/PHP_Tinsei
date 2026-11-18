@extends('layouts.app')

@section('title', 'Busca')
@section('robots', 'noindex, follow')

@section('content')
<x-page-hero title="Busca no site" :subtitle="$term !== '' ? $totalResults.' resultado(s) para “'.$term.'”' : 'Digite um termo para buscar.'">
    <form action="{{ route('search') }}" method="GET" class="mt-8 flex max-w-xl overflow-hidden rounded-2xl bg-white p-1.5">
        <input type="search" name="q" value="{{ $term }}" placeholder="Buscar notícias, eventos e páginas..." class="min-w-0 flex-1 border-0 px-3 text-sm focus:outline-none focus:ring-0" aria-label="Termo de busca">
        <button class="btn-gold !rounded-xl !py-2.5">Buscar</button>
    </form>
</x-page-hero>

<section class="bg-slate-50 py-16">
    <div class="container-site max-w-4xl space-y-10">
        <div class="rounded-2xl border border-gold-200 bg-gold-50 p-5 text-sm text-gold-900">
            Procurando um <strong>produto, toner, peça ou equipamento</strong>?
            <a href="{{ rtrim(setting('store_url'), '/') }}/filter/?type=0&term={{ urlencode($term) }}&name={{ urlencode($term) }}" target="_blank" rel="noopener" class="font-semibold underline">Busque “{{ $term ?: 'produto' }}” na loja →</a>
        </div>

        @foreach ([['Notícias', $news], ['Páginas', $pages], ['Agenda', $events]] as [$label, $items])
            @if ($items->isNotEmpty())
                <div>
                    <h2 class="text-lg font-bold text-brand-900">{{ $label }}</h2>
                    <ul class="mt-4 divide-y divide-slate-200 rounded-2xl border border-slate-200 bg-white">
                        @foreach ($items as $item)
                            @php
                                $url = match (true) {
                                    $item instanceof \App\Models\News => route('news.show', $item->slug),
                                    $item instanceof \App\Models\Page => route('pages.show', $item->slug),
                                    default => route('events.index'),
                                };
                            @endphp
                            <li><a href="{{ $url }}" class="block px-5 py-4 hover:bg-brand-50/50"><span class="font-semibold text-brand-900">{{ $item->title }}</span>
                                <span class="mt-0.5 block text-sm text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags($item->excerpt ?? $item->description ?? $item->content ?? ''), 140) }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach

        @if ($term !== '' && $totalResults === 0)
            <p class="text-slate-500">Nenhum resultado encontrado no conteúdo do site.</p>
        @endif
    </div>
</section>
@endsection
