@extends('layouts.app')

@section('title', 'Quem somos')
@section('description', 'Conheça a Tinsei: história, sócios e valores da maior importadora e distribuidora de equipamentos A3 a laser do Brasil, com sede em Belo Horizonte.')

@section('content')
<x-page-hero eyebrow="Quem somos" title="Sobre a Tinsei" :image="asset('images/site/sede-tinsei.jpg')"
    subtitle="Empresa brasileira especializada na importação, no recondicionamento e na distribuição de equipamentos de impressão, suprimentos e peças — com qualidade, inovação e um futuro mais sustentável como compromisso." />

{{-- Apresentação --}}
<section class="bg-white py-20 sm:py-24">
    <div class="container-site grid items-center gap-14 lg:grid-cols-2">
        <div>
            <x-section-heading eyebrow="Nossa essência" title="Moderna, tecnológica e com segurança no DNA." />
            <div class="prose prose-slate mt-6 max-w-none prose-p:leading-relaxed">
                <p>Fundada em {{ setting('founded_year') }}, em Belo Horizonte, a Tinsei se tornou a <strong>maior importadora e distribuidora de equipamentos A3 a laser do Brasil</strong>, à frente dos fabricantes tradicionais do segmento. Da sede em Minas Gerais, atendemos revendas, locadoras e empresas de outsourcing de impressão em todas as regiões do país.</p>
                <p>Atuamos em três frentes complementares: o <strong>recondicionamento e a distribuição</strong> de equipamentos de médio e grande porte; uma <strong>indústria montadora</strong> de cartuchos, suprimentos e peças para aplicações exigentes, como exames médicos de imagem, materiais publicitários e indústria gráfica; e o <strong>recondicionamento autorizado Xerox</strong> no Brasil e no México, apoiado em padrões ESG.</p>
                <p>Somos uma empresa séria, conduzida por sócios jovens e engajados no dia a dia, com uma visão diferenciada de futuro: crescer com tecnologia, eficiência e responsabilidade ambiental — sem abrir mão de qualidade, confiança e preço competitivo.</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <img src="{{ asset('images/site/sede-tinsei.jpg') }}" alt="Fachada da sede da Tinsei em Belo Horizonte" class="col-span-2 aspect-[16/10] w-full rounded-3xl object-cover shadow-soft">
            <div class="rounded-3xl bg-brand-800 p-6 text-white">
                <p class="font-display text-4xl font-bold text-gold-400">{{ br_number($map['total']) }}</p>
                <p class="mt-1 text-sm text-brand-100">clientes ativos em {{ $map['states_served'] }} UFs</p>
            </div>
            <div class="rounded-3xl bg-gold-400 p-6 text-brand-950">
                <p class="font-display text-4xl font-bold">{{ setting('portfolio_items') }}</p>
                <p class="mt-1 text-sm">itens no portfólio</p>
            </div>
        </div>
    </div>
</section>

{{-- Valores --}}
<section class="bg-slate-50 py-20">
    <div class="container-site">
        <x-section-heading align="center" eyebrow="No que acreditamos" title="Os pilares que guiam cada entrega" />
        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['shield', 'Segurança e confiança', 'Relações de longo prazo com revendas de todo o país, com transparência, procedência e garantia.'],
                ['badge', 'Qualidade', 'Processos de recondicionamento e montagem com padrões de fábrica e testes rigorosos.'],
                ['tag', 'Preço competitivo', 'Importação direta, escala e eficiência operacional revertidas em margem para o cliente.'],
                ['leaf', 'Sustentabilidade', 'Economia circular e padrões ESG: menos descarte, mais vida útil para cada equipamento.'],
            ] as [$icon, $title, $text])
                <div class="reveal card p-6" style="transition-delay: {{ $loop->index * 70 }}ms">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-800 text-gold-300"><x-ico :name="$icon" class="h-6 w-6" /></span>
                    <h3 class="mt-5 text-lg font-bold text-brand-900">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Linha do tempo --}}
@if ($timeline->isNotEmpty())
    <section id="historia" class="relative overflow-hidden bg-brand-950 py-20 sm:py-24">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
        <div class="container-site relative">
            <x-section-heading :dark="true" align="center" eyebrow="Linha do tempo" title="A história da Tinsei" subtitle="Dos primeiros equipamentos importados à liderança nacional em A3 a laser." class="mb-16" />
            <x-timeline :items="$timeline" :dark="true" />
        </div>
    </section>
@endif

{{-- Sócios --}}
@if ($partners->isNotEmpty())
    <section id="socios" class="bg-white py-20 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="Liderança" title="Sócios com DNA jovem e preparados para o futuro" subtitle="Engajados no dia a dia da operação, unem espírito empreendedor, visão de negócios e gestão para conduzir a Tinsei em um mercado em transformação." />
            <div class="mt-12 space-y-8">
                @foreach ($partners as $partner)
                    <div class="reveal"><x-partner-card :partner="$partner" :full="true" /></div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Vídeo --}}
<section class="bg-slate-50 py-20">
    <div class="container-site grid items-center gap-12 lg:grid-cols-2">
        <x-youtube :url="setting('institutional_video_url')" title="Conheça a Tinsei" />
        <div>
            <x-section-heading eyebrow="Em vídeo" title="Conheça nossa estrutura" subtitle="Veja como funciona a operação que importa, recondiciona e entrega equipamentos de impressão para todo o Brasil." />
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('presence') }}" class="btn-primary">Onde estão nossos clientes</a>
                <a href="{{ route('contact.index') }}" class="btn-outline">Fale com a gente</a>
            </div>
        </div>
    </div>
</section>
@endsection
