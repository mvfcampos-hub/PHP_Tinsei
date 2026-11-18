@extends('layouts.app')

@section('title', 'Notícias')
@section('description', 'Novidades, lançamentos, vídeos e a Tinsei na mídia.')

@section('content')
<x-page-hero eyebrow="Notícias" title="Notícias e novidades" subtitle="Lançamentos, conteúdos técnicos, sustentabilidade e a Tinsei na mídia." />

<section class="bg-slate-50 py-16 sm:py-20">
    <div class="container-site">
        @if ($categories->isNotEmpty())
            <nav class="mb-10 flex flex-wrap gap-2" aria-label="Filtrar por categoria">
                <a href="{{ route('news.index') }}" @class(['rounded-full px-4 py-2 text-sm font-semibold transition', 'bg-brand-800 text-white' => ! $category, 'bg-white text-slate-600 hover:bg-brand-50 border border-slate-200' => $category])>Todas</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('news.index', ['categoria' => $cat]) }}" @class(['rounded-full px-4 py-2 text-sm font-semibold transition', 'bg-brand-800 text-white' => $category === $cat, 'bg-white text-slate-600 hover:bg-brand-50 border border-slate-200' => $category !== $cat])>{{ $cat }}</a>
                @endforeach
            </nav>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($news as $item)
                <x-news-card :news="$item" />
            @empty
                <p class="text-slate-500">Nenhuma notícia publicada ainda.</p>
            @endforelse
        </div>

        <div class="mt-12">{{ $news->links() }}</div>
    </div>
</section>
@endsection
