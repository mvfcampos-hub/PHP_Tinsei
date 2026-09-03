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

    <article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="prose prose-slate max-w-none prose-a:text-brand-700">
            {!! $page->content !!}
        </div>
    </article>

    {{-- Fundadores --}}
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16 grid md:grid-cols-2 gap-10 items-center">
            <img src="{{ asset('images/team/fundadores.png') }}" alt="Roger Martins e Andreia Formaggini, fundadores da Databit" class="w-full rounded-2xl shadow-xl">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                    Desde 1986
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Roger Martins e Andreia Formaggini</h2>
                <p class="text-brand-200 mt-3 leading-relaxed">
                    A Databit nasceu da manutenção de equipamentos de informática e se transformou, ao longo de mais
                    de 30 anos, em um ecossistema completo de ERP, Cloud, mobilidade, atendimento e serviços de TI —
                    sempre com o mesmo compromisso de proximidade com o cliente.
                </p>
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
