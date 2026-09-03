@extends('layouts.app')

@section('title', $page->title)
@section('description', \Illuminate\Support\Str::limit(strip_tags($page->content), 155))
@section('canonical', route('pages.show', $page->slug))

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">{{ $page->title }}</h1>
        </div>
    </section>

    <article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="prose prose-slate max-w-none prose-a:text-brand-700">
            {!! $page->content !!}
        </div>

        @if ($page->slug === 'fale-conosco')
            <div class="mt-10 rounded-2xl overflow-hidden border border-slate-200 shadow-sm not-prose">
                <iframe
                    src="https://www.google.com/maps?q={{ urlencode('R. Mário Campos, 197 - Inconfidência, Belo Horizonte - MG, 30820-280') }}&output=embed"
                    class="w-full h-80 sm:h-96"
                    style="border:0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Localização da Databit"
                ></iframe>
            </div>
            <a
                href="https://maps.app.goo.gl/Y4YGdrJBr5TxJvMk6"
                target="_blank" rel="noopener"
                class="not-prose inline-flex items-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-800 mt-4"
            >
                Abrir no Google Maps
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
            </a>
        @endif
    </article>
@endsection
