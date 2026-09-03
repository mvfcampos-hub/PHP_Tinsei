@extends('layouts.app')

@section('title', 'DataService — Portal de gestão completa da assistência técnica')
@section('description', 'DataService: portal de gestão de assistência técnica com abertura e acompanhamento de OS e requisições, consultas fiscais e financeiras, roteirização e monitoramento de SLA em tempo real. Integrado ao DataMobile e ao DataClassic, ou de forma independente.')
@section('canonical', route('dataservice.show'))

@push('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => 'DataService',
            'description' => 'Portal de gestão completa da assistência técnica, com abertura e acompanhamento de OS e requisições, consultas fiscais e financeiras, roteirização e monitoramento de SLA em tempo real.',
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'brand' => ['@type' => 'Brand', 'name' => 'Databit'],
            'url' => route('dataservice.show'),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <x-brand-mark class="hidden lg:block absolute -right-8 -top-10 h-36 w-auto opacity-[0.08] pointer-events-none select-none" aria-hidden="true" />
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24 text-center relative">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-5 tracking-wide uppercase">
                DataService · Portal de Assistência Técnica
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
                Gestão completa da sua assistência técnica, <span class="text-accent-400">do chamado à conclusão</span>
            </h1>
            <p class="text-brand-200 mt-5 max-w-2xl mx-auto text-lg">
                Abertura e acompanhamento de OS e requisições, consultas fiscais e financeiras, roteirização e
                monitoramento de SLA em tempo real — integrado ao DataMobile e ao DataClassic, ou de forma
                independente, com o ERP que sua empresa já usa.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero conhecer o DataService.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                    Quero conhecer o DataService
                </a>
                <a href="#interface" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                    Ver a interface
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ([
                ['icon' => 'M13.5 4.938a7 7 0 11-9.006 1.482l-.291-.29c-.418-.418-1.09-.418-1.508 0m10.805-1.192L14 4.938V6M8.128 4.938l1.404.938M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'value' => 'DataMobile', 'label' => 'Integração nativa'],
                ['icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21M3 9l9-6 9 6v9.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V9z', 'value' => 'DataClassic', 'label' => 'Integração nativa'],
                ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'value' => 'Independente', 'label' => 'Funciona com outro ERP'],
                ['icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'value' => 'Tempo real', 'label' => 'SLA e localização ao vivo'],
            ] as $stat)
                <div class="rounded-2xl bg-white border border-slate-200 shadow-lg shadow-slate-900/5 p-5 text-center">
                    <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-accent-50 text-accent-600 mb-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" /></svg>
                    </span>
                    <p class="font-bold text-slate-900 text-lg">{{ $stat['value'] }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Perfil Cliente --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Perfil Cliente
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Autonomia para o cliente, sem depender do telefone.</h2>
                <p class="text-slate-500 mt-3">
                    Seu cliente abre, acompanha e resolve boa parte das demandas sozinho, com total visibilidade do
                    que está acontecendo.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['icon' => 'M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 15.375c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z', 'title' => 'Abertura de OS', 'desc' => 'Abertura de ordem de serviço lendo o QR Code do equipamento ou informando patrimônio ou serial.'],
                    ['icon' => 'M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z', 'title' => 'Acompanhamento de OS', 'desc' => 'Acompanhe a evolução do atendimento, visualizando cada fase do workflow desenhado até a conclusão.'],
                    ['icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'title' => 'Requisição de suprimentos', 'desc' => 'Abertura de requisição lendo o QR Code do equipamento ou informando patrimônio ou serial.'],
                    ['icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'title' => 'Acompanhamento de requisições', 'desc' => 'Acompanhe a evolução da requisição, visualizando cada fase do workflow desenhado até a entrega.'],
                    ['icon' => 'M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32', 'title' => 'Anexos no chamado', 'desc' => 'Recursos de anexo de fotos, documentos e vídeos, tanto em ordens de serviço quanto em requisições.'],
                    ['icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'title' => 'Consulta de documentos fiscais', 'desc' => 'Visualize todos os documentos fiscais emitidos contra o cliente, com download do XML e do DANFE.'],
                    ['icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z', 'title' => 'Consulta financeira', 'desc' => 'Visualize títulos pagos, vencidos e a vencer, com baixa da segunda via ou atualização do boleto.'],
                    ['icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z', 'title' => 'Dashboards personalizados', 'desc' => 'Painéis que podem ser personalizados para o cliente, com SLA e acompanhamento de pendências e concluídas.'],
                ] as $feature)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}" /></svg>
                        </span>
                        <h3 class="font-semibold text-slate-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Perfil Empresa --}}
    <section class="bg-slate-50 border-y border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-50 text-accent-700 px-3 py-1 text-xs font-semibold mb-4">
                    Perfil Empresa
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Além de tudo isso, o controle completo da operação.</h2>
                <p class="text-slate-500 mt-3">
                    A empresa tem acesso a todos os recursos do perfil cliente, além da gestão ponta a ponta do
                    atendimento técnico.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="rounded-2xl bg-white border border-slate-200 p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-50 text-accent-600 mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2">Gestão completa dos chamados</h3>
                    <p class="text-sm text-slate-500">Gestão de chamados, atendimento, roteirização, evolução e conclusão em um único painel.</p>
                </div>
                <div class="rounded-2xl bg-white border border-slate-200 p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-50 text-accent-600 mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2">Roteirização de chamados</h3>
                    <p class="text-sm text-slate-500">Módulo para roteirização dos chamados por região, técnicos, modelos de equipamento e disponibilidade.</p>
                </div>
                <div class="rounded-2xl bg-white border border-slate-200 p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-50 text-accent-600 mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2">Localização dos técnicos em tempo real</h3>
                    <p class="text-sm text-slate-500">Módulo visual para acompanhar a localização das equipes em campo (requer o app DataMobile).</p>
                </div>
                <div class="rounded-2xl bg-white border border-slate-200 p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-50 text-accent-600 mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2">Monitoramento de SLA</h3>
                    <p class="text-sm text-slate-500">Acompanhamento eficiente das demandas pendentes, por técnico, status, cidade e cliente.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Interface real --}}
    <section id="interface" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Interface real
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Veja o DataService por dentro.</h2>
                <p class="text-slate-500 mt-3">
                    Roteirização visual, monitoramento de SLA com indicadores e localização das equipes em tempo
                    real — tudo em um só lugar.
                </p>
            </div>

            {{-- Mockup: Roteirização --}}
            <div class="rounded-2xl border border-slate-200 shadow-2xl shadow-slate-900/10 overflow-hidden bg-white">
                <div class="flex items-center gap-1.5 bg-slate-100 border-b border-slate-200 px-4 py-3">
                    <span class="h-3 w-3 rounded-full bg-red-400"></span>
                    <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                    <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                    <span class="ml-3 text-xs text-slate-400 font-medium truncate">app.dataservice.com.br/roteirizacao</span>
                </div>
                <div class="bg-gradient-to-r from-accent-700 to-accent-500 px-6 py-5">
                    <p class="text-white font-bold text-sm sm:text-base">Controle de Roteirização</p>
                    <p class="text-accent-50 text-xs mt-0.5">Organize rotas, atendimentos e deslocamentos das equipes.</p>
                </div>
                <div class="grid sm:grid-cols-2 gap-4 p-4">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-xs font-bold text-slate-500 mb-2">OS Disponíveis <span class="ml-1 rounded-full bg-slate-200 px-1.5 py-0.5 text-[10px]">68</span></p>
                        <div class="space-y-2">
                            @foreach ([
                                ['id' => '084878', 'cliente' => 'Prefeitura Municipal Exemplo', 'cidade' => 'Cidade Alfa', 'status' => 'FINALIZADO TÉCNICO'],
                                ['id' => '084896', 'cliente' => 'Consultoria e Planejamento Beta', 'cidade' => 'Cidade Beta', 'status' => 'ENCAMINHADO TERCEIRO'],
                            ] as $os)
                                <div class="rounded-lg bg-white border border-slate-200 p-2.5">
                                    <p class="text-[11px] font-bold text-slate-700">{{ $os['id'] }} <span class="text-red-500">●</span></p>
                                    <p class="text-[11px] text-slate-600 truncate">{{ $os['cliente'] }} · {{ $os['cidade'] }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $os['status'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="rounded-xl border border-accent-200 bg-accent-50/40 p-3">
                        <p class="text-xs font-bold text-accent-700 mb-2">OS Técnico: JOÃO SILVA</p>
                        <div class="space-y-2">
                            @foreach ([
                                ['id' => '084729', 'cliente' => 'Indústria e Comércio Exemplo Ltda', 'cidade' => 'Cidade Gama'],
                                ['id' => '084802', 'cliente' => 'Distribuidora Modelo Ltda', 'cidade' => 'Cidade Delta'],
                            ] as $os)
                                <div class="rounded-lg bg-white border border-accent-200 p-2.5">
                                    <p class="text-[11px] font-bold text-slate-700">{{ $os['id'] }} <span class="text-red-500">●</span></p>
                                    <p class="text-[11px] text-slate-600 truncate">{{ $os['cliente'] }} · {{ $os['cidade'] }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">ENCAMINHADO TÉCNICO</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mockups: SLA + Mapa --}}
            <div class="grid lg:grid-cols-5 gap-6 mt-6">
                <div class="lg:col-span-3 rounded-2xl border border-slate-200 shadow-lg shadow-slate-900/5 overflow-hidden bg-white">
                    <div class="bg-gradient-to-r from-emerald-700 to-emerald-500 px-5 py-3">
                        <p class="text-white font-semibold text-xs sm:text-sm">Monitoramento de SLA</p>
                        <p class="text-emerald-50 text-[10px] mt-0.5">Acompanhe operações, equipes e ocorrências em tempo real.</p>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-3">
                            @foreach ([
                                ['label' => 'Técnico', 'rows' => [['JOÃO SILVA', 70], ['CARLOS SOUZA', 55], ['ANA PEREIRA', 40]]],
                                ['label' => 'Status', 'rows' => [['ENCAMINHADO TÉCNICO', 90], ['FINALIZADO TÉCNICO', 60], ['EM ATENDIMENTO', 20]]],
                            ] as $chart)
                                <div class="rounded-lg border border-slate-200 p-3">
                                    <p class="text-[10px] font-bold text-slate-500 mb-2 uppercase">{{ $chart['label'] }}</p>
                                    <div class="space-y-1.5">
                                        @foreach ($chart['rows'] as [$label, $pct])
                                            <div>
                                                <p class="text-[9px] text-slate-500 truncate">{{ $label }}</p>
                                                <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                                    <div class="h-full rounded-full bg-emerald-500" style="width: {{ $pct }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[10px] text-slate-400 mt-3 text-right">Total de OS monitoradas: 252</p>
                    </div>
                </div>
                <div class="lg:col-span-2 rounded-2xl border border-slate-200 shadow-lg shadow-slate-900/5 overflow-hidden bg-white">
                    <div class="bg-gradient-to-r from-emerald-700 to-emerald-500 px-5 py-3">
                        <p class="text-white font-semibold text-xs sm:text-sm">Monitoramento Técnico</p>
                        <p class="text-emerald-50 text-[10px] mt-0.5">Localização das equipes em tempo real.</p>
                    </div>
                    <div class="relative h-40 bg-gradient-to-br from-emerald-100 via-slate-100 to-sky-100 overflow-hidden">
                        @foreach ([['top' => '30%', 'left' => '25%'], ['top' => '55%', 'left' => '55%'], ['top' => '40%', 'left' => '75%'], ['top' => '70%', 'left' => '35%']] as $pin)
                            <span class="absolute h-3 w-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-emerald-500 ring-4 ring-emerald-500/25" style="top: {{ $pin['top'] }}; left: {{ $pin['left'] }};"></span>
                        @endforeach
                    </div>
                    <div class="p-3 text-[10px] text-slate-500 border-t border-slate-100">53 técnicos ativos em campo agora</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Destaques --}}
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                    Destaques
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Uma ferramenta poderosa, com ou sem o DataClassic.</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'M13.5 4.938a7 7 0 11-9.006 1.482l-.291-.29c-.418-.418-1.09-.418-1.508 0m10.805-1.192L14 4.938V6M8.128 4.938l1.404.938M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Integração com o DataMobile', 'desc' => 'Roteirização e localização das equipes em campo em tempo real, direto do app.'],
                    ['icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21M3 9l9-6 9 6v9.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V9z', 'title' => 'Integração com o ERP DataClassic', 'desc' => 'Chamados, requisições e documentos fiscais e financeiros direto do ERP, sem retrabalho.'],
                    ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'title' => 'Funcionalidade independente', 'desc' => 'Para quem usa outro ERP, o DataService funciona de forma independente, sem depender do DataClassic.'],
                    ['icon' => 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085', 'title' => 'Mais eficiência na gestão técnica', 'desc' => 'Aumente a eficiência da gestão do atendimento técnico com uma ferramenta poderosa e visual.'],
                    ['icon' => 'M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Melhor experiência para o cliente', 'desc' => 'Solicitação de demandas e acompanhamento com facilidade, sem depender de telefone ou e-mail.'],
                ] as $item)
                    <div class="rounded-2xl bg-white/5 border border-white/15 p-6">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-500/20 text-accent-300 mb-4">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" /></svg>
                        </span>
                        <h3 class="font-semibold text-white mb-2">{{ $item['title'] }}</h3>
                        <p class="text-sm text-brand-200">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-accent-600">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Pronto para elevar a gestão da sua assistência técnica?</h2>
                <p class="text-accent-50 mt-2">
                    Fale com um especialista Databit e veja o DataService funcionando com a sua operação.
                </p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero agendar uma demonstração do DataService.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-accent-700 hover:bg-accent-50 transition">
                Agendar demonstração gratuita
            </a>
        </div>
    </section>
@endsection
