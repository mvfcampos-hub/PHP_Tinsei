@extends('layouts.app')

@section('title', 'DataMobile — Gestão de técnicos de campo')
@section('description', 'DataMobile: app mobile para gestão de atendimento técnico e técnicos de campo. Ordens de serviço, rota inteligente, assinatura em lote, controle de ponto por geolocalização e modo offline. Disponível na Google Play Store.')
@section('canonical', route('datamobile.show'))

@push('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => 'DataMobile',
            'description' => 'App para gestão de técnicos de campo: ordens de serviço, rota inteligente, assinatura em lote, controle de ponto por geolocalização e modo offline.',
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Android',
            'brand' => ['@type' => 'Brand', 'name' => 'Databit'],
            'url' => route('datamobile.show'),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <x-brand-mark class="hidden lg:block absolute -right-8 -top-10 h-36 w-auto opacity-[0.08] pointer-events-none select-none" aria-hidden="true" />
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-5 tracking-wide uppercase">
                        Nova versão disponível
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
                        Gestão de técnicos de campo <span class="text-accent-400">com o DataMobile</span>
                    </h1>
                    <p class="text-brand-200 mt-5 max-w-2xl mx-auto lg:mx-0 text-lg">
                        O aplicativo que sua equipe técnica sempre precisou — reinventado. Mais rápido, mais seguro, com
                        interface moderna e novos recursos para quem trabalha em campo.
                    </p>
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 mt-8">
                        <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero uma demonstração do DataMobile.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                            Solicitar demonstração
                        </a>
                        <a href="#novidades" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                            Ver novidades
                        </a>
                    </div>
                </div>

                {{-- Mockup do app, reproduzindo a tela "Visão Geral do Dia" do DataMobile --}}
                <div class="hidden lg:flex justify-center">
                    <div class="relative w-[300px] rounded-[2.5rem] border-4 border-white/10 bg-gradient-to-b from-brand-600 to-brand-800 shadow-2xl p-2.5">
                        <div class="absolute left-1/2 top-2.5 -translate-x-1/2 h-5 w-24 rounded-full bg-brand-950/60 z-10"></div>
                        <div class="rounded-[2rem] overflow-hidden bg-brand-800">
                            <div class="flex items-center justify-between px-5 pt-4 pb-2 text-white text-[11px] font-semibold">
                                <span>9:41</span>
                                <span class="flex items-center gap-1">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 15h2v3H2v-3zm4-4h2v7H6v-7zm4-4h2v11h-2V7zm4-4h2v15h-2V3z"/></svg>
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15a2 2 0 100 4 2 2 0 000-4zm0-9C5.5 6 1.7 8.1 0 11.2l1.8 1.4C3.2 10.1 6.3 8.5 10 8.5s6.8 1.6 8.2 4.1L20 11.2C18.3 8.1 14.5 6 10 6z"/></svg>
                                </span>
                            </div>
                            <div class="mx-3 mt-2 rounded-2xl bg-white/10 backdrop-blur px-4 py-3 flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-accent-500 text-white text-xs font-bold shrink-0">DA</span>
                                <div class="min-w-0">
                                    <p class="text-white text-xs font-semibold truncate">Olá, DATABIT</p>
                                    <p class="text-brand-200 text-[10px] truncate">databit@databit.com.br</p>
                                </div>
                            </div>
                            <div class="px-3 mt-3">
                                <p class="text-brand-200 text-[10px] font-semibold uppercase tracking-wide mb-2">Visão geral do dia</p>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach ([
                                        ['value' => '6', 'label' => 'OS Listadas'],
                                        ['value' => '1', 'label' => 'Aferição'],
                                        ['value' => '10', 'label' => 'Entregas'],
                                    ] as $stat)
                                        <div class="rounded-xl bg-white/10 py-2.5 text-center">
                                            <p class="text-white text-base font-bold">{{ $stat['value'] }}</p>
                                            <p class="text-brand-200 text-[9px] mt-0.5 leading-tight">{{ $stat['label'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="px-3 mt-3 pb-5">
                                <p class="text-brand-200 text-[10px] font-semibold uppercase tracking-wide mb-2">Acesso rápido</p>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach ([
                                        'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
                                        'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z',
                                        'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                        'M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z',
                                        'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
                                        'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
                                        'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99',
                                        'M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z',
                                    ] as $icon)
                                        <span class="flex h-10 items-center justify-center rounded-lg bg-white/10 text-brand-100">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" /></svg>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ([
                ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'value' => '+60%', 'label' => 'Ganho de desempenho'],
                ['icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99', 'value' => '100%', 'label' => 'Atualizações automáticas'],
                ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'value' => '3', 'label' => 'Sistemas integrados'],
                ['icon' => 'M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z', 'value' => '∞', 'label' => 'OS em modo offline'],
            ] as $stat)
                <div class="rounded-2xl bg-white border border-slate-200 shadow-lg shadow-slate-900/5 p-5 text-center">
                    <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" /></svg>
                    </span>
                    <p class="font-bold text-slate-900 text-lg">{{ $stat['value'] }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Novidades da versão --}}
    <section id="novidades" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Novidades da versão
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Tudo que é novo no DataMobile 2025</h2>
                <p class="text-slate-500 mt-3">
                    Reformulamos o aplicativo do zero. Interface reinventada, recursos inéditos e uma experiência
                    completamente nova para o técnico de campo.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z', 'title' => 'Assinatura de OS em lote', 'desc' => 'O cliente valida múltiplos atendimentos com uma única assinatura, acelerando o fechamento de chamados.'],
                    ['icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z', 'title' => 'Registro de despesas', 'desc' => 'O técnico registra gastos do dia e consulta adiantamentos direto no app, sem planilhas extras.'],
                    ['icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'title' => 'Meu Kit — estoque em campo', 'desc' => 'Visibilidade total sobre as peças e insumos sob responsabilidade do técnico.'],
                    ['icon' => 'M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z', 'title' => 'Rota inteligente', 'desc' => 'Integração nativa com o Google Maps, com planejamento de até 9 paradas simultâneas e filtro por proximidade.'],
                    ['icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25', 'title' => 'Base de conhecimento', 'desc' => 'A experiência acumulada da empresa disponível para o técnico em campo, editável pelo DataClassic.'],
                    ['icon' => 'M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5', 'title' => 'Dashboard do dia', 'desc' => 'Nova tela inicial com cards interativos de OS, despesas e entregas, com filtros rápidos por tipo de atendimento.'],
                    ['icon' => 'M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z', 'title' => 'Filtros avançados', 'desc' => 'Filtre OS por tipo, status, data ou proximidade — encontre rapidamente o atendimento certo.'],
                    ['icon' => 'M12 9.75l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Login com biometria', 'desc' => 'Acesso rápido e seguro por leitor de digitais, habilitado automaticamente após o primeiro login.'],
                    ['icon' => 'M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3', 'title' => 'Registro de placa e KM', 'desc' => 'Salvamento automático de placa e quilometragem, agilizando o check-in e reduzindo erros de digitação.'],
                ] as $item)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-1 transition relative">
                        <span class="absolute top-5 right-5 rounded-full bg-accent-50 text-accent-600 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide">Novo</span>
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-500 text-white mb-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" /></svg>
                        </span>
                        <h3 class="font-semibold text-slate-900 mb-2 pr-14">{{ $item['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Play Store --}}
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                    Oficialmente na Play Store
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Atualizações automáticas. <span class="text-accent-400">Sem complicação.</span></h2>
                <p class="text-brand-200 mt-4">
                    A partir de agora, o DataMobile está disponível oficialmente na Google Play Store. Esqueça
                    processos manuais de atualização — tudo acontece de forma automática e centralizada.
                </p>
                <ul class="space-y-3 mt-6">
                    @foreach ([
                        'Atualizações 100% automáticas via Play Store — zero intervenção manual',
                        'Segurança reforçada com revisão do Google e assinatura de app oficial',
                        'Novos recursos entregues diretamente ao dispositivo do técnico',
                        'Instalação simplificada — basta buscar por "DATAMOBILE"',
                    ] as $item)
                        <li class="flex items-start gap-3 text-brand-100 text-sm">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-accent-500 text-white mt-0.5">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <a href="https://play.google.com/store/apps" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-brand-900 hover:bg-brand-50 transition mt-6">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5m4.75-11.396c.251.023.501.05.75.082m-.75-.082L9 3a48.474 48.474 0 016 0m-6 0v5.714a2.25 2.25 0 00.659 1.591L14.5 14.5m-9.5 0l4.395 4.395a1.5 1.5 0 001.06.44H14.5m-9.5-4.835L14.5 14.5" /></svg>
                    Disponível no Google Play
                </a>
            </div>
            <div class="rounded-2xl bg-white/5 border border-white/15 p-6 sm:p-8 text-center">
                <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-accent-500/15 text-accent-300 mb-5">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                </span>
                <h3 class="text-white font-semibold">DataMobile v2.0</h3>
                <p class="text-brand-200 text-sm mt-1">Plataforma completa</p>
                <p class="text-brand-200 text-sm mt-4">Tudo que já era bom, ficou ainda melhor — recursos consagrados evoluíram com performance superior, visual modernizado e usabilidade aprimorada.</p>
            </div>
        </div>
    </section>

    {{-- Performance e segurança --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Performance & Segurança
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Mais rápido. Mais seguro. Completamente renovado.</h2>
                <p class="text-slate-500 mt-3">
                    O DataMobile foi reescrito com foco em velocidade, estabilidade e proteção de dados para operações
                    críticas em campo.
                </p>
            </div>
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Ganho de desempenho', 'desc' => 'Sincronização, carregamento de listas e abertura de OS significativamente mais ágeis. O técnico perde menos tempo esperando e mais tempo atendendo.'],
                    ['icon' => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z', 'title' => 'Comunicação criptografada (SSL)', 'desc' => 'Toda a comunicação entre o app e os servidores Databit é criptografada. Dados sensíveis de OS, clientes e técnicos protegidos em trânsito.'],
                    ['icon' => 'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42', 'title' => 'Interface completamente renovada', 'desc' => 'Design clean com hierarquia visual clara, melhor legibilidade e espaçamento otimizado. Reduz o esforço cognitivo durante uso contínuo em campo.'],
                ] as $item)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" /></svg>
                        </span>
                        <h3 class="font-semibold text-slate-900 mb-2">{{ $item['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Ecossistema --}}
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                    Ecossistema Databit
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Tudo conectado. Uma só plataforma.</h2>
                <p class="text-brand-200 mt-3">
                    O DataMobile não é um app isolado — é o braço de campo de um ecossistema completo de gestão
                    empresarial, com sincronização bidirecional em tempo real entre todas as soluções Databit.
                </p>
            </div>
            <div class="grid sm:grid-cols-3 gap-6 items-center">
                <a href="{{ route('products.show', 'dataclassic') }}" class="rounded-2xl bg-white/5 border border-white/15 p-6 text-center hover:border-accent-400/50 transition">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-brand-500/20 text-brand-200 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21M3 9l9-6 9 6v9.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V9z" /></svg>
                    </span>
                    <h3 class="font-semibold text-white">DataClassic</h3>
                    <p class="text-sm text-brand-200 mt-2">ERP completo com gestão de OS, estoques, financeiro, contratos e monitor de SLA.</p>
                </a>
                <div class="rounded-2xl bg-white p-6 text-center shadow-xl ring-4 ring-accent-500/20 relative">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-accent-500 px-3 py-1 text-[10px] font-bold text-white uppercase tracking-wide">Você está aqui</span>
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                    </span>
                    <h3 class="font-bold text-slate-900">DataMobile</h3>
                    <p class="text-sm text-slate-500 mt-2">App oficial para técnicos de campo. Execução, registro e encerramento de OS em tempo real.</p>
                </div>
                <div class="rounded-2xl bg-white/5 border border-white/15 p-6 text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-500/20 text-cyan-300 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                    </span>
                    <h3 class="font-semibold text-white">DataService Web</h3>
                    <p class="text-sm text-brand-200 mt-2">Portal web de gestão de serviços. Abertura de chamados, acompanhamento e relatórios para gestores e clientes.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Gestão de campo completa --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Funcionalidades
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Gestão de campo completa</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'title' => 'Ordens de serviço', 'desc' => 'Receba, visualize e execute OS diretamente no app, com check-in/check-out por geolocalização e laudo técnico completo.'],
                    ['icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z', 'title' => 'Monitoramento em tempo real', 'desc' => 'Gestores acompanham a equipe técnica em campo via geolocalização, integrado ao DataService Web.'],
                    ['icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25', 'title' => 'Controle de entregas', 'desc' => 'Gestão de entrega de peças e suprimentos, com assinatura do cliente e envio automático do protocolo por e-mail.'],
                    ['icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Controle de ponto', 'desc' => 'Registro de início, intervalo e fim de expediente com geolocalização, com relatório completo de banco de horas.'],
                ] as $item)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-500 text-white mb-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" /></svg>
                        </span>
                        <h3 class="font-semibold text-slate-900 mb-2">{{ $item['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Como funciona --}}
    <section class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Como funciona na prática
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Do chamado ao relatório, tudo em tempo real.</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['step' => '1', 'title' => 'Chamado aberto', 'desc' => 'Cliente ou gestor abre a OS no DataService Web ou no DataClassic.'],
                    ['step' => '2', 'title' => 'OS enviada ao técnico', 'desc' => 'Gestor define o técnico no DataClassic — a OS aparece no app instantaneamente.'],
                    ['step' => '3', 'title' => 'Atendimento em campo', 'desc' => 'Técnico executa, registra e encerra a OS com assinatura no DataMobile.'],
                    ['step' => '4', 'title' => 'Dados sincronizados', 'desc' => 'DataClassic atualizado em tempo real — gestor acompanha o SLA e emite relatórios.'],
                ] as $item)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-950 text-accent-400 font-bold text-sm mb-4">
                            {{ $item['step'] }}
                        </span>
                        <h3 class="font-semibold text-slate-900 mb-2">{{ $item['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Leve o DataMobile para a sua equipe hoje.</h2>
                <p class="text-brand-100 mt-2">Fale com um especialista Databit e descubra como o novo aplicativo pode transformar a gestão dos seus técnicos de campo.</p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero falar sobre o DataMobile.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com especialista no WhatsApp
            </a>
        </div>
    </section>
@endsection
