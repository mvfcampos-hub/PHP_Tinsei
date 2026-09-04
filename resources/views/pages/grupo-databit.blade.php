@extends('layouts.app')

@section('title', $page->title)
@section('description', 'Conheça a história, a missão, a visão, os valores e a liderança da Databit — mais de 30 anos de tecnologia para simplificar a gestão empresarial.')
@section('canonical', route('pages.show', 'grupo-databit'))

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">{{ $page->title }}</h1>
        </div>
    </section>

    <article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 pt-12">
        <div class="prose prose-slate max-w-none prose-a:text-brand-700">
            {!! $page->content !!}
        </div>
    </article>

    {{-- Missão, Visão e Valores --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-7">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-500 text-white mb-5">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" /></svg>
                </span>
                <h2 class="font-bold text-slate-900 text-lg mb-2">Missão</h2>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $mission }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-7">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-500 text-white mb-5">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </span>
                <h2 class="font-bold text-slate-900 text-lg mb-2">Visão</h2>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $vision }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-7">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-500 text-white mb-5">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" /></svg>
                </span>
                <h2 class="font-bold text-slate-900 text-lg mb-3">Valores</h2>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($values as $value)
                        <span class="inline-flex items-center rounded-full bg-brand-50 text-brand-700 text-xs font-medium px-2.5 py-1">{{ $value }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Fundadores --}}
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <x-brand-mark class="hidden lg:block absolute -right-6 -top-8 h-32 w-auto opacity-[0.08] pointer-events-none select-none" aria-hidden="true" />
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16 grid md:grid-cols-2 gap-10 items-center relative">
            <img src="{{ asset('images/team/fundadores.png') }}" alt="Roger Martins e Andreia Formaggini, fundadores da Databit" class="w-full rounded-2xl shadow-xl">
            <div>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold">
                        Desde 1986
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 text-white px-3 py-1 text-xs font-semibold">
                        Fundadores da Databit
                    </span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Roger Martins e Andreia Formaggini</h2>
                <p class="text-brand-200 mt-3 leading-relaxed">
                    A Databit nasceu da manutenção de equipamentos de informática e se transformou, ao longo de mais
                    de 30 anos, em um ecossistema completo de ERP, Cloud, mobilidade, atendimento e serviços de TI —
                    sempre com o mesmo compromisso de proximidade com o cliente.
                </p>
                <p class="text-brand-200 mt-3 leading-relaxed">
                    Roger Martins é hoje uma referência como empreendedor no segmento de tecnologia, tendo conduzido
                    a Databit da manutenção de equipamentos a um ecossistema completo de software de gestão — ao
                    lado de Andreia Formaggini, cofundadora da empresa.
                </p>
            </div>
        </div>
    </section>

    {{-- Vídeo institucional --}}
    <section class="bg-slate-50 border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Nossa história em vídeo</h2>
                <p class="text-slate-500 mt-2">Um resumo de quem somos e da trajetória da Databit até aqui.</p>
            </div>
            <div class="rounded-2xl overflow-hidden aspect-video bg-slate-950 shadow-xl">
                <iframe
                    src="https://www.youtube.com/embed/Te7HwvvGWkM"
                    class="w-full h-full"
                    title="A história da Databit"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </section>

    {{-- Sócios --}}
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">Sócios que sustentam o negócio</h2>
            <p class="text-slate-500 mb-10">As pessoas por trás da operação e da tecnologia da Databit, todos os dias.</p>
            <div class="grid sm:grid-cols-2 gap-6">
                @foreach ($partnerHighlights as $partner)
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-7 flex flex-col sm:flex-row gap-5 items-start">
                        <img
                            src="{{ asset('images/team/'.$partner['photo']) }}"
                            alt="{{ $partner['name'] }}"
                            class="h-20 w-20 shrink-0 rounded-full object-cover border-4 border-white shadow-lg ring-1 ring-slate-200"
                        >
                        <div>
                            <p class="font-bold text-slate-900 text-lg">{{ $partner['name'] }}</p>
                            <p class="text-xs font-semibold text-brand-700 uppercase tracking-wide mb-2">{{ $partner['role'] }}</p>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $partner['bio'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Linha do tempo --}}
    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-10">Nossa trajetória</h2>
        <ol class="relative border-s-2 border-slate-200 space-y-8 ms-2">
            @foreach ($timeline as $item)
                <li class="ms-6">
                    <span class="absolute -start-[9px] flex h-4 w-4 rounded-full bg-brand-600 ring-4 ring-white"></span>
                    <span class="text-sm font-bold text-brand-700">{{ $item['year'] }}</span>
                    <p class="text-slate-600 mt-1">{{ $item['text'] }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Liderança --}}
    <section class="bg-white border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-10">Liderança</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($leadership as $person)
                    <div class="text-center">
                        @if ($person['photo'])
                            <img
                                src="{{ asset('images/team/'.$person['photo']) }}"
                                alt="{{ $person['name'] }}"
                                class="h-24 w-24 sm:h-28 sm:w-28 mx-auto rounded-full object-cover border-4 border-white shadow-lg ring-1 ring-slate-200"
                            >
                        @else
                            <span class="flex h-24 w-24 sm:h-28 sm:w-28 mx-auto items-center justify-center rounded-full bg-brand-50 text-brand-700 text-2xl font-bold border-4 border-white shadow-lg ring-1 ring-slate-200">
                                {{ Str::of($person['name'])->substr(0, 1) }}
                            </span>
                        @endif
                        <p class="font-semibold text-slate-900 mt-3">{{ $person['name'] }}</p>
                        <p class="text-sm text-slate-500">{{ $person['role'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
