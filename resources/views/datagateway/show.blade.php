@extends('layouts.app')

@section('title', 'DataGateway+ — Gestão avançada de rede e segurança de perímetro')
@section('description', 'DataGateway+: equipamento de rede fornecido em comodato, dimensionado para a sua empresa, com gestão completa de NAT, VPN, controle de conteúdo, análise de vulnerabilidades, monitoramento 24/7 e redundância/failover.')
@section('canonical', route('datagateway.show'))

@section('content')
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <x-brand-mark class="hidden lg:block absolute -right-8 -top-10 h-36 w-auto opacity-[0.08] pointer-events-none select-none" aria-hidden="true" />
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24 text-center relative">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-5 tracking-wide uppercase">
                DataGateway+
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
                Gestão avançada de rede e <span class="text-accent-400">segurança de perímetro</span>
            </h1>
            <p class="text-brand-200 mt-5 max-w-2xl mx-auto text-lg">
                Fornecemos o equipamento de rede em comodato, dimensionado sob medida para a sua empresa, e cuidamos
                de toda a gestão: regras de NAT, VPN, controle de conteúdo, análise de ataques e vulnerabilidades,
                monitoramento 24/7 e redundância com failover.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero saber mais sobre o DataGateway+.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                    Falar com um especialista
                </a>
                <a href="#o-que-inclui" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                    Ver o que está incluído
                </a>
            </div>
            <p class="text-xs text-brand-300 mt-6">Equipamento em comodato · Precificação sob consulta, conforme complexidade do ambiente</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ([
                ['icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0', 'label' => 'Equipamento em comodato', 'desc' => 'Sem investimento inicial em hardware — dimensionado para o seu ambiente'],
                ['icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z', 'label' => 'Monitoramento 24/7', 'desc' => 'Acompanhamento contínuo do perímetro de rede'],
                ['icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99', 'label' => 'Redundância e failover', 'desc' => 'Regras para manter a conexão da empresa ativa'],
                ['icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Dimensionamento sob medida', 'desc' => 'Equipamento e regras adequados à necessidade do seu ambiente'],
            ] as $stat)
                <div class="rounded-2xl bg-white border border-slate-200 shadow-lg shadow-slate-900/5 p-5 text-center">
                    <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" /></svg>
                    </span>
                    <p class="font-semibold text-slate-900 text-sm">{{ $stat['label'] }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $stat['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section id="o-que-inclui" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">O que está incluído no DataGateway+</h2>
                <p class="text-slate-500 mt-3">Do equipamento à gestão contínua, tudo em um único serviço.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0', 'title' => 'Equipamento em comodato', 'desc' => 'Fornecemos o equipamento de rede sem custo de aquisição, dimensionado de acordo com a necessidade real do seu ambiente — sem sobra nem gargalo.'],
                    ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'title' => 'Regras de NAT', 'desc' => 'Criação e manutenção de regras de NAT para publicar e proteger os serviços da sua rede corretamente.'],
                    ['icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'title' => 'Configuração e gestão de VPN', 'desc' => 'Túneis seguros site-to-site e client-to-site, com gestão contínua de acessos remotos.'],
                    ['icon' => 'M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z', 'title' => 'Controle de conteúdo', 'desc' => 'Regras de navegação e bloqueio de categorias e sites, adequadas à política da sua empresa.'],
                    ['icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', 'title' => 'Análise de ataques e vulnerabilidades', 'desc' => 'Identificação de tentativas de ataque e vulnerabilidades expostas no perímetro da rede.'],
                    ['icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z', 'title' => 'Monitoramento 24/7', 'desc' => 'Equipamento e conexões monitorados continuamente, com resposta rápida a qualquer anomalia.'],
                    ['icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99', 'title' => 'Redundância e failover', 'desc' => 'Regras de redundância entre links para manter a empresa online mesmo diante de uma falha de conexão.'],
                    ['icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'title' => 'Suporte especializado', 'desc' => 'Equipe Databit cuidando da configuração, ajustes e evolução das regras conforme a sua empresa cresce.'],
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

    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                    Como funciona
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Do diagnóstico ao monitoramento contínuo</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['step' => '1', 'title' => 'Diagnóstico e dimensionamento', 'desc' => 'Avaliamos o seu ambiente e dimensionamos o equipamento ideal para a necessidade da sua empresa.'],
                    ['step' => '2', 'title' => 'Instalação em comodato', 'desc' => 'O equipamento é instalado sem custo de aquisição, já configurado para o seu ambiente.'],
                    ['step' => '3', 'title' => 'Configuração das regras', 'desc' => 'NAT, VPN, controle de conteúdo, redundância e failover, ajustados à política da sua empresa.'],
                    ['step' => '4', 'title' => 'Monitoramento contínuo', 'desc' => 'Acompanhamento 24/7, com análise de ataques e vulnerabilidades e resposta rápida a incidentes.'],
                ] as $item)
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-accent-500 text-white font-bold text-sm mb-4">
                            {{ $item['step'] }}
                        </span>
                        <h3 class="font-semibold text-white mb-2">{{ $item['title'] }}</h3>
                        <p class="text-sm text-brand-200">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Perguntas frequentes</h2>
            </div>
            <div class="space-y-3" x-data="{ open: null }">
                @foreach ([
                    ['q' => 'Como funciona o comodato do equipamento?', 'a' => 'O equipamento de rede é fornecido pela Databit sem custo de aquisição, permanecendo em comodato enquanto o serviço estiver contratado. Dimensionamos o modelo ideal conforme o porte e a necessidade do seu ambiente.'],
                    ['q' => 'Preciso ter o Databit MSP contratado para ter o DataGateway+?', 'a' => 'Não, o DataGateway+ pode ser contratado de forma independente. Ele também está disponível como add-on para clientes do Databit MSP.'],
                    ['q' => 'O que acontece se o link principal cair?', 'a' => 'Configuramos regras de redundância e failover entre links, para que a sua empresa continue operando mesmo diante de uma instabilidade ou queda de conexão.'],
                    ['q' => 'Como funciona a análise de ataques e vulnerabilidades?', 'a' => 'Monitoramos continuamente o tráfego e os registros do equipamento para identificar tentativas de ataque e vulnerabilidades expostas, agindo rapidamente para mitigar riscos.'],
                    ['q' => 'A precificação é fixa?', 'a' => 'A precificação é sob consulta, pois varia conforme a complexidade do ambiente, o número de sites e o equipamento necessário. Fale com a nossa equipe para uma proposta sob medida.'],
                ] as $index => $item)
                    <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
                        <button
                            type="button"
                            @click="open = open === {{ $index }} ? null : {{ $index }}"
                            class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left"
                            :aria-expanded="open === {{ $index }}"
                        >
                            <span class="font-semibold text-slate-900">{{ $item['q'] }}</span>
                            <svg class="h-4 w-4 shrink-0 text-slate-400 transition" :class="{ 'rotate-180': open === {{ $index }} }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open === {{ $index }}" x-cloak x-transition class="px-5 pb-4 text-sm text-slate-600">
                            {{ $item['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Sua rede protegida, sem investir em equipamento.</h2>
                <p class="text-brand-100 mt-2">Fale com a gente e coloque o DataGateway+ para gerenciar o perímetro da sua empresa.</p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero contratar o DataGateway+.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com o especialista
            </a>
        </div>
    </section>
@endsection
