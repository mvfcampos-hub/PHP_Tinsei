@extends('layouts.app')

@section('title', 'Serviços de TI')
@section('description', 'Serviços de TI Databit: Databit MSP, DataGateway+, DataSecurity+, DataBackup+ e Consultoria e Projetos de TI.')

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                Serviços em TI
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white">Uma empresa parceira em quem confiar</h1>
            <p class="text-brand-200 mt-4 max-w-2xl mx-auto text-lg">
                Tenha uma empresa parceira de confiança, que contribui efetivamente para a otimização do seu negócio —
                do suporte pontual à administração completa do seu ambiente de tecnologia.
            </p>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero falar sobre Serviços de TI.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition mt-8">
                Falar com um especialista
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-16">
        <a
            href="{{ route('msp.show') }}"
            class="group relative flex flex-col sm:flex-row items-center gap-6 overflow-hidden rounded-2xl border border-brand-800 bg-brand-950 bg-grid-pattern p-8 hover:border-accent-500 transition"
        >
            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-accent-500/15 text-accent-400">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
            </span>
            <div class="flex-1 text-center sm:text-left">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-2">
                    Nosso principal modelo de contratação
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-white">Databit MSP — Gestão Completa de TI</h2>
                <p class="text-brand-200 mt-1">
                    Somos o seu departamento de TI: monitoramos, protegemos, mantemos e evoluímos todo o
                    seu ambiente por uma mensalidade fixa, com SLA e suporte ilimitado.
                </p>
            </div>
            <span class="shrink-0 inline-flex items-center gap-1 rounded-lg bg-accent-500 px-5 py-2.5 text-sm font-semibold text-white group-hover:bg-accent-600 transition">
                Conhecer o MSP
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </span>
        </a>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wide mb-6">Serviços em destaque</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($services as $service)
                @php
                    $serviceHref = $service['anchor']
                        ? route('msp.show').'#'.$service['anchor']
                        : 'https://wa.me/553134168225?text='.urlencode('Olá! Quero falar sobre '.$service['name'].'.');
                    $isExternal = ! $service['anchor'];
                @endphp
                <a
                    href="{{ $serviceHref }}"
                    @if ($isExternal) target="_blank" rel="noopener" @endif
                    class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-6 hover:border-brand-300 hover:shadow-lg transition"
                >
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                        <x-dynamic-component :component="$service['icon']" class="h-6 w-6" />
                    </span>
                    <p class="font-semibold text-slate-900">{{ $service['name'] }}</p>
                    <p class="text-sm text-slate-500 mt-1 flex-1">{{ $service['description'] }}</p>
                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 mt-4 group-hover:text-brand-800">
                        Saiba mais
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Qual modelo de contratação faz sentido para você?</h2>
                <p class="text-brand-100 mt-2">Da demanda pontual ao outsourcing completo, montamos o formato ideal para a sua operação.</p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero falar sobre Serviços de TI.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com um especialista
            </a>
        </div>
    </section>
@endsection
