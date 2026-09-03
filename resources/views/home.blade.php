@extends('layouts.app')

@section('title', 'Início')

@section('content')

    {{-- Hero / banners de avisos gerais --}}
    <section class="relative bg-brand-950 bg-grid-pattern">
        @if ($heroBanners->isNotEmpty())
            <div x-data="{ active: 0, total: {{ $heroBanners->count() }} }"
                 x-init="setInterval(() => active = (active + 1) % total, 6000)"
                 class="relative h-[420px] sm:h-[500px] overflow-hidden">
                @foreach ($heroBanners as $index => $banner)
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
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'Sistemas', 'route' => 'products.index', 'path' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25-2.25m-2.25 2.25V6.75m-8.25.75h16.5'],
                ['label' => 'DataCloud', 'route' => 'cloud.show', 'path' => 'M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z'],
                ['label' => 'Novidades', 'route' => 'news.index', 'path' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-1.519-2.121L12 13.5m1.481 1.629L15 13.5m-1.519 1.629L12 17.25M8.25 21h7.5a2.25 2.25 0 002.25-2.25V9.75L14.25 3H8.25a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 008.25 21z'],
                ['label' => 'Agenda', 'route' => 'events.index', 'path' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
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

    {{-- Estatísticas --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
            @foreach ([
                ['value' => '+30', 'label' => 'anos de mercado'],
                ['value' => '+12', 'label' => 'sistemas integrados'],
                ['value' => '99,9%', 'label' => 'uptime no DataCloud'],
                ['value' => '100%', 'label' => 'suporte em português'],
            ] as $stat)
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold text-brand-700">{{ $stat['value'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Destaque DataCloud --}}
    @if ($cloudProduct || $cloudPlans->isNotEmpty())
        <section class="bg-brand-950 bg-grid-pattern text-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                            Cloud & Infraestrutura
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                            {{ $cloudProduct->name ?? 'DataCloud' }} — Máquinas virtuais sob demanda
                        </h2>
                        <p class="text-brand-200 leading-relaxed mb-6">
                            {{ $cloudProduct->summary ?? 'VMs com Linux, Windows e SQL Server, dimensionadas de acordo com a necessidade do seu projeto. Escale vCPU, RAM e disco sem migrações complexas, com previsibilidade de custos em reais e suporte especializado.' }}
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('cloud.show') }}" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-5 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                                Ver planos DataCloud
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                            <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Quero falar sobre o DataCloud.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg border border-white/20 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                                Falar com um especialista
                            </a>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach ([
                            ['label' => 'Escalabilidade sob demanda', 'desc' => 'Aumente vCPU, RAM e disco conforme o crescimento do projeto.'],
                            ['label' => 'Linux, Windows e SQL Server', 'desc' => 'Ambientes prontos para produção com banco de dados incluso.'],
                            ['label' => 'Segurança dedicada', 'desc' => 'Firewall e políticas de segurança isoladas por ambiente.'],
                            ['label' => 'Suporte especializado', 'desc' => 'Atendimento consultivo em português, 30+ anos de experiência.'],
                        ] as $feature)
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                                <svg class="h-6 w-6 text-accent-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                                <p class="font-semibold text-sm">{{ $feature['label'] }}</p>
                                <p class="text-xs text-brand-300 mt-1">{{ $feature['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($cloudPlans->isNotEmpty())
                    <div class="grid sm:grid-cols-3 gap-6 mt-16">
                        @foreach ($cloudPlans as $plan)
                            <x-cloud-plan-card :plan="$plan" />
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif

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

    {{-- Serviços de TI e Produtos de informática (tratados à parte das soluções de sistemas e do DataCloud) --}}
    <section class="bg-white border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <span class="text-xs font-medium text-accent-600 uppercase tracking-wide">Além dos sistemas e do DataCloud</span>
            <div class="grid sm:grid-cols-2 gap-6 mt-4">
                <div class="flex items-center gap-5 rounded-2xl border border-slate-200 bg-slate-50 p-6">
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" /></svg>
                    </span>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-900">Serviços de TI</h3>
                        <p class="text-slate-600 text-sm mt-1">Do atendimento avulso ao outsourcing completo, uma empresa parceira para a sua operação.</p>
                        <a href="{{ route('it-services.show') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-800 mt-3">
                            Conhecer os serviços
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

    {{-- Novidades + Agenda --}}
    <section class="bg-white border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Novidades e lançamentos</h2>
                        <p class="text-slate-500 mt-1 text-sm">Fique por dentro dos lançamentos de produtos da Databit</p>
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
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
                @if ($clients->isNotEmpty())
                    <h2 class="text-center text-sm font-semibold text-slate-400 uppercase tracking-wide mb-6">
                        Empresas que confiam na Databit
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-12">
                        @foreach ($clients as $client)
                            <x-client-logo :client="$client" />
                        @endforeach
                    </div>
                @endif

                @if ($partners->isNotEmpty())
                    <h2 class="text-center text-sm font-semibold text-slate-400 uppercase tracking-wide mb-6">
                        Parceiros de tecnologia
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                        @foreach ($partners as $partner)
                            <x-client-logo :client="$partner" />
                        @endforeach
                    </div>
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
            <a href="https://wa.me/5531997278589" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com um especialista
            </a>
        </div>
    </section>

@endsection
