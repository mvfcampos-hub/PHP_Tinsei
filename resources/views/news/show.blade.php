@extends('layouts.app')

@section('title', $news->title)
@section('description', $news->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($news->body), 155))
@section('og_type', 'article')
@if ($news->coverUrl())
    @section('og_image', $news->coverUrl())
@endif

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $news->title,
    'datePublished' => $news->published_at?->toAtomString(),
    'dateModified' => $news->updated_at?->toAtomString(),
    'image' => $news->coverUrl(),
    'publisher' => ['@type' => 'Organization', 'name' => 'Tinsei', 'logo' => ['@type' => 'ImageObject', 'url' => asset('images/brand/logo-tinsei-color.png')]],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<article>
    <header class="relative overflow-hidden bg-brand-950 bg-grid-pattern bg-grid">
        <div class="container-site relative max-w-4xl py-16">
            <nav class="mb-6 text-xs text-brand-300"><a href="{{ route('home') }}" class="hover:text-white">Início</a> <span class="mx-1">/</span> <a href="{{ route('news.index') }}" class="hover:text-white">Notícias</a></nav>
            @if ($news->category)<span class="rounded-full bg-gold-400 px-3 py-1 text-xs font-bold text-brand-950">{{ $news->category }}</span>@endif
            <h1 class="mt-5 text-3xl font-bold leading-tight text-white sm:text-5xl">{{ $news->title }}</h1>
            @if ($news->excerpt)<p class="mt-5 text-lg text-brand-100/90">{{ $news->excerpt }}</p>@endif
            <p class="mt-6 text-sm text-brand-300">
                <time datetime="{{ $news->published_at->toDateString() }}">{{ $news->published_at->translatedFormat('d \d\e F \d\e Y') }}</time>
                @if ($news->source_name) · Fonte: {{ $news->source_name }} @endif
            </p>
        </div>
    </header>

    <div class="container-site max-w-4xl py-14">
        @if ($news->youtubeId())
            <x-youtube :url="$news->video_url" :title="$news->title" class="mb-10" />
        @elseif ($news->cover_image)
            <img src="{{ $news->coverUrl() }}" alt="" class="mb-10 w-full rounded-3xl object-cover shadow-soft">
        @endif

        <div class="prose prose-lg prose-slate max-w-none prose-headings:font-display prose-headings:text-brand-900 prose-a:text-brand-700">
            {!! $news->body !!}
        </div>

        @if ($news->source_url)
            <a href="{{ $news->source_url }}" target="_blank" rel="noopener" class="mt-10 flex items-center justify-between gap-4 rounded-2xl border border-slate-200 p-5 transition hover:border-brand-300 hover:shadow-soft">
                <span><span class="block text-xs text-slate-500">Leia a matéria completa</span><span class="font-semibold text-brand-900">{{ $news->source_name ?: parse_url($news->source_url, PHP_URL_HOST) }}</span></span>
                <x-ico name="arrow-up-right" class="h-5 w-5 text-brand-600" />
            </a>
        @endif

        <div class="mt-12 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-8 text-sm">
            <span class="font-semibold text-slate-500">Compartilhar:</span>
            <a href="https://wa.me/?text={{ urlencode($news->title.' '.url()->current()) }}" target="_blank" rel="noopener" class="rounded-full bg-slate-100 px-4 py-2 font-semibold text-slate-700 hover:bg-slate-200">WhatsApp</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="rounded-full bg-slate-100 px-4 py-2 font-semibold text-slate-700 hover:bg-slate-200">LinkedIn</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="rounded-full bg-slate-100 px-4 py-2 font-semibold text-slate-700 hover:bg-slate-200">Facebook</a>
        </div>
    </div>
</article>

@if ($related->isNotEmpty())
    <section class="bg-slate-50 py-16">
        <div class="container-site">
            <h2 class="text-2xl font-bold text-brand-900">Leia também</h2>
            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach ($related as $item)<x-news-card :news="$item" />@endforeach
            </div>
        </div>
    </section>
@endif
@endsection
