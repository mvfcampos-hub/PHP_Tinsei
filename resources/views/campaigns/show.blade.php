@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">{{ $campaign->title }}</h1>
        </div>
    </section>

    <article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        @if ($campaign->intro)
            <div class="prose prose-slate max-w-none prose-a:text-brand-700 mb-10">
                {!! $campaign->intro !!}
            </div>
        @endif

        @if ($campaign->episodes->isNotEmpty())
            <div class="space-y-10">
                @foreach ($campaign->episodes as $episode)
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">{{ $episode->title }}</h3>
                        <iframe
                            class="aspect-video w-full rounded-lg border border-slate-200"
                            src="{{ $episode->embed_url }}"
                            title="{{ $episode->title }}"
                            allowfullscreen
                        ></iframe>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-slate-500">Nenhum vídeo publicado para esta campanha até o momento.</p>
        @endif
    </article>
@endsection
