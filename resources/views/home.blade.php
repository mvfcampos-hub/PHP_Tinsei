@extends('layouts.app')

@section('title', 'Início')
@section('description', 'Databit: mais de 30 anos em sistemas de gestão empresarial (ERP), DataCloud, Serviços de TI gerenciados (MSP) e produtos de informática. Conheça nosso ecossistema completo.')
@section('canonical', route('home'))

@section('content')

    {{-- Hero / banners de avisos gerais --}}
    <section class="relative bg-brand-950 bg-grid-pattern">
        @if ($heroBanners->isNotEmpty())
            <div x-data="{ active: 0, total: {{ $heroBanners->count() }} }"
                 x-init="setInterval(() => active = (active + 1) % total, 6000)"
                 class="relative h-[380px] sm:h-[440px] overflow-hidden">
                @foreach ($heroBanners as $index => $banner)
                    @if ($banner->variant === 'product_spotlight' && $banner->product)
                        @php
                            $product = $banner->product;
                            $isCloud = $product->category === 'cloud';
                            $spotlightHref = $banner->link_url ?: ($isCloud ? route('cloud.show') : route('products.show', $product->slug));
                        @endphp
                        <a href="{{ $spotlightHref }}"
                           x-show="active === {{ $index }}" x-transition:enter.duration.700ms
                           @class([
                               'absolute inset-0 block overflow-hidden bg-brand-950',
                               'bg-gradient-to-br from-accent-950 via-brand-950 to-brand-950' => $isCloud,
                               'bg-gradient-to-br from-brand-900 via-brand-950 to-brand-950' => ! $isCloud,
                           ])
                        >
                            <div class="absolute inset-0 bg-grid-pattern"></div>
                            <div @class([
                                'absolute -top-24 h-[420px] w-[420px] rounded-full blur-3xl opacity-30',
                                'right-0 bg-accent-500' => $isCloud,
                                '-right-10 bg-brand-500' => ! $isCloud,
                            ])></div>

                            <div class="relative h-full mx-auto max-w-7xl px-6 sm:px-10 flex items-center">
                                <div class="grid lg:grid-cols-2 gap-10 items-center w-full">
                                    <div>
                                        <span @class([
                                            'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold mb-4',
                                            'bg-accent-500/15 text-accent-300' => $isCloud,
                                            'bg-white/10 text-brand-200' => ! $isCloud,
                                        ])>
                                            {{ $product->categoryLabel() }}
                                        </span>
                                        <h2 class="text-3xl sm:text-5xl font-bold text-white leading-tight">{{ $product->tagline ?: $product->name }}</h2>
                                        <p class="text-brand-200 mt-4 max-w-lg text-base sm:text-lg">{{ $product->summary }}</p>

                                        @if (!empty($banner->highlights))
                                            <div class="flex flex-wrap gap-2 mt-6">
                                                @foreach ($banner->highlights as $highlight)
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 backdrop-blur px-3 py-1.5 text-xs font-medium text-white">
                                                        <svg class="h-3.5 w-3.5 {{ $isCloud ? 'text-accent-400' : 'text-accent-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                        {{ $highlight }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <span @class([
                                            'inline-flex items-center gap-2 rounded-lg px-6 py-3 text-sm font-semibold mt-8 transition',
                                            'bg-accent-500 text-white hover:bg-accent-600' => $isCloud,
                                            'bg-white text-brand-900 hover:bg-brand-50' => ! $isCloud,
                                        ])>
                                            Conhecer o {{ $product->name }}
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                        </span>
                                    </div>

                                    <div class="hidden lg:flex items-center justify-center relative h-72">
                                        <div @class([
                                            'flex h-56 w-56 items-center justify-center rounded-[2.5rem] border backdrop-blur-sm',
                                            'bg-accent-500/10 border-accent-400/30' => $isCloud,
                                            'bg-white/5 border-white/10' => ! $isCloud,
                                        ])>
                                            @if ($product->icon)
                                                <x-dynamic-component :component="$product->icon" @class([
                                                    'h-24 w-24',
                                                    'text-accent-300' => $isCloud,
                                                    'text-white' => ! $isCloud,
                                                ]) />
                                            @endif
                                        </div>

                                        @if (!empty($banner->highlights[0]))
                                            <div class="absolute -top-2 -left-6 rounded-xl bg-white shadow-xl px-4 py-2.5 text-xs font-semibold text-slate-800">
                                                {{ $banner->highlights[0] }}
                                            </div>
                                        @endif
                                        @if (!empty($banner->highlights[1]))
                                            <div class="absolute bottom-4 -right-4 rounded-xl bg-white shadow-xl px-4 py-2.5 text-xs font-semibold text-slate-800">
                                                {{ $banner->highlights[1] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ $banner->link_url ?? '#' }}"
                           x-show="active === {{ $index }}" x-transition:enter.duration.700ms
                           class="absolute inset-0 block">
                            @if ($banner->overlay_title)
                                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-full w-full object-cover opacity-60">
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-950 via-brand-950/60 to-brand-950/10"></div>
                                <div class="absolute inset-x-0 bottom-0 p-6 sm:p-10">
                                    <div class="mx-auto max-w-7xl">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/20 text-accent-300 px-3 py-1 text-xs font-semibold mb-3">
                                            Aviso Databit
                                        </span>
                                        <h2 class="text-2xl sm:text-4xl font-bold text-white max-w-2xl">{{ $banner->title }}</h2>
                                    </div>
                                </div>
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-white">
                                    <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-full w-full object-contain">
                                </div>
                            @endif
                        </a>
                    @endif
                @endforeach

                @if ($heroBanners->count() > 1)
                    <div class="absolute bottom-4 right-4 sm:right-10 z-20 flex gap-2">
                        @foreach ($heroBanners as $index => $banner)
                            <button @click="active = {{ $index }}" class="h-2.5 w-2.5 rounded-full bg-white" :class="active === {{ $index }} ? 'opacity-100' : 'opacity-40'"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="h-[380px] flex flex-col items-center justify-center text-center px-4">
                <h1 class="text-3xl sm:text-5xl font-bold text-white max-w-3xl">
                    Tecnologia que simplifica a gestão do seu negócio
                </h1>
                <p class="text-brand-200 mt-4 max-w-xl">
                    ERP, Cloud, mobilidade e atendimento ao cliente em um único ecossistema. Mais de 30 anos de experiência.
                </p>
            </div>
        @endif
    </section>

    {{-- Acesso rápido --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8 relative z-10">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'DataClassic ERP', 'href' => route('products.show', 'dataclassic'), 'icon' => 'heroicon-o-building-storefront'],
                ['label' => 'DataClient CRM', 'href' => route('products.show', 'dataclient-crm'), 'icon' => 'heroicon-o-users'],
                ['label' => 'DataSAC', 'href' => route('products.show', 'datasac'), 'icon' => 'heroicon-o-chat-bubble-left-right'],
                ['label' => 'DataCloud', 'href' => route('cloud.show'), 'icon' => 'heroicon-o-cloud'],
            ] as $quick)
                <a href="{{ $quick['href'] }}" class="flex flex-col items-center gap-2 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition p-5 text-center">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <x-dynamic-component :component="$quick['icon']" class="h-6 w-6" />
                    </span>
                    <span class="text-sm font-medium text-slate-700">{{ $quick['label'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Estatísticas --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
            @foreach ([
                ['value' => '+30', 'label' => 'anos de mercado'],
                ['value' => '+500', 'label' => 'clientes ativos'],
                ['value' => '+4.000', 'label' => 'dispositivos usando nossas soluções'],
                ['value' => '100%', 'label' => 'presente em todas as regiões do país'],
            ] as $stat)
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold text-brand-700">{{ $stat['value'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Presença Databit: mapa de clientes por estado/país --}}
    @include('partials.presence-map')

    {{-- Soluções de sistemas em destaque --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Soluções de sistemas integradas</h2>
                <p class="text-slate-500 mt-1">ERP, mobilidade, atendimento, fiscal, CRM e comunicação — tudo conectado ao DataClassic</p>
            </div>
            <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center gap-1 text-brand-700 font-medium hover:text-brand-800">
                Ver todos os produtos
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>

        @if ($ecosystemHub)
            <p class="hidden lg:block text-center text-sm text-slate-500 mb-8">
                Clique em qualquer módulo para conhecer os detalhes
            </p>
            <div class="mb-12">
                <x-ecosystem-diagram :hub="$ecosystemHub" :satellites="$ecosystemSatellites" />
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($featuredProducts as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="text-slate-500 col-span-full">Nenhum produto em destaque no momento.</p>
            @endforelse
        </div>
    </section>

    {{-- Databit MSP, DataCloud e Produtos de informática (tratados à parte das soluções de sistemas) --}}
    <section class="bg-white border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <span class="text-xs font-medium text-accent-600 uppercase tracking-wide">Além dos sistemas</span>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                <div class="flex items-center gap-5 rounded-2xl border border-slate-200 bg-slate-50 p-6">
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                    </span>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-900">Databit MSP</h3>
                        <p class="text-slate-600 text-sm mt-1">Mensalidade fixa para a administração completa do seu ambiente de TI, com SLA e suporte ilimitado.</p>
                        <a href="{{ route('msp.show') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-800 mt-3">
                            Conhecer o MSP
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-5 rounded-2xl border border-slate-200 bg-slate-50 p-6">
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" /></svg>
                    </span>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-900">DataCloud</h3>
                        <p class="text-slate-600 text-sm mt-1">Máquinas virtuais sob demanda, com Linux, Windows e SQL Server, escaláveis conforme o seu projeto.</p>
                        <a href="{{ route('cloud.show') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-800 mt-3">
                            Ver planos DataCloud
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-5 rounded-2xl border border-slate-200 bg-slate-50 p-6">
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                    </span>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-900">Produtos de informática</h3>
                        <p class="text-slate-600 text-sm mt-1">Apoiamos a escolha e a compra de notebooks, servidores, periféricos e mais.</p>
                        <a href="{{ route('hardware.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-800 mt-3">
                            Ver produtos
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Notícias + Agenda --}}
    <section class="bg-white border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Notícias e novidades</h2>
                        <p class="text-slate-500 mt-1 text-sm">Lançamentos da Databit e artigos de interesse sobre tecnologia e gestão</p>
                    </div>
                    <a href="{{ route('news.index') }}" class="text-brand-700 font-medium hover:text-brand-800 text-sm">Ver todas</a>
                </div>
                <div class="grid sm:grid-cols-2 gap-6">
                    @forelse ($featuredNews->isNotEmpty() ? $featuredNews : $latestNews as $news)
                        <x-news-card :news="$news" />
                    @empty
                        <p class="text-slate-500">Nenhuma novidade publicada no momento.</p>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between mb-8">
                    <h2 class="text-2xl font-bold text-slate-900">Agenda</h2>
                    <a href="{{ route('events.index') }}" class="text-brand-700 font-medium hover:text-brand-800 text-sm">Ver tudo</a>
                </div>
                <p class="text-slate-500 mt-1 text-sm mb-4 -mt-4">Eventos, webinars e lançamentos de produtos</p>
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

    {{-- Depoimentos --}}
    @if ($testimonials->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="mb-8 text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Quem confia na Databit</h2>
                <p class="text-slate-500 mt-1">Depoimentos de quem já transformou a gestão do negócio com a gente</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($testimonials as $testimonial)
                    <x-testimonial-card :testimonial="$testimonial" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Clientes e parceiros --}}
    @if ($clients->isNotEmpty() || $partners->isNotEmpty())
        <section class="bg-white border-t border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 space-y-12">
                @if ($clients->isNotEmpty())
                    <x-logo-marquee :items="$clients" label="Empresas que confiam na Databit" />
                @endif

                @if ($partners->isNotEmpty())
                    <x-logo-marquee :items="$partners" label="Parceiros de tecnologia" :reverse="true" />
                @endif
            </div>
        </section>
    @endif

    {{-- Banners secundários / campanhas --}}
    @if ($secondaryBanners->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid sm:grid-cols-2 gap-6">
                @foreach ($secondaryBanners as $banner)
                    <a href="{{ $banner->link_url ?? '#' }}" class="group relative rounded-2xl overflow-hidden h-52 block border border-slate-200">
                        @if ($banner->overlay_title)
                            <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-950/80 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <h3 class="text-white font-semibold text-lg">{{ $banner->title }}</h3>
                            </div>
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-white">
                                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-full w-full object-contain group-hover:scale-105 transition duration-500">
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA final --}}
    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Pronto para modernizar a gestão da sua empresa?</h2>
                <p class="text-brand-100 mt-2">Fale com um especialista Databit e descubra a solução ideal para o seu negócio.</p>
            </div>
            <a href="https://wa.me/553134168225" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com um especialista
            </a>
        </div>
    </section>

@endsection
