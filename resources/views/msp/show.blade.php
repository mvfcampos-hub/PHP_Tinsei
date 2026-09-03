@extends('layouts.app')

@section('title', 'Serviços Gerenciados de TI (MSP)')
@section('description', 'Databit MSP: gestão completa da TI da sua empresa por uma mensalidade fixa — service desk, monitoramento 24/7, segurança, rede, patches, inventário e consultoria estratégica.')

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                Nosso principal modelo de contratação
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white">Databit MSP — Gestão Completa de TI</h1>
            <p class="text-brand-200 mt-4 max-w-2xl mx-auto text-lg">
                A Databit assume a gestão completa da TI da sua empresa. Somos o seu departamento de TI —
                monitoramos, protegemos, mantemos e evoluímos todo o seu ambiente tecnológico por uma
                mensalidade fixa, sem surpresas.
            </p>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero conhecer o modelo de Serviços Gerenciados (MSP) da Databit.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition mt-8">
                Falar com um especialista
            </a>
        </div>
    </section>

    {{-- Preço --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Preço, simples e previsível</h2>
            <p class="text-slate-500 mt-2">Um valor fixo por dispositivo, sem letras miúdas.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <p class="font-semibold text-slate-900">Workstations (desktop / notebook)</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach ($workstationPricing as $tier)
                        <div class="flex items-center justify-between px-6 py-3.5">
                            <span class="text-sm text-slate-600">{{ $tier['range'] }} dispositivos</span>
                            <span class="font-semibold text-slate-900">R$ {{ number_format($tier['price'], 2, ',', '.') }} <span class="text-slate-400 font-normal text-sm">/dispositivo/mês</span></span>
                        </div>
                    @endforeach
                    <div class="flex items-center justify-between px-6 py-3.5 bg-slate-50">
                        <span class="text-sm text-slate-600">Servidor (físico ou virtual)</span>
                        <span class="font-semibold text-slate-900">R$ {{ number_format($serverPrice, 2, ',', '.') }} <span class="text-slate-400 font-normal text-sm">/mês (fixo, por servidor)</span></span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border-2 border-accent-500 bg-accent-50 p-6">
                <p class="text-xs font-semibold text-accent-700 uppercase tracking-wide">Contrato mínimo</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">R$ {{ number_format($minimumContract, 2, ',', '.') }}<span class="text-base font-medium text-slate-500">/mês</span></p>
                <p class="text-sm text-slate-600 mt-3">
                    Equivale a 10 workstations e garante que todo cliente, independente do porte,
                    receba o pacote completo — incluindo gestão de rede e firewall.
                </p>
            </div>
        </div>
    </section>

    {{-- O que está incluído --}}
    <section class="bg-slate-50 border-y border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">O que está incluído</h2>
                <p class="text-slate-500 mt-2">Tudo o que o seu ambiente de TI precisa, em um único contrato.</p>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                @foreach ($included as $category)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                                <x-dynamic-component :component="$category['icon']" class="h-5 w-5" />
                            </span>
                            <p class="font-semibold text-slate-900">{{ $category['title'] }}</p>
                        </div>
                        <ul class="space-y-2">
                            @foreach ($category['items'] as $item)
                                <li class="flex items-start gap-2 text-sm text-slate-600">
                                    <svg class="h-4 w-4 shrink-0 text-accent-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                        @if (!empty($category['note']))
                            <p class="text-xs text-slate-500 bg-slate-50 rounded-lg p-3 mt-4">{{ $category['note'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SLA --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">SLA — Acordo de Nível de Serviço</h2>
            <p class="text-slate-500 mt-2">Horário de cobertura padrão: segunda a sexta, 8h às 17h. Atendimento emergencial fora do horário, cobrado como hora extra.</p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                        <th class="px-5 py-3">Prioridade</th>
                        <th class="px-5 py-3">Descrição</th>
                        <th class="px-5 py-3">Tempo de resposta</th>
                        <th class="px-5 py-3">Tempo de resolução</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($sla as $row)
                        <tr>
                            <td class="px-5 py-3.5">
                                <span @class([
                                    'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold',
                                    'bg-red-50 text-red-700' => $row['priority'] === 'Crítica',
                                    'bg-orange-50 text-orange-700' => $row['priority'] === 'Alta',
                                    'bg-amber-50 text-amber-700' => $row['priority'] === 'Média',
                                    'bg-slate-100 text-slate-600' => $row['priority'] === 'Baixa',
                                ])>{{ $row['priority'] }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $row['description'] }}</td>
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $row['response'] }}</td>
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $row['resolution'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- O que não está incluído --}}
    <section class="bg-slate-50 border-y border-slate-200">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">O que não está incluído</h2>
                <p class="text-slate-500 mt-2">Para total transparência, estes itens ficam fora do escopo padrão.</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8">
                <ul class="grid sm:grid-cols-2 gap-x-8 gap-y-3">
                    @foreach ($notIncluded as $item)
                        <li class="flex items-start gap-2 text-sm text-slate-600">
                            <svg class="h-4 w-4 shrink-0 text-slate-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Add-ons --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Eleve sua proteção com os add-ons</h2>
            <p class="text-slate-500 mt-2">Camadas adicionais, contratadas sob consulta conforme a necessidade do seu ambiente.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            @foreach ($addons as $addon)
                <div id="addon-{{ \Illuminate\Support\Str::slug(str_replace('+', '', $addon['name'])) }}" class="rounded-2xl border border-slate-200 bg-white p-6 flex flex-col scroll-mt-28">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-950 text-accent-400 mb-4">
                        <x-dynamic-component :component="$addon['icon']" class="h-6 w-6" />
                    </span>
                    <p class="font-bold text-slate-900 text-lg">{{ $addon['name'] }}</p>
                    <p class="text-sm text-slate-500 mt-1 mb-4">{{ $addon['tagline'] }}</p>
                    <ul class="space-y-3 flex-1">
                        @foreach ($addon['items'] as $item)
                            <li class="text-sm">
                                <span class="block font-medium text-slate-800">{{ $item['name'] }}</span>
                                <span class="block text-slate-500">{{ $item['description'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-xs text-slate-400 mt-4 pt-4 border-t border-slate-100">
                        {{ $addon['note'] ?? 'Precificação sob consulta — varia conforme número de usuários e ferramentas escolhidas.' }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Resumo rápido --}}
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Resumo rápido</h2>
                <p class="text-brand-200 mt-2">Você recebe no pacote base:</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 sm:p-8">
                <ul class="grid sm:grid-cols-2 gap-x-8 gap-y-3">
                    @foreach ($summaryIncluded as $item)
                        <li class="flex items-start gap-2 text-sm text-brand-100">
                            <svg class="h-4 w-4 shrink-0 text-accent-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Qualificação da equipe --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Qualificação da equipe</h2>
            <p class="text-slate-500 mt-2 max-w-2xl mx-auto">
                Equipe técnica qualificada e em constante atualização, com experiência comprovada em
                ambientes legados, modernos, cloud e híbridos.
            </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                        <th class="px-5 py-3 w-1/3">Área</th>
                        <th class="px-5 py-3">Certificações / Experiência</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($certifications as $row)
                        <tr>
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $row['area'] }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $row['detail'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- Comparativo --}}
    <section class="bg-slate-50 border-y border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Por que MSP?</h2>
                <p class="text-slate-500 mt-2">Como o modelo Databit se compara a outras formas de manter a TI da sua empresa.</p>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
                <table class="w-full text-sm min-w-[720px]">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide">
                            <th class="px-5 py-3 text-slate-500">Característica</th>
                            <th class="px-5 py-3 text-white bg-brand-700">Databit MSP</th>
                            <th class="px-5 py-3 text-slate-500">TI sob demanda (avulso)</th>
                            <th class="px-5 py-3 text-slate-500">Equipe interna (CLT)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($comparison as $row)
                            <tr>
                                <td class="px-5 py-3.5 font-medium text-slate-800 align-top">{{ $row['feature'] }}</td>
                                <td class="px-5 py-3.5 text-slate-700 align-top bg-brand-50/60">{{ $row['msp'] }}</td>
                                <td class="px-5 py-3.5 text-slate-500 align-top">{{ $row['ondemand'] }}</td>
                                <td class="px-5 py-3.5 text-slate-500 align-top">{{ $row['inhouse'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 mt-8">
                <p class="text-xs font-semibold text-accent-600 uppercase tracking-wide mb-2">Exemplo de custo-benefício</p>
                <p class="text-slate-600 text-sm">
                    Para uma empresa com 20 computadores e 1 servidor, o plano Databit MSP custa
                    <strong class="text-slate-900">R$ 2.630/mês</strong> (tudo incluso: equipe, monitoramento, antivírus e SLA) —
                    um valor inferior ao de um profissional júnior/pleno em CLT
                    (<strong class="text-slate-900">~R$ 6.350/mês</strong>, somando salário, encargos e ferramentas avulsas,
                    e sem cobertura durante férias). Além disso, uma única parada de 4 horas em uma empresa que fatura
                    R$ 200 mil/mês já custa cerca de R$ 5 mil em produtividade perdida — praticamente dois meses do plano proativo da Databit.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Pronto para ter um departamento de TI completo?</h2>
                <p class="text-brand-100 mt-2">Fale com a gente e receba uma proposta dimensionada para o seu ambiente.</p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero uma proposta do Databit MSP para a minha empresa.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com um especialista
            </a>
        </div>
    </section>
@endsection
