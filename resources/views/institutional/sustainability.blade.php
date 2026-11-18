@extends('layouts.app')

@section('title', 'Sustentabilidade')
@section('description', 'Economia circular e padrões ESG: a Tinsei já recuperou mais de 1.800.000 kg de lixo eletrônico com o recondicionamento de equipamentos de impressão.')

@section('content')
<x-page-hero eyebrow="ESG" title="Sustentabilidade"
    subtitle="Recondicionar é prolongar a vida útil de equipamentos de alto padrão. É assim que a Tinsei une desempenho, economia para o cliente e responsabilidade com o planeta." />

<section class="bg-white py-20 sm:py-24">
    <div class="container-site grid gap-6 md:grid-cols-3">
        <div class="reveal rounded-3xl bg-leaf-700 p-8 text-white md:col-span-2">
            <x-ico name="recycle" class="h-10 w-10 text-leaf-300" />
            <p class="mt-8 font-display text-5xl font-extrabold sm:text-6xl">+{{ setting('ewaste_kg') }} kg</p>
            <p class="mt-3 max-w-lg text-lg text-leaf-100">de lixo eletrônico recuperados e devolvidos ao ciclo produtivo em forma de equipamentos, peças e suprimentos.</p>
        </div>
        <div class="reveal rounded-3xl bg-brand-800 p-8 text-white">
            <x-ico name="globe" class="h-10 w-10 text-gold-300" />
            <p class="mt-8 font-display text-3xl font-bold">Brasil e México</p>
            <p class="mt-3 text-brand-100">A Xerox escolheu a Tinsei como indústria de recondicionamento dos seus equipamentos, apoiada nos padrões de sustentabilidade do sistema ESG.</p>
        </div>
    </div>
</section>

<section class="bg-slate-50 py-20">
    <div class="container-site">
        <x-section-heading align="center" eyebrow="Como fazemos" title="Do equipamento usado ao equipamento pronto para mais um ciclo" />
        <ol class="mt-14 grid gap-6 md:grid-cols-4">
            @foreach ([
                ['globe', 'Importação criteriosa', 'Seleção de equipamentos de médio e grande porte com potencial de reuso.'],
                ['cog', 'Recondicionamento técnico', 'Revisão, troca de peças e testes com padrão de fábrica.'],
                ['badge', 'Qualidade garantida', 'Equipamento aprovado volta ao mercado com desempenho e segurança.'],
                ['recycle', 'Menos descarte', 'Mais vida útil, menos matéria-prima e menos lixo eletrônico.'],
            ] as [$icon, $title, $text])
                <li class="reveal relative card p-6" style="transition-delay: {{ $loop->index * 80 }}ms">
                    <span class="absolute right-5 top-4 font-display text-5xl font-extrabold text-slate-100">{{ $loop->iteration }}</span>
                    <span class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-leaf-50 text-leaf-700"><x-ico :name="$icon" class="h-6 w-6" /></span>
                    <h3 class="relative mt-5 font-bold text-brand-900">{{ $title }}</h3>
                    <p class="relative mt-2 text-sm leading-relaxed text-slate-500">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="bg-white py-20">
    <div class="container-site grid items-center gap-12 lg:grid-cols-2">
        <div>
            <x-section-heading eyebrow="Ambiental · Social · Governança" title="ESG como parte da estratégia" />
            <ul class="mt-8 space-y-5">
                @foreach ([
                    ['leaf', 'Ambiental', 'Economia circular no centro do negócio: recondicionamento, reaproveitamento de componentes e redução do descarte eletrônico.'],
                    ['users', 'Social', 'Geração de empregos qualificados em Minas Gerais e apoio ao crescimento de revendas em todo o Brasil.'],
                    ['shield', 'Governança', 'Gestão profissional, sócios atuantes e parcerias de longo prazo com fabricantes e clientes.'],
                ] as [$icon, $title, $text])
                    <li class="flex gap-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700"><x-ico :name="$icon" class="h-5 w-5" /></span>
                        <div><p class="font-semibold text-brand-900">{{ $title }}</p><p class="mt-1 text-sm leading-relaxed text-slate-500">{{ $text }}</p></div>
                    </li>
                @endforeach
            </ul>
        </div>
        <img src="{{ asset('images/site/atuacao-3.png') }}" alt="Equipamento Xerox recondicionado pela Tinsei" class="mx-auto w-full max-w-md rounded-3xl bg-slate-50 p-10">
    </div>
</section>
@endsection
