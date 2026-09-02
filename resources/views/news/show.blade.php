@extends('layouts.app')

@section('title', $news->title)
@section('description', $news->excerpt ?? '')

@section('content')
    <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mb-6">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
            Voltar para novidades
        </a>

        @if ($news->category)
            <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700 mb-4">
                {{ $news->category }}
            </span>
        @endif

        <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight">{{ $news->title }}</h1>
        <p class="text-slate-400 text-sm mt-3">
            Publicado em {{ optional($news->published_at)->translatedFormat('d \d\e F \d\e Y') }}
            @if ($news->author) &middot; por {{ $news->author->name }} @endif
        </p>

        @if ($news->cover_image)
            <img src="{{ Storage::url($news->cover_image) }}" alt="{{ $news->title }}" class="w-full rounded-2xl mt-8 mb-8 object-cover max-h-[420px]">
        @endif

        <div class="prose prose-slate max-w-none prose-headings:font-semibold prose-a:text-brand-700">
            {!! $news->body !!}
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="bg-white border-t border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Novidades relacionadas</h2>
                <div class="grid sm:grid-cols-3 gap-6">
                    @foreach ($related as $item)
                        <x-news-card :news="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
