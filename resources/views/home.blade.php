@extends('layouts.app')

@section('title', 'Início')

@section('content')

    {{-- Hero / banners de campanha --}}
    <section class="relative bg-brand-900">
        @if ($heroBanners->isNotEmpty())
            <div x-data="{ active: 0, total: {{ $heroBanners->count() }} }"
                 x-init="setInterval(() => active = (active + 1) % total, 6000)"
                 class="relative h-[380px] sm:h-[460px] overflow-hidden">
                @foreach ($heroBanners as $index => $banner)
                    <a href="{{ $banner->link_url ?? '#' }}"
                       x-show="active === {{ $index }}" x-transition:enter.duration.700ms
                       class="absolute inset-0 block">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-full w-full object-cover opacity-70">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-950/90 via-brand-950/30 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-10">
                            <div class="mx-auto max-w-7xl">
                                <h2 class="text-2xl sm:text-4xl font-bold text-white max-w-2xl">{{ $banner->title }}</h2>
                            </div>
                        </div>
                    </a>
                @endforeach

                @if ($heroBanners->count() > 1)
                    <div class="absolute bottom-4 right-4 sm:right-10 flex gap-2">
                        @foreach ($heroBanners as $index => $banner)
                            <button @click="active = {{ $index }}" class="h-2.5 w-2.5 rounded-full bg-white" :class="active === {{ $index }} ? 'opacity-100' : 'opacity-40'"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="h-[300px] flex items-center justify-center text-brand-100">
                <p>Nenhum banner de destaque cadastrado.</p>
            </div>
        @endif
    </section>

    {{-- Acesso rápido --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'Banco de Oportunidades', 'route' => 'jobs.index', 'path' => 'M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a1 1 0 00-1 1v10a2 2 0 002 2h14a2 2 0 002-2V8a1 1 0 00-1-1zM10 5h4v2h-4V5zm10 13a1 1 0 01-1 1H5a1 1 0 01-1-1v-4.05c.32.033.654.05 1 .05h3v1a1 1 0 002 0v-1h4v1a1 1 0 002 0v-1h3c.346 0 .68-.017 1-.05V18zm0-7c0 1.103-.897 2-2 2h-3v-1a1 1 0 00-2 0v1h-4v-1a1 1 0 00-2 0v1H5c-1.103 0-2-.897-2-2V9h18v2z'],
                ['label' => 'Revista CRN-9', 'route' => 'magazines.index', 'path' => 'M4 19.5A2.5 2.5 0 016.5 17H20M4 19.5A2.5 2.5 0 006.5 22H20V4H6.5A2.5 2.5 0 004 6.5v13z'],
                ['label' => 'Fiscalização', 'route' => 'inspectors.index', 'path' => 'M12 2l8 3.5v5.4c0 5-3.4 9.4-8 10.6-4.6-1.2-8-5.6-8-10.6V5.5L12 2z'],
                ['label' => 'Profissionais por Município', 'route' => 'municipalities.index', 'path' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
            ] as $quick)
                <a href="{{ route($quick['route']) }}" class="flex flex-col items-center gap-2 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition p-5 text-center">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $quick['path'] }}" /></svg>
                    </span>
                    <span class="text-sm font-medium text-slate-700">{{ $quick['label'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Notícias em destaque --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Notícias em destaque</h2>
                <p class="text-slate-500 mt-1">Fique por dentro das novidades do CRN-9</p>
            </div>
            <a href="{{ route('news.index') }}" class="hidden sm:inline-flex items-center gap-1 text-brand-700 font-medium hover:text-brand-800">
                Ver todas
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($featuredNews as $news)
                <x-news-card :news="$news" />
            @empty
                <p class="text-slate-500 col-span-full">Nenhuma notícia em destaque no momento.</p>
            @endforelse
        </div>
    </section>

    {{-- Agenda + últimas notícias --}}
    <section class="bg-white border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="flex items-end justify-between mb-8">
                    <h2 class="text-2xl font-bold text-slate-900">Últimas notícias</h2>
                    <a href="{{ route('news.index') }}" class="text-brand-700 font-medium hover:text-brand-800 text-sm">Ver todas</a>
                </div>
                <div class="grid sm:grid-cols-2 gap-6">
                    @foreach ($latestNews as $news)
                        <x-news-card :news="$news" />
                    @endforeach
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between mb-8">
                    <h2 class="text-2xl font-bold text-slate-900">Agenda</h2>
                    <a href="{{ route('events.index') }}" class="text-brand-700 font-medium hover:text-brand-800 text-sm">Ver tudo</a>
                </div>
                <div class="space-y-4">
                    @forelse ($upcomingEvents as $event)
                        <x-event-card :event="$event" />
                    @empty
                        <p class="text-slate-500">Nenhum evento agendado no momento.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- Banners secundários / campanhas --}}
    @if ($secondaryBanners->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid sm:grid-cols-2 gap-6">
                @foreach ($secondaryBanners as $banner)
                    <a href="{{ $banner->link_url ?? '#' }}" class="group relative rounded-2xl overflow-hidden h-52 block">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-950/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-white font-semibold text-lg">{{ $banner->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

@endsection
