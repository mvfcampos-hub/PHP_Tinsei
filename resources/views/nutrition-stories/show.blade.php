@extends('layouts.app')

@section('title', $story->title)

@section('content')
    <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('nutrition-stories.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mb-6">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
            Voltar para Nutrição em Minas
        </a>

        @if ($story->cover_image)
            <div class="aspect-[16/9] rounded-2xl overflow-hidden mb-6">
                <img src="{{ Storage::url($story->cover_image) }}" alt="{{ $story->title }}" class="h-full w-full object-cover">
            </div>
        @endif

        <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700">{{ $story->area }}</span>
        <h1 class="text-3xl font-bold text-slate-900 mt-3">{{ $story->title }}</h1>
        <p class="text-slate-500 mt-2 text-sm">
            @if ($story->role) {{ $story->role }} &middot; @endif {{ $story->region }}
        </p>

        <div class="prose prose-slate max-w-none mt-8">
            {!! nl2br(e($story->body)) !!}
        </div>

        @if ($related->isNotEmpty())
            <div class="mt-16 pt-10 border-t border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Outras histórias em {{ $story->area }}</h2>
                <div class="grid sm:grid-cols-3 gap-4">
                    @foreach ($related as $item)
                        <a href="{{ route('nutrition-stories.show', $item) }}" class="rounded-xl border border-slate-200 bg-white p-4 hover:border-brand-300 hover:shadow-sm transition">
                            <h3 class="text-sm font-semibold text-slate-900">{{ $item->title }}</h3>
                            <p class="text-xs text-slate-400 mt-1">{{ $item->region }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-12 rounded-xl border border-slate-200 bg-slate-50 p-6 text-center">
            <p class="text-sm text-slate-600">Você ou alguém que conhece também faz a diferença na Nutrição em Minas?</p>
            <a href="{{ route('nutrition-stories.suggest') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mt-2">
                Indicar uma história
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>
    </article>
@endsection
