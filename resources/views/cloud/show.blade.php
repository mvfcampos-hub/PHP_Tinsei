@extends('layouts.app')

@section('title', 'DataCloud')
@section('description', 'DataCloud: máquinas virtuais sob demanda com Linux, Windows e SQL Server, dimensionadas de acordo com a necessidade do seu projeto.')

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                Cloud & Infraestrutura
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white">DataCloud — Máquinas virtuais sob demanda</h1>
            <p class="text-brand-200 mt-4 max-w-2xl mx-auto text-lg">
                VMs com Linux, Windows e SQL Server, dimensionadas de acordo com a necessidade do seu projeto.
                Escalabilidade sem migrações complexas, previsibilidade de custos em reais e suporte especializado.
            </p>
            <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Quero montar um projeto sob medida no DataCloud.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition mt-8">
                Falar sobre um projeto sob medida
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ([
                ['label' => 'Escalabilidade sob demanda', 'desc' => 'Aumente vCPU, RAM e disco conforme o crescimento do projeto, sem migração complexa.'],
                ['label' => 'Linux, Windows e SQL Server', 'desc' => 'Distribuições Linux, Windows Server e banco de dados SQL Server prontos para produção.'],
                ['label' => 'Segurança dedicada', 'desc' => 'Ambiente isolado, com firewall e políticas de segurança configuradas para o seu projeto.'],
                ['label' => 'Uptime de 99,9%', 'desc' => 'Infraestrutura de alta disponibilidade com monitoramento e suporte especializado em português.'],
            ] as $feature)
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                    </span>
                    <p class="font-semibold text-slate-900">{{ $feature['label'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    @if ($plans->isNotEmpty())
        <section class="bg-brand-950 bg-grid-pattern">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-white">Planos DataCloud</h2>
                    <p class="text-brand-200 mt-2">Escolha o plano ideal ou monte uma configuração sob medida</p>
                </div>
                @php
                    $planColumns = match (true) {
                        $plans->count() >= 5 => 'lg:grid-cols-5',
                        $plans->count() === 4 => 'lg:grid-cols-4',
                        default => 'lg:grid-cols-3',
                    };
                @endphp
                <div class="grid sm:grid-cols-2 {{ $planColumns }} gap-6">
                    @foreach ($plans as $plan)
                        <x-cloud-plan-card :plan="$plan" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($cloudProducts->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Outros produtos de Cloud & Infraestrutura</h2>
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach ($cloudProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Precisa de uma configuração sob medida?</h2>
                <p class="text-brand-100 mt-2">Nossa equipe monta o ambiente ideal para o seu projeto.</p>
            </div>
            <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Preciso de uma configuração sob medida no DataCloud.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com um especialista
            </a>
        </div>
    </section>
@endsection
