@extends('layouts.app')

@section('description', 'Tinsei: maior importadora e distribuidora de equipamentos A3 a laser do Brasil. Equipamentos novos e recondicionados, suprimentos e peças para revendas de impressão em todo o país, com sustentabilidade no DNA.')

@php
    $storeUrl = setting('store_url');
    $years = now()->year - (int) setting('founded_year', 2011);
    $ewaste = (int) preg_replace('/\D/', '', (string) setting('ewaste_kg'));
    $items = (int) preg_replace('/\D/', '', (string) setting('portfolio_items'));
    // Prévia da linha do tempo: os dois primeiros marcos e os três mais recentes.
    $timelinePreview = $timeline->count() > 5 ? $timeline->take(2)->concat($timeline->slice(-3))->values() : $timeline;
@endphp

@section('content')

{{-- ============ HERO ============ --}}
@if ($heroBanners->isNotEmpty())
    <section x-data="{ i: 0, n: {{ $heroBanners->count() }} }" x-init="n > 1 && setInterval(() => i = (i + 1) % n, 7000)" class="relative overflow-hidden bg-brand-950">
        @foreach ($heroBanners as $banner)
            <div x-show="i === {{ $loop->index }}" x-transition.opacity.duration.700ms @if (! $loop->first) x-cloak @endif class="relative min-h-[560px]">
                @if ($banner->imageUrl())
                    <img src="{{ $banner->imageUrl() }}" alt="{{ $banner->overlay_title ? '' : $banner->title }}" class="absolute inset-0 h-full w-full object-cover">
                @endif
                @if ($banner->overlay_title)
                    <div class="absolute inset-0 bg-gradient-to-r from-brand-950 via-brand-950/80 to-transparent"></div>
                    <div class="container-site relative flex min-h-[560px] flex-col justify-center py-20">
                        @if ($banner->eyebrow)<span class="eyebrow eyebrow-light">{{ $banner->eyebrow }}</span>@endif
                        <h1 class="mt-4 max-w-2xl text-4xl font-bold text-white sm:text-5xl lg:text-6xl">{{ $banner->title }}</h1>
                        @if ($banner->subtitle)<p class="mt-5 max-w-xl text-lg text-brand-100">{{ $banner->subtitle }}</p>@endif
                        @if ($banner->link_url)
                            <div class="mt-8"><a href="{{ $banner->link_url }}" class="btn-gold !px-7 !py-4 text-base">{{ $banner->link_label ?: 'Saiba mais' }} <x-ico name="arrow-right" class="h-4 w-4" /></a></div>
                        @endif
                    </div>
                @elseif ($banner->link_url)
                    <a href="{{ $banner->link_url }}" class="absolute inset-0" aria-label="{{ $banner->title }}"></a>
                @endif
            </div>
        @endforeach
        @if ($heroBanners->count() > 1)
            <div class="absolute bottom-6 left-1/2 flex -translate-x-1/2 gap-2">
                @foreach ($heroBanners as $banner)
                    <button type="button" @click="i = {{ $loop->index }}" :class="i === {{ $loop->index }} ? 'w-8 bg-gold-400' : 'w-2.5 bg-white/40'" class="h-2.5 rounded-full transition-all" aria-label="Ir para o destaque {{ $loop->iteration }}"></button>
                @endforeach
            </div>
        @endif
    </section>
