@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->excerpt ?? 'Artigo da Base de Conhecimento Databit.')

@section('content')
    <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('kb.index', array_filter(['tipo' => $article->solution_type])) }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mb-6">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
            Voltar para a Base de Conhecimento
        </a>

        <div class="flex flex-wrap items-center gap-2 mb-4">
            <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700">
                {{ $article->solutionTypeLabel() }}
            </span>
            @if ($article->product)
                <a href="{{ route('kb.index', ['modulo' => $article->product_id]) }}" class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 hover:bg-slate-200 transition">
                    {{ $article->product->name }}
                </a>
            @endif
        </div>

        <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight">{{ $article->title }}</h1>
        @if ($article->excerpt)
            <p class="text-lg text-slate-500 mt-3">{{ $article->excerpt }}</p>
        @endif

        @if ($article->videoEmbedUrl())
            <div class="mt-8 rounded-2xl overflow-hidden aspect-video bg-slate-950">
                <iframe
                    src="{{ $article->videoEmbedUrl() }}"
                    class="w-full h-full"
                    title="{{ $article->title }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
            </div>
        @elseif ($article->cover_image)
            <img src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}" class="w-full rounded-2xl mt-8 object-cover max-h-[420px]">
        @endif

        <div class="prose prose-slate max-w-none prose-headings:font-semibold prose-a:text-brand-700 mt-8">
            {!! $article->content !!}
        </div>

        <div class="mt-10">
            <x-kb-ask-ai :solution-type="$article->solution_type" />
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="bg-white border-t border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Artigos relacionados</h2>
                <div class="grid sm:grid-cols-3 gap-6">
                    @foreach ($related as $item)
                        <x-kb-article-card :article="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Ainda com dúvidas?</h2>
                <p class="text-brand-100 mt-2">Fale diretamente com a nossa equipe de suporte.</p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Estou com uma dúvida sobre: '.$article->title) }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com o suporte
            </a>
        </div>
    </section>
@endsection
