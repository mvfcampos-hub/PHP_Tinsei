@extends('layouts.app')

@section('title', 'Início')

@section('content')

    {{-- Hero / banners de campanha --}}
    <section class="relative bg-brand-950 overflow-hidden">
        <div class="pointer-events-none absolute -top-24 -right-24 h-96 w-96 rounded-full bg-brand-leaf/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-16 h-80 w-80 rounded-full bg-brand-blue/10 blur-3xl"></div>

        @if ($heroBanners->isNotEmpty())
            <div x-data="{ active: 0, total: {{ $heroBanners->count() }} }"
                 x-init="setInterval(() => active = (active + 1) % total, 6500)"
                 class="relative h-[440px] sm:h-[520px] overflow-hidden">
                @foreach ($heroBanners as $index => $banner)
                    <a href="{{ $banner->link_url ?? '#' }}"
                       x-show="active === {{ $index }}" x-transition:enter.duration.700ms
                       class="absolute inset-0 block group">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-full w-full object-cover opacity-60 scale-105 group-hover:scale-100 transition-transform duration-[4s] ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-950 via-brand-950/60 to-brand-950/10"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-950/80 via-transparent to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-14">
                            <div class="mx-auto max-w-7xl">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 backdrop-blur px-3 py-1 text-xs font-semibold text-brand-leaf uppercase tracking-wide mb-4">
                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4" /></svg>
                                    CRN-9 em destaque
                                </span>
                                <h1 class="font-heading text-3xl sm:text-5xl font-bold text-white max-w-3xl leading-tight">{{ $banner->title }}</h1>
                                @if ($banner->subtitle)
                                    <p class="mt-3 text-base sm:text-lg text-brand-100 max-w-2xl">{{ $banner->subtitle }}</p>
                                @endif
                                <span class="inline-flex items-center gap-2 mt-6 text-white font-medium border-b-2 border-brand-orange pb-1 group-hover:gap-3 transition-all">
                                    Saiba mais
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach

                @if ($heroBanners->count() > 1)
                    <div class="absolute bottom-6 right-6 sm:right-14 flex gap-2">
                        @foreach ($heroBanners as $index => $banner)
                            <button
                                @click="active = {{ $index }}"
                                class="h-1.5 rounded-full bg-white transition-all duration-300"
                                :class="active === {{ $index }} ? 'w-8 opacity-100' : 'w-4 opacity-40 hover:opacity-70'"
                                aria-label="Ver destaque {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="h-[320px] flex items-center justify-center text-brand-100 relative">
                <p>Nenhum banner de destaque cadastrado.</p>
            </div>
        @endif
    </section>

    {{-- Estatísticas --}}
    <section class="relative z-10 -mt-10 sm:-mt-14">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-px rounded-2xl overflow-hidden shadow-xl bg-slate-200">
                @foreach ([
                    ['value' => '9ª', 'label' => 'Região do Sistema CFN/CRN'],
                    ['value' => '1 + 5', 'label' => 'Sede e delegacias em Minas Gerais'],
                    ['value' => $stats['fiscais'], 'label' => 'Fiscais em atuação'],
                    ['value' => '2', 'label' => 'Categorias profissionais atendidas'],
                ] as $stat)
                    <div class="bg-white p-5 sm:p-6 text-center">
                        <p class="font-heading text-2xl sm:text-3xl font-bold text-brand-700">{{ $stat['value'] }}</p>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-snug">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Acesso rápido --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-10 sm:mt-14">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'Banco de Oportunidades', 'route' => 'jobs.index', 'iconBg' => 'bg-brand-orange/10', 'iconText' => 'text-brand-orange', 'path' => 'M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a1 1 0 00-1 1v10a2 2 0 002 2h14a2 2 0 002-2V8a1 1 0 00-1-1zM10 5h4v2h-4V5zm10 13a1 1 0 01-1 1H5a1 1 0 01-1-1v-4.05c.32.033.654.05 1 .05h3v1a1 1 0 002 0v-1h4v1a1 1 0 002 0v-1h3c.346 0 .68-.017 1-.05V18zm0-7c0 1.103-.897 2-2 2h-3v-1a1 1 0 00-2 0v1h-4v-1a1 1 0 00-2 0v1H5c-1.103 0-2-.897-2-2V9h18v2z'],
                ['label' => 'Biblioteca Virtual', 'route' => 'library.index', 'iconBg' => 'bg-brand-blue/10', 'iconText' => 'text-brand-blue', 'path' => 'M4 19.5A2.5 2.5 0 016.5 17H20M4 19.5A2.5 2.5 0 006.5 22H20V4H6.5A2.5 2.5 0 004 6.5v13z'],
                ['label' => 'Equipe de Fiscalização', 'route' => 'inspectors.index', 'iconBg' => 'bg-brand-leaf/10', 'iconText' => 'text-brand-leaf', 'path' => 'M12 2l8 3.5v5.4c0 5-3.4 9.4-8 10.6-4.6-1.2-8-5.6-8-10.6V5.5L12 2z'],
                ['label' => 'Profissionais por Município', 'route' => 'municipalities.index', 'iconBg' => 'bg-brand-100', 'iconText' => 'text-brand-700', 'path' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
            ] as $quick)
                <a href="{{ route($quick['route']) }}" class="group flex flex-col items-center gap-3 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-transparent transition-all duration-300 p-5 sm:p-6 text-center">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl {{ $quick['iconBg'] }} {{ $quick['iconText'] }} group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $quick['path'] }}" /></svg>
                    </span>
                    <span class="text-sm font-semibold text-slate-700 group-hover:text-brand-800 transition-colors">{{ $quick['label'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Serviços por perfil --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="max-w-2xl mb-10">
            <span class="text-sm font-semibold text-brand-700 uppercase tracking-wide">Serviços</span>
            <h2 class="font-heading text-2xl sm:text-3xl font-bold text-slate-900 mt-2">O que você precisa fazer hoje?</h2>
            <p class="text-slate-500 mt-2">Encontre rapidamente os serviços do CRN-9 para o seu perfil.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ([
                [
                    'title' => 'Nutricionistas',
                    'description' => 'Inscrição, anuidade, transferência, baixa temporária e demais serviços para nutricionistas.',
                    'slug' => 'servicos-nutricionistas',
                    'ring' => 'hover:border-brand-leaf/40',
                    'blob' => 'bg-brand-leaf/5 group-hover:bg-brand-leaf/10',
                    'iconBg' => 'bg-brand-leaf/10',
                    'iconText' => 'text-brand-leaf',
                    'path' => 'M12 4.5v15m0-15c-2.5 0-4.5 2-4.5 4.5S9.5 13.5 12 13.5m0-9c2.5 0 4.5 2 4.5 4.5S14.5 13.5 12 13.5m0 6a3 3 0 100-6 3 3 0 000 6z',
                ],
                [
                    'title' => 'Técnicos em Nutrição e Dietética',
                    'description' => 'Inscrição, anuidade, transferência, baixa temporária e demais serviços para TNDs.',
                    'slug' => 'servicos-tnd',
                    'ring' => 'hover:border-brand-orange/40',
                    'blob' => 'bg-brand-orange/5 group-hover:bg-brand-orange/10',
                    'iconBg' => 'bg-brand-orange/10',
                    'iconText' => 'text-brand-orange',
                    'path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
                [
                    'title' => 'Pessoa Jurídica',
                    'description' => 'Registro de empresas, responsabilidade técnica, certidões e anuidade de pessoa jurídica.',
                    'slug' => 'servicos-pessoa-juridica',
                    'ring' => 'hover:border-brand-blue/40',
                    'blob' => 'bg-brand-blue/5 group-hover:bg-brand-blue/10',
                    'iconBg' => 'bg-brand-blue/10',
                    'iconText' => 'text-brand-blue',
                    'path' => 'M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9h.01M9 12h.01M9 15h.01',
                ],
            ] as $profile)
                <a href="{{ route('pages.show', $profile['slug']) }}" class="group relative flex flex-col rounded-2xl border border-slate-200 bg-white p-7 hover:shadow-xl hover:-translate-y-1 {{ $profile['ring'] }} transition-all duration-300 overflow-hidden">
                    <div class="absolute -right-6 -top-6 h-28 w-28 rounded-full {{ $profile['blob'] }} transition-colors"></div>
                    <span class="relative flex h-12 w-12 items-center justify-center rounded-xl {{ $profile['iconBg'] }} {{ $profile['iconText'] }} mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $profile['path'] }}" /></svg>
                    </span>
                    <h3 class="relative font-heading text-lg font-semibold text-slate-900">{{ $profile['title'] }}</h3>
                    <p class="relative text-sm text-slate-500 mt-2 flex-1">{{ $profile['description'] }}</p>
                    <span class="relative inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 mt-5 group-hover:gap-2.5 transition-all">
                        Ver serviços
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Notícias em destaque --}}
    @if ($featuredNews->isNotEmpty())
        <section class="bg-slate-50 border-y border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <span class="text-sm font-semibold text-brand-700 uppercase tracking-wide">Acontece no CRN-9</span>
                        <h2 class="font-heading text-2xl sm:text-3xl font-bold text-slate-900 mt-2">Notícias em destaque</h2>
                    </div>
                    <a href="{{ route('news.index') }}" class="hidden sm:inline-flex items-center gap-1 text-brand-700 font-medium hover:gap-2 transition-all">
                        Ver todas
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    @foreach ($featuredNews as $index => $news)
                        @if ($index === 0)
                            <a href="{{ route('news.show', $news->slug) }}" class="group relative lg:col-span-2 lg:row-span-2 rounded-2xl overflow-hidden bg-brand-950 min-h-[320px] block">
                                @if ($news->cover_image)
                                    <img src="{{ Storage::url($news->cover_image) }}" alt="{{ $news->title }}" class="absolute inset-0 h-full w-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-500">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-950 via-brand-950/40 to-transparent"></div>
                                <div class="relative flex flex-col justify-end h-full min-h-[320px] p-7">
                                    @if ($news->category)
                                        <span class="inline-flex w-fit items-center rounded-full bg-brand-orange px-3 py-1 text-xs font-semibold text-white mb-4">
                                            {{ $news->category }}
                                        </span>
                                    @endif
                                    <h3 class="font-heading text-xl sm:text-2xl font-bold text-white leading-snug group-hover:text-brand-leaf transition-colors">
                                        {{ $news->title }}
                                    </h3>
                                    <p class="text-white/70 text-sm mt-3 line-clamp-2">{{ $news->excerpt }}</p>
                                    <p class="text-white/50 text-xs mt-4">{{ optional($news->published_at)->translatedFormat('d \d\e F \d\e Y') }}</p>
                                </div>
                            </a>
                        @else
                            <x-news-card :news="$news" />
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Agenda + últimas notícias --}}
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20 grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="flex items-end justify-between mb-8">
                    <h2 class="font-heading text-2xl font-bold text-slate-900">Últimas notícias</h2>
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
                    <h2 class="font-heading text-2xl font-bold text-slate-900">Agenda</h2>
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
        <section class="bg-slate-50 border-t border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($secondaryBanners as $banner)
                        <a href="{{ $banner->link_url ?? '#' }}" class="group relative rounded-2xl overflow-hidden h-56 block shadow-sm hover:shadow-xl transition-shadow">
                            <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-950/85 via-brand-950/20 to-transparent"></div>
                            <div class="absolute bottom-5 left-5 right-5">
                                <h3 class="font-heading text-white font-semibold text-lg">{{ $banner->title }}</h3>
                                <span class="inline-flex items-center gap-1.5 text-sm text-white/80 mt-1 group-hover:gap-2.5 transition-all">
                                    Saiba mais
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Faixa de contato --}}
    <section class="bg-brand-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="font-heading text-xl sm:text-2xl font-bold text-white">Precisa falar com o CRN-9?</h2>
                <p class="text-brand-200 mt-1">Nossa equipe está pronta para orientar profissionais e empresas.</p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="https://api.whatsapp.com/send/?phone=5531995917825&amp;text=Ol%C3%A1!%20Gostaria%20de%20falar%20com%20a%20equipe%20do%20CRN9." target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-brand-900 hover:bg-brand-50 transition">
                    Falar no WhatsApp
                </a>
                <a href="{{ route('pages.show', 'fale-conosco') }}" class="inline-flex items-center gap-2 rounded-lg border border-white/30 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10 transition">
                    Outros canais
                </a>
            </div>
        </div>
    </section>

@endsection