@else
    <section class="relative overflow-hidden bg-brand-950">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
        <div class="absolute -left-40 top-0 h-[520px] w-[520px] rounded-full bg-brand-600/30 blur-3xl"></div>
        <div class="absolute -right-24 bottom-0 h-[420px] w-[420px] rounded-full bg-gold-500/15 blur-3xl"></div>

        <div class="container-site relative grid items-center gap-14 py-16 sm:py-20 lg:grid-cols-12 lg:py-28">
            <div class="lg:col-span-7">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3.5 py-1.5 text-xs font-semibold text-brand-100">
                    <img src="{{ asset('images/brand/tinsei-mark.png') }}" alt="" class="h-3.5"> Belo Horizonte para todo o Brasil · desde {{ setting('founded_year') }}
                </span>
                <h1 class="mt-6 text-4xl font-extrabold leading-[1.08] text-white sm:text-5xl lg:text-[3.6rem]">
                    Tecnologia de impressão de ponta, com <span class="bg-gradient-to-r from-gold-300 to-gold-500 bg-clip-text text-transparent">segurança</span> em cada entrega.
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-brand-100/90">
                    A maior importadora e distribuidora de equipamentos A3 a laser do Brasil. Equipamentos novos e recondicionados, suprimentos e peças para revendas que querem crescer com qualidade, preço competitivo e sustentabilidade.
                </p>
                <div class="mt-9 flex flex-wrap gap-3">
                    <a href="{{ $storeUrl }}" target="_blank" rel="noopener" class="btn-gold !px-7 !py-4 text-base" onclick="window.trackEvent && window.trackEvent('store_click', { location: 'hero' })">
                        <x-ico name="grid" class="h-5 w-5" /> Ver portfólio de produtos
                    </a>
                    <a href="{{ route('about') }}" class="btn-ghost-light !px-7 !py-4 text-base">Conheça a Tinsei</a>
                </div>
                <dl class="mt-12 grid max-w-xl grid-cols-3 gap-6 border-t border-white/10 pt-8">
                    <div>
                        <dt class="text-xs text-brand-300">Clientes ativos</dt>
                        <dd class="mt-1 font-display text-3xl font-bold text-white" x-data="counter({{ $map['total'] }})" x-text="formatted">{{ br_number($map['total']) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-brand-300">Itens no portfólio</dt>
                        <dd class="mt-1 font-display text-3xl font-bold text-white">{{ setting('portfolio_items') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-brand-300">Estados atendidos</dt>
                        <dd class="mt-1 font-display text-3xl font-bold text-white">{{ $map['states_served'] }}</dd>
                    </div>
                </dl>
            </div>

            <div class="relative lg:col-span-5">
                <div class="relative overflow-hidden rounded-[2rem] border border-white/10 shadow-2xl shadow-black/40">
                    <img src="{{ asset('images/site/sede-tinsei.jpg') }}" alt="Sede da Tinsei em Belo Horizonte" class="aspect-[4/5] w-full object-cover sm:aspect-[5/4] lg:aspect-[4/5]">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-950/80 via-transparent"></div>
                    <p class="absolute bottom-5 left-5 right-5 text-sm text-white/90"><strong class="text-white">Nossa sede</strong> · Olhos D'Água, Belo Horizonte/MG</p>
                </div>
                <div class="animate-float absolute -left-6 top-10 hidden max-w-[230px] rounded-2xl border border-white/10 bg-white/95 p-4 shadow-xl backdrop-blur sm:block">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-800 text-gold-300"><x-ico name="badge" class="h-5 w-5" /></span>
                        <p class="text-xs leading-snug text-slate-600"><strong class="block text-sm text-brand-900">Recondicionamento autorizado Xerox</strong>no Brasil e no México</p>
                    </div>
                </div>
                <div class="animate-float absolute -right-4 bottom-20 hidden rounded-2xl border border-white/10 bg-leaf-700/95 p-4 text-white shadow-xl backdrop-blur sm:block" style="animation-delay: -3s">
                    <p class="flex items-center gap-2 text-xs font-semibold text-leaf-100"><x-ico name="leaf" class="h-4 w-4" /> Lixo eletrônico recuperado</p>
                    <p class="mt-1 font-display text-2xl font-bold">+{{ setting('ewaste_kg') }} kg</p>
                </div>
            </div>
        </div>
    </section>
@endif

{{-- ============ PILARES ============ --}}
<section class="relative border-b border-slate-100 bg-white">
    <div class="container-site grid divide-y divide-slate-100 sm:grid-cols-2 sm:divide-y-0 lg:grid-cols-4 lg:divide-x">
        @foreach ([
            ['shield', 'Segurança', 'Procedência, testes e garantia em cada equipamento e suprimento.'],
            ['badge', 'Qualidade', 'Padrões de fábrica no recondicionamento e na montagem de suprimentos.'],
            ['tag', 'Preço competitivo', 'Importação direta e escala para a sua revenda ganhar margem.'],
            ['leaf', 'Sustentabilidade', 'Economia circular: cada máquina recondicionada é menos lixo eletrônico.'],
        ] as [$icon, $title, $text])
            <div class="reveal flex gap-4 px-2 py-7 sm:px-6">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700"><x-ico :name="$icon" class="h-5 w-5" /></span>
                <div>
                    <p class="font-display font-semibold text-brand-900">{{ $title }}</p>
                    <p class="mt-1 text-sm leading-relaxed text-slate-500">{{ $text }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ============ ATUAÇÃO ============ --}}
<section id="atuacao" class="bg-slate-50 py-20 sm:py-24">
    <div class="container-site">
        <x-section-heading eyebrow="Atuação" title="Três frentes, um só compromisso: <span class='text-brand-600'>impressão de alto nível</span>." subtitle="Da importação ao pós-venda, a Tinsei domina toda a cadeia — e entrega ao revendedor equipamento pronto para trabalhar." />

        <div class="mt-14 grid gap-6 lg:grid-cols-3">
            @foreach ([
                ['atuacao-1.png', 'Recondicionamento e distribuição', 'Equipamentos de impressão de médio e grande porte, recondicionados e distribuídos com padrão de alta qualidade. No Brasil, a Tinsei é a maior importadora e distribuidora de equipamentos A3 a laser — à frente dos fabricantes tradicionais do segmento.', 'printer'],
                ['atuacao-2.png', 'Indústria montadora de suprimentos', 'Desenvolvimento de cartuchos, suprimentos e peças de alta qualidade para ambientes exigentes: exames médicos de imagem, materiais publicitários e indústria gráfica.', 'droplet'],
                ['atuacao-3.png', 'Recondicionamento autorizado Xerox', 'Apoiada em padrões ESG, a Xerox escolheu a Tinsei como indústria de recondicionamento dos seus equipamentos no Brasil e no México.', 'badge'],
            ] as [$img, $title, $text, $icon])
                <article class="reveal group card overflow-hidden transition hover:-translate-y-1 hover:shadow-soft" style="transition-delay: {{ $loop->index * 80 }}ms">
                    <div class="relative flex h-56 items-center justify-center overflow-hidden bg-white">
                        <img src="{{ asset('images/site/'.$img) }}" alt="" loading="lazy" class="relative max-h-48 w-auto object-contain mix-blend-multiply transition duration-500 group-hover:scale-105">
                        <span class="absolute left-4 top-4 flex h-9 w-9 items-center justify-center rounded-lg bg-brand-800 text-gold-300"><x-ico :name="$icon" class="h-5 w-5" /></span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-brand-900">{{ $title }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">{{ $text }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ PORTFÓLIO ============ --}}
<section id="portfolio" class="bg-white py-20 sm:py-24">
    <div class="container-site">
        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
            <x-section-heading eyebrow="Portfólio" title="{{ setting('portfolio_items') }} itens para manter a sua operação imprimindo." subtitle="Equipamentos novos e recondicionados, suprimentos e peças das principais marcas — com busca por código, referência, fabricante e modelo." />
            <a href="{{ $storeUrl }}" target="_blank" rel="noopener" class="btn-primary shrink-0">Abrir a loja <x-ico name="arrow-up-right" class="h-4 w-4" /></a>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($categories as $category)
                <a href="{{ $category->storeUrl() }}" target="_blank" rel="noopener" class="reveal group relative flex flex-col overflow-hidden rounded-2xl bg-brand-900 p-6 text-white transition hover:-translate-y-1 hover:shadow-soft" style="transition-delay: {{ $loop->index * 70 }}ms" onclick="window.trackEvent && window.trackEvent('store_click', { location: 'home_category', category: @js($category->slug) })">
                    <div class="absolute inset-0 bg-grid-pattern bg-grid opacity-50"></div>
                    <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-gold-400/10 transition group-hover:bg-gold-400/20"></div>
                    <span class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-gold-400 text-brand-950"><x-ico :name="$category->icon ?: 'box'" class="h-6 w-6" /></span>
                    <h3 class="relative mt-6 text-xl font-bold">{{ $category->name }}</h3>
                    <p class="relative mt-2 flex-1 text-sm leading-relaxed text-brand-100/80">{{ $category->tagline }}</p>
                    <span class="relative mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-gold-300 group-hover:gap-2.5 transition-all">
                        {{ $category->item_count_label ?: 'Ver na loja' }} <x-ico name="arrow-right" class="h-4 w-4" />
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Chamada de destaque para a loja, inspirada na própria loja B2B --}}
        <div class="reveal relative mt-10 overflow-hidden rounded-3xl bg-gradient-to-br from-gold-800 via-gold-700 to-gold-600 p-8 sm:p-10">
            <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-gold-400/30 blur-2xl"></div>
            <div class="relative grid items-center gap-8 lg:grid-cols-2">
                <div class="min-w-0">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white"><x-ico name="sparkles" class="h-3.5 w-3.5" /> E-Commerce Tinsei ES®</span>
                    <h3 class="mt-4 text-2xl font-bold text-white sm:text-3xl">Encontre o produto certo para o seu equipamento.</h3>
                    <p class="mt-3 text-gold-50/90">Busque por código, referência ou nome — ou filtre por fabricante, modelo, categoria e subcategoria. Revendas cadastradas veem preços e compram on-line.</p>
                    <form x-data="{ q: '' }" action="{{ rtrim($storeUrl, '/') }}/filter/" method="GET" target="_blank" class="mt-6 flex max-w-lg overflow-hidden rounded-2xl bg-white p-1.5 shadow-xl">
                        <label for="store-search" class="sr-only">Buscar na loja</label>
                        <input type="hidden" name="type" value="0">
                        <input type="hidden" name="name" :value="q">
                        <input id="store-search" x-model="q" required type="search" name="term" placeholder="Ex.: toner Altalink C8030, 006R01702..." class="min-w-0 flex-1 border-0 bg-transparent px-3 text-sm text-slate-700 focus:outline-none focus:ring-0">
                        <button type="submit" class="btn-gold !rounded-xl !py-2.5"><x-ico name="search" class="h-4 w-4" /> Pesquisar</button>
                    </form>
                    <p class="mt-2 text-[11px] text-gold-100/70">A busca abre na loja em uma nova aba.</p>
                </div>
                <div class="grid min-w-0 grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach ([['07011', 'Toner Ricoh MP C2003'], ['04255', 'Toner Xerox AltaLink C8030'], ['03767', 'Toner Konica Minolta C1100'], ['05576', 'Toner Canon iR ADV 6055'], ['21850', 'Toner Samsung M4070']] as [$ref, $label])
                        <a href="{{ rtrim($storeUrl, '/') }}/produto/?produto={{ $ref }}" target="_blank" rel="noopener" @class(['group rounded-2xl bg-white p-2 shadow-lg transition hover:-translate-y-1', 'hidden sm:block' => $loop->index >= 3])>
                            <div class="aspect-square overflow-hidden rounded-xl bg-slate-50">
                                <img src="{{ asset('images/site/produto-'.$ref.'.jpg') }}" alt="{{ $label }}" loading="lazy" class="h-full w-full object-contain transition group-hover:scale-105">
                            </div>
                            <p class="mt-2 px-1 text-[11px] font-semibold leading-tight text-brand-900">{{ $label }}</p>
                        </a>
                    @endforeach
                    <a href="{{ $storeUrl }}" target="_blank" rel="noopener" class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/40 p-2 text-center text-white transition hover:bg-white/10">
                        <span class="font-display text-2xl font-bold">{{ setting('portfolio_items') }}</span>
                        <span class="text-[11px]">itens na loja</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ NÚMEROS ============ --}}
