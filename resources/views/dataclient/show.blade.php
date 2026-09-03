@extends('layouts.app')

@section('title', 'DataClient CRM — Transforme cada contato em uma oportunidade real')
@section('description', 'DataClient CRM: sistema comercial 100% web da Databit, integrado ao DataSAC e ao DataClassic. Centralize o pipeline, automatize follow-ups e feche mais negócios.')
@section('canonical', route('dataclient.show'))

@push('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => 'DataClient CRM',
            'description' => 'CRM 100% web que centraliza o pipeline comercial, automatiza follow-ups e se integra ao DataSAC e ao DataClassic.',
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'brand' => ['@type' => 'Brand', 'name' => 'Databit'],
            'url' => route('dataclient.show'),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <x-brand-mark class="hidden lg:block absolute -right-8 -top-10 h-36 w-auto opacity-[0.08] pointer-events-none select-none" aria-hidden="true" />
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24 text-center relative">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-5 tracking-wide uppercase">
                DataClient CRM · Produto 100% Web
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
                Transforme cada contato em <span class="text-accent-400">uma oportunidade real</span>
            </h1>
            <p class="text-brand-200 mt-5 max-w-2xl mx-auto text-lg">
                O DataClient é o CRM da Databit, integrado nativamente ao DataSAC e ao DataClassic. Centralize seu
                pipeline, automatize follow-ups e feche mais negócios — sem deixar nenhum lead esfriar.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero conhecer o DataClient CRM.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                    Quero conhecer o DataClient
                </a>
                <a href="#funcionalidades" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                    Ver funcionalidades
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ([
                ['icon' => 'M8.25 21v-4.97a.75.75 0 01.75-.75h6a.75.75 0 01.75.75V21M3.75 9.75l8.078-6.46a1.125 1.125 0 011.393 0l8.078 6.46M3.75 9.75v9.75a2.25 2.25 0 002.25 2.25h12a2.25 2.25 0 002.25-2.25V9.75M3.75 9.75L12 3l8.25 6.75', 'value' => '+30 Anos', 'label' => 'De mercado'],
                ['icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75', 'value' => '100% Web', 'label' => 'Acesse de qualquer lugar'],
                ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'value' => '6 Canais', 'label' => 'Integrados via DataSAC'],
                ['icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'value' => '0 Planilhas', 'label' => 'Necessárias'],
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

    {{-- O problema real --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 text-red-600 px-3 py-1 text-xs font-semibold mb-4">
                    O problema real
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">
                    Quantas oportunidades escaparam por falta de acompanhamento?
                </h2>
                <p class="text-slate-500 mt-3">
                    Sua equipe comercial merece mais do que planilhas e lembretes. Merece um sistema que trabalha
                    junto com ela — organizando, alertando e convertendo.
                </p>
            </div>
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'title' => 'Planilhas desatualizadas', 'desc' => 'Ninguém mantém, ninguém confia — o que leva a decisões erradas e oportunidades perdidas.'],
                    ['icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Follow-ups esquecidos', 'desc' => 'Falta de alertas e de visibilidade sobre onde cada negociação está no funil de vendas.'],
                    ['icon' => 'M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5', 'title' => 'Atendimento fragmentado', 'desc' => 'Vários canais sem histórico centralizado, gerando retrabalho e experiência ruim ao cliente.'],
                ] as $problem)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-500 mb-4">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $problem['icon'] }}" /></svg>
                        </span>
                        <h3 class="font-semibold text-slate-900 mb-2">{{ $problem['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $problem['desc'] }}</p>
                    </div>
                @endforeach
            </div>
            <p class="text-center text-slate-600 mt-8 font-medium">Com o CRM certo, isso não acontece mais.</p>
        </div>
    </section>

    {{-- Ecossistema Databit --}}
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                    Ecossistema Databit
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Três soluções. Um ecossistema integrado.</h2>
                <p class="text-brand-200 mt-3">
                    O DataClient não é um CRM isolado. Ele é o elo comercial do ecossistema Databit, conversando
                    nativamente com as outras soluções da empresa.
                </p>
            </div>
            <div class="grid lg:grid-cols-[1fr_auto_1fr_auto_1fr] gap-6 items-center">
                <div class="rounded-2xl bg-white/5 border border-white/15 p-6 text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-500/20 text-cyan-300 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                    </span>
                    <h3 class="font-semibold text-white">DataSAC</h3>
                    <p class="text-sm text-brand-200 mt-2">
                        Canal de atendimento omnichannel. Recebe contatos de WhatsApp, Telegram, Instagram, Facebook
                        Messenger, e-mail e WebChat — e transforma conversas em leads direto no DataClient.
                    </p>
                </div>
                <div class="hidden lg:flex justify-center text-brand-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </div>
                <div class="rounded-2xl bg-white p-6 text-center shadow-xl ring-4 ring-accent-500/20 relative">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-accent-500 px-3 py-1 text-[10px] font-bold text-white uppercase tracking-wide">Você está aqui</span>
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    </span>
                    <h3 class="font-bold text-slate-900">DataClient CRM</h3>
                    <p class="text-sm text-slate-500 mt-2">
                        O centro de inteligência comercial. Gerencie leads, oportunidades, funis, propostas,
                        follow-ups e pós-venda em um único lugar, 100% web.
                    </p>
                </div>
                <div class="hidden lg:flex justify-center text-brand-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </div>
                <a href="{{ route('products.show', 'dataclassic') }}" class="rounded-2xl bg-white/5 border border-white/15 p-6 text-center hover:border-accent-400/50 transition">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-brand-500/20 text-brand-200 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21M3 9l9-6 9 6v9.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V9z" /></svg>
                    </span>
                    <h3 class="font-semibold text-white">DataClassic ERP</h3>
                    <p class="text-sm text-brand-200 mt-2">
                        O ERP completo da Databit. Negócios fechados no DataClient disparam automaticamente pedidos e
                        processos de faturamento no ERP, sem retrabalho.
                    </p>
                </a>
            </div>
        </div>
    </section>

    {{-- Canais integrados --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                Canais integrados via DataSAC
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">O lead chega pelo canal que o cliente prefere.</h2>
            <p class="text-slate-500 mt-3 max-w-2xl mx-auto">
                O DataSAC conecta o DataClient a todos os principais canais de comunicação. Cada contato recebido
                pode virar um lead e uma oportunidade com apenas alguns cliques.
            </p>
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-4 mt-10">
                @foreach ([
                    ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'label' => 'WhatsApp'],
                    ['icon' => 'M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5', 'label' => 'Telegram'],
                    ['icon' => 'M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m0 4.5H12m9-6.75c0 5.385-4.365 9.75-9.75 9.75-1.163 0-2.278-.203-3.313-.575l-4.687 1.407a.75.75 0 01-.933-.933l1.407-4.687A9.706 9.706 0 012.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12z', 'label' => 'Messenger'],
                    ['icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z', 'label' => 'Instagram'],
                    ['icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75', 'label' => 'Mail Marketing'],
                    ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'WebChat'],
                ] as $channel)
                    <div class="flex flex-col items-center gap-2">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $channel['icon'] }}" /></svg>
                        </span>
                        <span class="text-xs font-medium text-slate-600">{{ $channel['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Fluxo de vendas --}}
    <section class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Fluxo de vendas
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Do primeiro contato ao contrato assinado.</h2>
                <p class="text-slate-500 mt-3">Uma jornada comercial completa, sem lacunas e sem trabalho manual desnecessário.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @foreach ([
                    ['step' => '1', 'title' => 'Contato', 'desc' => 'Chega pelo DataSAC via qualquer canal omnichannel.'],
                    ['step' => '2', 'title' => 'Lead', 'desc' => 'Convertido para o DataClient com histórico completo.'],
                    ['step' => '3', 'title' => 'Oportunidade', 'desc' => 'Gerenciada em múltiplos funis com Kanban e lista.'],
                    ['step' => '4', 'title' => 'Proposta', 'desc' => 'Elaborada e enviada de forma personalizada pelo sistema.'],
                    ['step' => '5', 'title' => 'Fechamento', 'desc' => 'Integra com o ERP DataClassic para faturamento automático.'],
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

    {{-- Interface real --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Interface real
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Veja o DataClient por dentro.</h2>
                <p class="text-slate-500 mt-3">
                    Painel visual de acompanhamento, agenda integrada e acesso seguro por parceiro — tudo pensado
                    para o dia a dia da sua equipe comercial.
                </p>
            </div>

            {{-- Mockup: Painel Kanban --}}
            <div class="rounded-2xl border border-slate-200 shadow-2xl shadow-slate-900/10 overflow-hidden bg-white">
                <div class="flex items-center gap-1.5 bg-slate-100 border-b border-slate-200 px-4 py-3">
                    <span class="h-3 w-3 rounded-full bg-red-400"></span>
                    <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                    <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                    <span class="ml-3 text-xs text-slate-400 font-medium truncate">app.dataclient.com.br/pre-contratos/painel</span>
                </div>
                <div class="flex">
                    <div class="hidden md:flex w-44 shrink-0 flex-col bg-[#141d33] text-white/60 text-[11px] py-4">
                        <div class="px-4 pb-4 mb-2 border-b border-white/10 flex items-center gap-2">
                            <span class="h-6 w-6 rounded-md bg-gradient-to-br from-accent-400 to-brand-500"></span>
                            <span class="font-bold text-white text-xs tracking-wide">DataClient</span>
                        </div>
                        <div class="flex flex-col gap-0.5 px-2">
                            @foreach (['Página Inicial', 'Clientes', 'Vendedores', 'Oportunidades', 'Pré-Contratos', 'Atividades', 'Consultas'] as $item)
                                <span @class([
                                    'rounded-md px-2.5 py-1.5',
                                    'bg-white/10 text-white font-semibold' => $item === 'Pré-Contratos',
                                ])>{{ $item }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="bg-gradient-to-r from-brand-700 to-brand-500 px-6 py-5">
                            <p class="text-white font-bold text-sm sm:text-base">Painel de Acompanhamento</p>
                            <p class="text-brand-100 text-xs mt-0.5">Gerencie contratos, vigências, valores e movimentações.</p>
                        </div>
                        <div class="p-4 overflow-x-auto">
                            <div class="flex gap-3 min-w-[880px]">
                                @foreach ([
                                    ['label' => '1 · EM GERAÇÃO', 'color' => '#991b1b', 'count' => 0, 'cards' => []],
                                    ['label' => '2 · CRÉDITO', 'color' => '#0d9488', 'count' => 1, 'cards' => [['name' => 'Comércio Modelo S/A', 'value' => 'R$ 2.370,00']]],
                                    ['label' => '3 · ESTOQUE', 'color' => '#7e22ce', 'count' => 4, 'cards' => [['name' => 'Distribuidora Beta Ltda', 'value' => 'R$ 720,00'], ['name' => 'Indústria Alfa Ltda', 'value' => 'R$ 2.370,00']]],
                                    ['label' => '4 · COMERCIAL', 'color' => '#dc2626', 'count' => 3, 'cards' => [['name' => 'Grupo Ômega Serviços', 'value' => 'R$ 360,00'], ['name' => 'Hospital Central', 'value' => 'R$ 794,96']]],
                                    ['label' => '5 · ANÁLISE', 'color' => '#475569', 'count' => 2, 'cards' => [['name' => 'Atacado Vitória Ltda', 'value' => 'R$ 512,00']]],
                                    ['label' => '6 · GESTÃO', 'color' => '#d97706', 'count' => 5, 'cards' => [['name' => 'Serviços Gama Ltda', 'value' => 'R$ 215,00'], ['name' => 'Consórcio Estrela SPE', 'value' => 'R$ 980,00']]],
                                    ['label' => '7 · CONTRATOS', 'color' => '#ea580c', 'count' => 2, 'cards' => [['name' => 'Locadora Prime S/A', 'value' => 'R$ 1.140,00']]],
                                ] as $column)
                                    <div class="w-32 shrink-0">
                                        <div class="rounded-t-lg px-2.5 py-1.5 text-[10px] font-bold text-white flex items-center justify-between" style="background: {{ $column['color'] }}">
                                            <span class="truncate">{{ $column['label'] }}</span>
                                            <span class="opacity-80">{{ $column['count'] }}</span>
                                        </div>
                                        <div class="border border-t-0 border-slate-200 rounded-b-lg bg-slate-50 p-1.5 space-y-1.5 h-44 overflow-hidden">
                                            @foreach ($column['cards'] as $card)
                                                <div class="rounded-md bg-white border border-slate-200 p-2 shadow-sm">
                                                    <p class="text-[10px] font-semibold text-slate-700 leading-tight truncate">{{ $card['name'] }}</p>
                                                    <p class="text-[9px] text-slate-400 mt-1">{{ $card['value'] }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mockups: Agenda + acesso por parceiro --}}
            <div class="grid lg:grid-cols-5 gap-6 mt-6">
                <div class="lg:col-span-3 rounded-2xl border border-slate-200 shadow-lg shadow-slate-900/5 overflow-hidden bg-white">
                    <div class="bg-gradient-to-r from-brand-700 to-brand-500 px-5 py-3 flex items-center justify-between">
                        <p class="text-white font-semibold text-xs sm:text-sm">Agenda · Setembro 2026</p>
                        <span class="text-brand-100 text-[10px]">Compromissos e eventos</span>
                    </div>
                    <div class="grid grid-cols-7 text-center text-[10px] p-3 gap-1">
                        @foreach (['D', 'S', 'T', 'Q', 'Q', 'S', 'S'] as $d)
                            <span class="text-slate-400 font-semibold pb-1">{{ $d }}</span>
                        @endforeach
                        @for ($i = 1; $i <= 28; $i++)
                            <span @class([
                                'rounded-md py-1.5',
                                'bg-brand-600 text-white font-bold' => $i === 3,
                                'text-slate-500' => $i !== 3,
                            ])>{{ $i }}</span>
                        @endfor
                    </div>
                </div>
                <div class="lg:col-span-2 rounded-2xl border border-slate-200 shadow-lg shadow-slate-900/5 overflow-hidden bg-brand-950 p-6 flex flex-col justify-center">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-accent-400 to-brand-500 mb-4">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                    </span>
                    <h3 class="font-semibold text-white text-sm mb-2">Acesso seguro por parceiro</h3>
                    <p class="text-brand-200 text-xs">
                        Login white-label por CNPJ parceiro e empresa, com senha própria para cada usuário — cada
                        cliente Databit acessa o seu ambiente, com a sua identidade.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Sua equipe merece vender com mais inteligência.</h2>
                <p class="text-brand-100 mt-2">
                    Centraliza histórico, automatiza follow-ups e mostra com clareza onde cada negociação está.
                </p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero agendar uma demonstração do DataClient CRM.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Agendar demonstração gratuita
            </a>
        </div>
    </section>

    {{-- Funcionalidades --}}
    <section id="funcionalidades" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Funcionalidades
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Tudo que sua equipe comercial precisa.</h2>
                <p class="text-slate-500 mt-3">
                    O DataClient reúne em uma única plataforma web todas as ferramentas para organizar, acompanhar e
                    fechar mais vendas.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'title' => 'Gestão de usuários e permissões', 'desc' => 'Controle de acesso granular para vendedores, gerentes e administradores com perfis personalizáveis.'],
                    ['icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z', 'title' => 'Dashboards e métricas', 'desc' => 'Acompanhamento em tempo real do funil de vendas, taxa de conversão, ranking de vendedores e metas.'],
                    ['icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25', 'title' => 'Gestão de oportunidades', 'desc' => 'Visão Kanban e lista para fácil manipulação de status, temperatura de negociação e follow-up.'],
                    ['icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', 'title' => 'Agenda e compromissos', 'desc' => 'Visão de agenda integrada para gerenciar reuniões, ligações e atividades da equipe comercial.'],
                    ['icon' => 'M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46', 'title' => 'Campanhas de marketing', 'desc' => 'Recursos de campanhas por e-mail e WhatsApp para nutrição de leads e reativação de clientes.'],
                    ['icon' => 'M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5', 'title' => 'Múltiplos funis de venda', 'desc' => 'Configure quantos funis precisar, com etapas, critérios e responsáveis específicos para cada produto ou segmento.'],
                    ['icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'title' => 'Propostas personalizadas', 'desc' => 'Elaboração e envio de propostas comerciais diretamente pelo sistema, com controle de versões e aprovação.'],
                    ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'title' => 'Pós-venda integrado', 'desc' => 'Fluxo parametrizável de aprovação, geração de contrato e acompanhamento do pós-venda até a entrega.'],
                    ['icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21M3 9l9-6 9 6v9.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V9z', 'title' => 'Integração com o DataClassic', 'desc' => 'Transforme pré-contratos em pedidos no ERP automaticamente e acompanhe o que foi fechado e entregue.'],
                    ['icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'title' => 'Gestão de documentos', 'desc' => 'Anexo de documentos em cada processo comercial, com histórico completo e rastreabilidade.'],
                    ['icon' => 'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42', 'title' => 'Personalização completa', 'desc' => 'Filtros, layouts e campos personalizáveis para que o sistema se adapte ao seu processo, não o contrário.'],
                    ['icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Processos perdidos com motivos', 'desc' => 'Registre e analise motivos de perda para identificar padrões e melhorar continuamente a abordagem comercial.'],
                ] as $feature)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-500 text-white mb-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}" /></svg>
                        </span>
                        <h3 class="font-semibold text-slate-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Pronto para transformar sua operação comercial?</h2>
            <p class="text-brand-200 mt-3 max-w-2xl mx-auto">
                Fale com um especialista Databit e descubra como o DataClient pode funcionar para o seu negócio.
                Demonstração gratuita e sem compromisso.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero falar sobre o DataClient CRM.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                    Falar pelo WhatsApp
                </a>
                <a href="mailto:comercial@databit.com.br" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                    Enviar e-mail
                </a>
            </div>
        </div>
    </section>
@endsection
