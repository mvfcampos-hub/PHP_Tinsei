@extends('layouts.app')

@section('title', 'Casos de Sucesso')
@section('description', 'Conheça empresas que simplificaram sua gestão com a Databit: histórias reais de clientes que evoluíram com o DataClassic e o ecossistema Databit.')
@section('canonical', route('success-stories.index'))

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                Casos de Sucesso
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white">Confira quem já simplificou a sua gestão</h1>
            <p class="text-brand-200 mt-4 max-w-2xl mx-auto text-lg">
                Empresas de todo o Brasil que evoluíram sua gestão com a Databit — em suas próprias palavras.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-16 space-y-10">
        @forelse ($stories as $story)
            <article class="rounded-2xl border border-slate-200 bg-white overflow-hidden grid md:grid-cols-5">
                <div class="md:col-span-2 bg-slate-950 aspect-video md:self-center md:m-4 md:rounded-xl overflow-hidden">
                    @if ($story->video_url)
                        <video
                            class="w-full h-full object-cover"
                            controls
                            preload="metadata"
                            controlsList="nodownload"
                        >
                            <source src="{{ $story->video_url }}" type="video/mp4">
                        </video>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-brand-300 p-6 text-center">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-accent-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" /></svg>
                            </span>
                            <p class="text-xs font-semibold text-white">{{ $story->company }}</p>
                            <p class="text-[11px] text-brand-300">Depoimento em vídeo em breve</p>
                        </div>
                    @endif
                </div>
                <div class="md:col-span-3 p-6 sm:p-8 flex flex-col justify-center">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">{{ $story->company }}</h2>
                    <p class="text-sm font-semibold text-brand-700 mt-1">
                        {{ $story->location }}
                        @if ($story->client_since)
                            · Cliente desde {{ $story->client_since }}
                        @endif
                    </p>
                    <p class="text-slate-600 mt-4">{{ $story->highlight }}</p>
                    @if ($story->video_person)
                        <p class="text-sm text-slate-400 mt-4 pt-4 border-t border-slate-100">
                            {{ $story->video_person }}@if ($story->video_role), {{ $story->video_role }}@endif
                        </p>
                    @endif
                </div>
            </article>
        @empty
            <p class="text-center text-slate-500">Em breve, novos casos de sucesso por aqui.</p>
        @endforelse
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Pronto para simplificar a sua gestão também?</h2>
                <p class="text-brand-100 mt-2">Fale com a gente e descubra a solução ideal para o seu negócio.</p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero conhecer as soluções da Databit.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com um especialista
            </a>
        </div>
    </section>
@endsection