<section class="bg-brand-800">
    <div class="container-site grid grid-cols-2 gap-px overflow-hidden lg:grid-cols-5">
        @foreach ([
            [$map['total'], '', 'clientes ativos'],
            [$items, '+', 'itens no portfólio'],
            [$map['states_served'], '', 'estados + DF com clientes'],
            [$ewaste, ' kg', 'de lixo eletrônico recuperado'],
            [$years, ' anos', 'de história'],
        ] as [$value, $suffix, $label])
            <div @class(['px-4 py-9 text-center', 'col-span-2 lg:col-span-1' => $loop->last])>
                <p class="font-display text-2xl font-bold text-white sm:text-4xl"><span x-data="counter({{ (int) $value }})" x-text="formatted">{{ br_number($value) }}</span><span class="text-gold-400">{{ $suffix }}</span></p>
                <p class="mt-1 text-sm text-brand-200">{{ $label }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ============ MAPA DE CLIENTES ============ --}}
<section id="onde-estamos" class="relative overflow-hidden bg-brand-950 py-20 sm:py-24">
    <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    <div class="container-site relative">
        <x-section-heading :dark="true" align="center" eyebrow="Presença nacional" title="De Belo Horizonte para todas as regiões do Brasil." subtitle="{{ br_number($map['total']) }} clientes ativos em {{ $map['states_served'] }} unidades da federação — e também no exterior." />
        <x-brazil-map :map="$map" class="mt-14" />
    </div>
