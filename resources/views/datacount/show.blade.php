@extends('layouts.app')

@section('title', 'DataCount — Monitoramento de ativos de impressão e notebooks')
@section('description', 'DataCount: monitoramento de impressoras, multifuncionais e notebooks em tempo real. Nível de suprimentos, alertas preditivos, histórico de trocas de toner e medidores para faturamento — 100% integrado ao ERP DataClassic.')
@section('canonical', route('datacount.show'))

@push('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => 'DataCount',
            'description' => 'Monitoramento de ativos de impressão e notebooks: gestão do parque de equipamentos, controle de nível de suprimentos, alertas e medidores para faturamento.',
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'brand' => ['@type' => 'Brand', 'name' => 'Databit'],
            'url' => route('datacount.show'),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <x-brand-mark class="hidden lg:block absolute -right-8 -top-10 h-36 w-auto opacity-[0.08] pointer-events-none select-none" aria-hidden="true" />
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24 text-center relative">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-500/15 text-rose-300 px-3 py-1 text-xs font-semibold mb-5 tracking-wide uppercase">
                DataCount · Monitoramento de Impressão e Notebooks
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
                Monitoramento completo, <span class="text-rose-400">gestão eficiente</span>
            </h1>
            <p class="text-brand-200 mt-5 max-w-2xl mx-auto text-lg">
                Gestão e monitoramento do parque de impressoras, multifuncionais e notebooks em tempo real — nível de
                suprimentos, alertas, histórico de trocas e medidores para faturamento, 100% integrado ao ERP
                DataClassic.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero conhecer o DataCount.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-rose-500 px-6 py-3 text-sm font-semibold text-white hover:bg-rose-600 transition">
                    Quero conhecer o DataCount
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
                ['icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'value' => 'Tempo real', 'label' => 'Status de cada equipamento'],
                ['icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375', 'value' => 'CMYK', 'label' => 'Nível de suprimentos por cor'],
                ['icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', 'value' => 'Preditivo', 'label' => 'Alertas antes da falta'],
                ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'value' => '100%', 'label' => 'Integrado ao DataClassic'],
            ] as $stat)
                <div class="rounded-2xl bg-white border border-slate-200 shadow-lg shadow-slate-900/5 p-5 text-center">
                    <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-600 mb-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" /></svg>
                    </span>
                    <p class="font-bold text-slate-900 text-lg">{{ $stat['value'] }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Funcionalidades --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Funcionalidades
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Todo o parque de equipamentos, sob controle.</h2>
                <p class="text-slate-500 mt-3">Do nível de toner ao faturamento, sem planilhas paralelas e sem digitação manual.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['icon' => 'M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.017-1.837-2.185a48.554 48.554 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.017 1.837-2.185a48.554 48.554 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z', 'title' => 'Gestão de ativos de impressão', 'desc' => 'Monitoramento completo do parque de impressoras e multifuncionais, on-line ou off-line.'],
                    ['icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25', 'title' => 'Gestão de notebooks', 'desc' => 'Monitoramento também do parque de notebooks e estações de trabalho.'],
                    ['icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375', 'title' => 'Nível de suprimentos', 'desc' => 'Monitoramento do nível de toner (CMYK) e outros suprimentos de cada equipamento.'],
                    ['icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', 'title' => 'Alertas de equipamentos', 'desc' => 'Alertas automáticos sobre o estado, a operação e a necessidade de atenção de cada equipamento.'],
                    ['icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'title' => 'Histórico de trocas de toner', 'desc' => 'Registro completo de cada troca de suprimento por equipamento, serial e data.'],
                    ['icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z', 'title' => 'Produção de páginas', 'desc' => 'Acompanhamento da produção mono e colorida de cada equipamento e do parque como um todo.'],
                    ['icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z', 'title' => 'Medidores para faturamento', 'desc' => 'Leitura dos medidores dos equipamentos para uso direto no faturamento dos contratos.'],
                    ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'title' => 'Integração nativa com o DataClassic', 'desc' => 'Contadores de faturamento importados automaticamente e requisição de suprimento gerada pelo nível monitorado.'],
                ] as $feature)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-rose-500 to-rose-400 text-white mb-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}" /></svg>
                        </span>
                        <h3 class="font-semibold text-slate-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Interface real --}}
    <section id="interface" class="bg-slate-50 border-y border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 text-rose-600 px-3 py-1 text-xs font-semibold mb-4">
                    Interface real
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Veja o DataCount por dentro.</h2>
                <p class="text-slate-500 mt-3">
                    Painel de monitoramento, histórico de trocas de suprimento e parque de equipamentos — tudo em
                    tempo real.
                </p>
            </div>

            {{-- Mockup: Painel de monitoramento --}}
            <div class="rounded-2xl border border-slate-200 shadow-2xl shadow-slate-900/10 overflow-hidden bg-white">
                <div class="flex items-center gap-1.5 bg-slate-100 border-b border-slate-200 px-4 py-3">
                    <span class="h-3 w-3 rounded-full bg-red-400"></span>
                    <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                    <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                    <span class="ml-3 text-xs text-slate-400 font-medium truncate">app.datacount.com.br/painel-revenda</span>
                </div>
                <div class="bg-gradient-to-r from-rose-700 to-rose-500 px-6 py-5">
                    <p class="text-white font-bold text-sm sm:text-base">Painel de Monitoramento</p>
                    <p class="text-rose-50 text-xs mt-0.5">Equipamentos monitorados, alertas e produção em tempo real.</p>
                </div>
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                        @foreach ([
                            ['label' => 'Total', 'value' => '1.240', 'color' => 'bg-blue-600'],
                            ['label' => 'Online', 'value' => '980', 'color' => 'bg-teal-600'],
                            ['label' => 'Atenção', 'value' => '180', 'color' => 'bg-amber-500'],
                            ['label' => 'Alertas', 'value' => '25', 'color' => 'bg-red-600'],
                            ['label' => 'Offline', 'value' => '55', 'color' => 'bg-slate-500'],
                        ] as $card)
                            <div class="rounded-lg {{ $card['color'] }} text-white p-3 text-center">
                                <p class="text-[10px] font-semibold uppercase opacity-90">{{ $card['label'] }}</p>
                                <p class="text-lg font-bold mt-1">{{ $card['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="rounded-lg border border-slate-200 p-3">
                            <p class="text-[10px] font-bold text-slate-500 uppercase mb-2">Suprimentos a terminar em 30 dias</p>
                            <div class="grid grid-cols-4 gap-2 text-center">
                                @foreach ([['label' => 'Amarelo', 'value' => 24, 'color' => 'bg-amber-400'], ['label' => 'Magenta', 'value' => 22, 'color' => 'bg-pink-500'], ['label' => 'Ciano', 'value' => 21, 'color' => 'bg-sky-500'], ['label' => 'Preto', 'value' => 98, 'color' => 'bg-slate-800']] as $supply)
                                    <div class="rounded-md {{ $supply['color'] }} text-white py-2">
                                        <p class="text-sm font-bold">{{ $supply['value'] }}</p>
                                        <p class="text-[9px] opacity-90">{{ $supply['label'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="rounded-lg border border-slate-200 p-3">
                            <p class="text-[10px] font-bold text-slate-500 uppercase mb-2">Produção de páginas (mês atual)</p>
                            <div class="grid grid-cols-3 gap-2 text-center">
                                @foreach ([['label' => 'Mono', 'value' => '19.121'], ['label' => 'Color', 'value' => '2.412'], ['label' => 'Total', 'value' => '21.533']] as $prod)
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $prod['value'] }}</p>
                                        <p class="text-[9px] text-slate-400 uppercase">{{ $prod['label'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mockups: Trocas de toner + Parque de equipamentos --}}
            <div class="grid lg:grid-cols-2 gap-6 mt-6">
                <div class="rounded-2xl border border-slate-200 shadow-lg shadow-slate-900/5 overflow-hidden bg-white">
                    <div class="bg-gradient-to-r from-rose-700 to-rose-500 px-5 py-3">
                        <p class="text-white font-semibold text-xs sm:text-sm">Trocas de Toner</p>
                        <p class="text-rose-50 text-[10px] mt-0.5">Histórico de substituição de suprimentos.</p>
                    </div>
                    <div class="p-3 overflow-x-auto">
                        <table class="w-full text-[10px] min-w-[420px]">
                            <thead>
                                <tr class="text-slate-400 text-left">
                                    <th class="font-semibold pb-2">Nível</th>
                                    <th class="font-semibold pb-2">Data</th>
                                    <th class="font-semibold pb-2">Marca</th>
                                    <th class="font-semibold pb-2">Equipamento</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ([
                                    ['nivel' => 2, 'data' => '03/09', 'marca' => 'Konica Minolta', 'equip' => 'Bizhub C224e'],
                                    ['nivel' => 5, 'data' => '02/09', 'marca' => 'Kyocera', 'equip' => 'Ecosys M5526cdw'],
                                    ['nivel' => 3, 'data' => '28/08', 'marca' => 'Kyocera', 'equip' => 'Ecosys M3655idn'],
                                    ['nivel' => 6, 'data' => '19/08', 'marca' => 'Kyocera', 'equip' => 'Ecosys M2040dn'],
                                ] as $row)
                                    <tr>
                                        <td class="py-2"><span class="inline-block h-4 w-3 rounded-sm bg-slate-800 align-middle" style="opacity: {{ $row['nivel'] / 10 + 0.15 }}"></span> <span class="text-slate-500">{{ $row['nivel'] }}%</span></td>
                                        <td class="py-2 text-slate-600">{{ $row['data'] }}</td>
                                        <td class="py-2 text-slate-600">{{ $row['marca'] }}</td>
                                        <td class="py-2 text-slate-600">{{ $row['equip'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="rounded-2xl border border-slate-200 shadow-lg shadow-slate-900/5 overflow-hidden bg-white">
                    <div class="bg-gradient-to-r from-rose-700 to-rose-500 px-5 py-3">
                        <p class="text-white font-semibold text-xs sm:text-sm">Parque de Equipamentos</p>
                        <p class="text-rose-50 text-[10px] mt-0.5">Status e níveis de suprimento por equipamento.</p>
                    </div>
                    <div class="p-3 overflow-x-auto">
                        <table class="w-full text-[10px] min-w-[420px]">
                            <thead>
                                <tr class="text-slate-400 text-left">
                                    <th class="font-semibold pb-2">Status</th>
                                    <th class="font-semibold pb-2">Marca / Modelo</th>
                                    <th class="font-semibold pb-2">Cliente</th>
                                    <th class="font-semibold pb-2">Níveis</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ([
                                    ['status' => 'Pronta', 'color' => 'bg-emerald-500', 'marca' => 'Canon IR-ADV C5540', 'cliente' => 'Escritório Exemplo Ltda', 'niveis' => [83, 43, 29, 88]],
                                    ['status' => 'E-Saving', 'color' => 'bg-amber-500', 'marca' => 'Konica Minolta C224e', 'cliente' => 'Pecuária Modelo Ltda', 'niveis' => [6, 96, 23, 40]],
                                    ['status' => 'Pronta', 'color' => 'bg-emerald-500', 'marca' => 'Xerox VersaLink C405', 'cliente' => 'Distribuidora Central', 'niveis' => [53, 92, 85, 44]],
                                    ['status' => 'E-Saving', 'color' => 'bg-amber-500', 'marca' => 'Epson L1455', 'cliente' => 'Farmácia Popular Ltda', 'niveis' => [89, 89, 90, 87]],
                                ] as $row)
                                    <tr>
                                        <td class="py-2"><span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full {{ $row['color'] }}"></span>{{ $row['status'] }}</span></td>
                                        <td class="py-2 text-slate-600">{{ $row['marca'] }}</td>
                                        <td class="py-2 text-slate-600 truncate max-w-[110px]">{{ $row['cliente'] }}</td>
                                        <td class="py-2">
                                            <div class="flex gap-0.5">
                                                @foreach ($row['niveis'] as $i => $n)
                                                    <span class="h-3 w-1.5 rounded-sm" style="background: {{ [0 => '#0ea5e9', 1 => '#ec4899', 2 => '#eab308', 3 => '#1e293b'][$i] }}; opacity: {{ $n / 100 }}"></span>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Ecossistema Databit --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                Ecossistema Databit
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Contadores no ERP, sem digitar nada.</h2>
            <p class="text-slate-500 mt-3 max-w-2xl mx-auto">
                Os contadores de faturamento monitorados pelo DataCount são importados automaticamente para o
                <a href="{{ route('products.show', 'dataclassic') }}" class="text-brand-700 font-semibold hover:underline">DataClassic</a>,
                e a requisição de suprimento é gerada com base no nível monitorado — sem planilhas paralelas.
            </p>
        </div>
    </section>

    <section class="bg-rose-600">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Pronto para monitorar seu parque em tempo real?</h2>
                <p class="text-rose-50 mt-2">
                    Fale com um especialista Databit e veja o DataCount funcionando com o seu parque de equipamentos.
                </p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero agendar uma demonstração do DataCount.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-rose-700 hover:bg-rose-50 transition">
                Agendar demonstração gratuita
            </a>
        </div>
    </section>
@endsection
