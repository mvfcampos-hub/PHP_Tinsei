@extends('layouts.app')

@section('title', 'Serviços de TI')
@section('description', 'Serviços de TI Databit: atendimentos avulsos, contratos por hora, outsourcing, contratos sob demanda, consultoria, monitoramento, migração para Microsoft 365 e collocation.')

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
            <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Quero falar sobre Serviços de TI.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition mt-8">
                Falar com um especialista
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                        <x-dynamic-component :component="$service['icon']" class="h-6 w-6" />
                    </span>
                    <p class="font-semibold text-slate-900">{{ $service['name'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">{{ $service['description'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Qual modelo de contratação faz sentido para você?</h2>
                <p class="text-brand-100 mt-2">Da demanda pontual ao outsourcing completo, montamos o formato ideal para a sua operação.</p>
            </div>
            <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Quero falar sobre Serviços de TI.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com um especialista
            </a>
        </div>
    </section>
@endsection