</section>

{{-- ============ SUSTENTABILIDADE ============ --}}
<section class="relative overflow-hidden bg-white py-20 sm:py-24">
    <div class="container-site grid items-center gap-14 lg:grid-cols-2">
        <div class="reveal relative order-2 lg:order-1">
            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-3xl bg-leaf-700 p-7 text-white">
                    <x-ico name="recycle" class="h-8 w-8 text-leaf-300" />
                    <p class="mt-6 font-display text-3xl font-bold">+{{ setting('ewaste_kg') }}</p>
                    <p class="mt-1 text-sm text-leaf-100">quilos de lixo eletrônico recuperados</p>
                </div>
                <div class="rounded-3xl bg-brand-50 p-7">
                    <x-ico name="globe" class="h-8 w-8 text-brand-600" />
                    <p class="mt-6 font-display text-3xl font-bold text-brand-900">BR + MX</p>
                    <p class="mt-1 text-sm text-slate-500">recondicionamento autorizado Xerox</p>
                </div>
                <div class="col-span-2 flex items-center gap-5 rounded-3xl border border-slate-200 p-6">
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gold-100 text-gold-700"><x-ico name="shield" class="h-7 w-7" /></span>
                    <p class="text-sm leading-relaxed text-slate-600"><strong class="text-brand-900">ESG na prática:</strong> estender a vida útil de um equipamento de alto padrão economiza matéria-prima, energia e reduz o descarte — sem abrir mão de desempenho.</p>
                </div>
            </div>
        </div>
        <div class="order-1 lg:order-2">
            <x-section-heading eyebrow="Sustentabilidade" title="Economia circular é o nosso jeito de fazer negócio." subtitle="A Tinsei nasceu recondicionando. Cada equipamento que volta ao mercado com qualidade de fábrica é um passo a mais por um futuro sustentável — para o planeta e para a rentabilidade da sua revenda." />
            <a href="{{ route('sustainability') }}" class="btn-outline mt-8">Conheça nosso compromisso <x-ico name="arrow-right" class="h-4 w-4" /></a>
        </div>
    </div>
</section>

{{-- ============ HISTÓRIA E SÓCIOS ============ --}}
@if ($timeline->isNotEmpty() || $partners->isNotEmpty())
    <section class="bg-slate-50 py-20 sm:py-24">
        <div class="container-site">
            <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
                <x-section-heading eyebrow="Nossa história" title="Uma empresa jovem, com visão de futuro e os pés no chão." subtitle="Fundada em Belo Horizonte, a Tinsei cresceu com sócios engajados no dia a dia e preparados para um mercado em transformação." />
                <a href="{{ route('about') }}#historia" class="btn-outline shrink-0">Ver a história completa <x-ico name="arrow-right" class="h-4 w-4" /></a>
            </div>

            @if ($timeline->isNotEmpty())
                <div class="relative mt-14">
                    <div class="absolute left-0 right-0 top-[27px] hidden h-px bg-gradient-to-r from-transparent via-brand-200 to-transparent md:block"></div>
                    <ol @class(['grid gap-8', 'md:grid-cols-5' => $timelinePreview->count() >= 5, 'md:grid-cols-4' => $timelinePreview->count() === 4, 'md:grid-cols-3' => $timelinePreview->count() <= 3])>
                        @foreach ($timelinePreview as $item)
                            <li class="reveal relative" style="transition-delay: {{ $loop->index * 80 }}ms">
                                <span class="relative z-10 inline-flex h-14 min-w-[3.5rem] items-center justify-center rounded-2xl bg-brand-800 px-3 font-display text-sm font-bold text-gold-300 shadow-lg">{{ $item->year_label }}</span>
                                <h3 class="mt-5 font-semibold text-brand-900">{{ $item->title }}</h3>
                                <p class="mt-2 line-clamp-4 text-sm leading-relaxed text-slate-500">{{ $item->description }}</p>
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endif

            @if ($partners->isNotEmpty())
                <div id="socios" class="mt-16 grid gap-6 lg:grid-cols-2">
                    @foreach ($partners as $partner)
                        <div class="reveal"><x-partner-card :partner="$partner" :compact="true" /></div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif

{{-- ============ VÍDEOS ============ --}}
<section class="bg-white py-20 sm:py-24">
    <div class="container-site grid items-center gap-12 lg:grid-cols-2">
        <div>
            <x-section-heading eyebrow="Por dentro da Tinsei" title="Veja de perto quem cuida do seu equipamento." subtitle="Estrutura, processos e pessoas: conheça a operação que faz da Tinsei referência em equipamentos de impressão no Brasil." />
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ setting('youtube_url') }}" target="_blank" rel="noopener" class="btn-primary">Canal no YouTube <x-ico name="arrow-up-right" class="h-4 w-4" /></a>
                <a href="{{ setting('instagram_url') }}" target="_blank" rel="noopener" class="btn-outline">@tinseioficial</a>
            </div>
        </div>
        <div class="grid gap-4">
            <x-youtube :url="setting('institutional_video_url')" title="Conheça a Tinsei — líder em recondicionamento de equipamentos de impressão" />
        </div>
    </div>
</section>

{{-- ============ DEPOIMENTOS ============ --}}
<section class="bg-gradient-to-b from-brand-50/60 to-white py-20 sm:py-24">
    <div class="container-site">
        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
            <x-section-heading eyebrow="Depoimentos" title="Quem revende Tinsei, recomenda." />
            <a href="{{ route('testimonials') }}" class="btn-outline shrink-0">Todos os depoimentos <x-ico name="arrow-right" class="h-4 w-4" /></a>
        </div>
        @if ($testimonials->isNotEmpty())
            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($testimonials as $testimonial)
                    <div class="reveal"><x-testimonial-card :testimonial="$testimonial" /></div>
                @endforeach
            </div>
        @else
            <div class="mt-12 flex flex-col items-center justify-between gap-6 rounded-3xl border border-dashed border-brand-200 bg-white p-8 text-center md:flex-row md:text-left">
                <div class="flex items-center gap-5">
                    <span class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gold-100 text-gold-700 md:flex"><x-ico name="quote" class="h-7 w-7" /></span>
                    <div>
                        <p class="font-display text-lg font-semibold text-brand-900">Sua revenda cresce com a Tinsei?</p>
                        <p class="text-sm text-slate-500">Conte sua experiência — os depoimentos de clientes aparecem aqui.</p>
                    </div>
                </div>
                <a href="{{ route('contact.index', ['assunto' => 'contato']) }}" class="btn-primary shrink-0">Enviar meu depoimento</a>
            </div>
        @endif
    </div>
</section>

{{-- ============ NOTÍCIAS E AGENDA ============ --}}
<section class="bg-white py-20 sm:py-24">
    <div class="container-site grid gap-12 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="flex items-end justify-between gap-4">
                <x-section-heading eyebrow="Notícias" title="Novidades da Tinsei" />
                <a href="{{ route('news.index') }}" class="hidden text-sm font-semibold text-brand-700 hover:underline sm:inline">Ver todas →</a>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2">
                @forelse ($latestNews->take(2) as $item)
                    <x-news-card :news="$item" />
                @empty
                    <p class="text-slate-500">Em breve, novidades por aqui.</p>
                @endforelse
            </div>
        </div>
        <div>
            <x-section-heading eyebrow="Agenda" title="Próximos eventos" />
            <div class="mt-10 space-y-4">
                @forelse ($upcomingEvents as $event)
                    <x-event-card :event="$event" :compact="true" />
                @empty
                    <div class="card p-6">
                        <x-ico name="calendar" class="h-8 w-8 text-brand-300" />
                        <p class="mt-3 font-semibold text-brand-900">Novas datas em breve</p>
                        <p class="mt-1 text-sm text-slate-500">Feiras, treinamentos para revendas e lançamentos são publicados aqui e no nosso Instagram.</p>
                        <a href="{{ setting('instagram_url') }}" target="_blank" rel="noopener" class="mt-4 inline-flex text-sm font-semibold text-brand-700 hover:underline">Seguir @tinseioficial ↗</a>
                    </div>
                @endforelse
                <a href="{{ route('events.index') }}" class="inline-flex text-sm font-semibold text-brand-700 hover:underline">Ver a agenda completa →</a>
            </div>
        </div>
    </div>
</section>

{{-- ============ MARCAS ============ --}}
@if ($brands->isNotEmpty())
    <section class="border-y border-slate-100 bg-slate-50 py-10">
        <div class="container-site">
            <p class="text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Equipamentos, suprimentos e peças para as principais marcas</p>
            <div class="relative mt-6 overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)]">
                <div class="animate-marquee flex w-max gap-14">
                    @foreach ([1, 2] as $pass)
                        @foreach ($brands as $brand)
                            <span class="flex h-12 items-center" @if ($pass === 2) aria-hidden="true" @endif>
                                @if ($brand->logo)
                                    <img src="{{ media_url($brand->logo) }}" alt="{{ $brand->name }}" class="h-8 w-auto opacity-60 grayscale">
                                @else
                                    <span class="font-display text-xl font-bold uppercase tracking-wider text-slate-400">{{ $brand->name }}</span>
                                @endif
                            </span>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

{{-- ============ CTA REVENDA ============ --}}
<section class="bg-white py-20">
    <div class="container-site">
        <div class="relative overflow-hidden rounded-[2rem] bg-brand-900 px-8 py-14 sm:px-14">
            <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
            <div class="absolute -right-20 -top-20 h-80 w-80 rounded-full bg-gold-400/20 blur-3xl"></div>
            <img src="{{ asset('images/brand/tinsei-mark.png') }}" alt="" class="absolute bottom-6 right-10 hidden h-40 opacity-10 lg:block">
            <div class="relative max-w-2xl">
                <span class="eyebrow eyebrow-light">Para revendas e locadoras</span>
                <h2 class="mt-3 text-3xl font-bold text-white sm:text-4xl">Acelere seu negócio de maneira econômica e sustentável.</h2>
                <p class="mt-4 text-lg text-brand-100/80">Cadastre sua empresa, acesse preços exclusivos e conte com uma equipe que entende de impressão.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ setting('store_reseller_url') }}" target="_blank" rel="noopener" class="btn-gold !px-7 !py-4">Cadastrar minha revenda</a>
                    <a href="{{ whatsapp_url('Olá! Quero ser uma revenda Tinsei.', setting('whatsapp_sales')) }}" target="_blank" rel="noopener" class="btn-ghost-light !px-7 !py-4">Falar no WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
