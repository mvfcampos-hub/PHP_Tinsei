@extends('layouts.app')

@section('title', 'DataCloud — Máquinas Virtuais sob demanda')
@section('description', 'DataCloud: serviços cloud com VPS e máquinas virtuais sob demanda (Linux, Windows e SQL Server), dimensionadas para o seu projeto. Infraestrutura flexível e suporte próximo.')
@section('canonical', route('cloud.show'))

@section('content')
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24 text-center relative z-10">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-5 tracking-wide uppercase">
                DataCloud · Serviços Cloud
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
                VPS e máquinas virtuais <span class="text-accent-400">sob demanda</span> para o seu negócio
            </h1>
            <p class="text-brand-200 mt-5 max-w-2xl mx-auto text-lg">
                VMs com Linux, Windows e SQL Server, dimensionadas de acordo com a necessidade de cada cliente e projeto.
                Hardware, software e networking na medida certa — com o suporte próximo que só a Databit oferece.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
                <a href="#planos" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                    Ver planos e preços
                </a>
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero dimensionar uma VM sob medida no DataCloud.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                    Projeto sob medida
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ([
                ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'label' => 'Recursos sob demanda', 'desc' => 'Escale vCPU, RAM e disco conforme o projeto cresce'],
                ['icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25', 'label' => 'Linux e Windows', 'desc' => 'Ubuntu, Debian, CentOS, Windows Server e mais'],
                ['icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 3.75v3.75m-16.5-3.75v3.75', 'label' => 'SQL Server', 'desc' => 'Banco de dados licenciado e pronto para produção'],
                ['icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'label' => '+30 anos de mercado', 'desc' => 'Atendimento próximo e consultivo, do jeito Databit'],
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

    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Por que contratar o DataCloud?</h2>
                <p class="text-slate-500 mt-3">Infraestrutura flexível com quem entende do seu negócio. Você foca no seu fim, nós cuidamos da tecnologia.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.02-.397-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z', 'title' => 'Dimensionamento sob medida', 'desc' => 'Analisamos a necessidade de cada cliente e projeto para dimensionar software, hardware e networking na configuração ideal — sem desperdício de recursos.'],
                    ['icon' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418', 'title' => 'Ambiente isolado e seguro', 'desc' => 'Recursos dedicados à sua VM, com firewall, backup e políticas de segurança configuradas de acordo com o seu ambiente.'],
                    ['icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z', 'title' => 'Escalabilidade sem dor de cabeça', 'desc' => 'Comece pequeno e cresça quando precisar. Upgrade de vCPU, memória e disco sem migração complexa e sem surpresas na fatura.'],
                    ['icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.575 3.06a1.5 1.5 0 011.06-.44h12.729c.398 0 .78.158 1.06.44l1.902 1.902a3.003 3.003 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z', 'title' => 'Softwares prontos para uso', 'desc' => 'Entregamos a VM com o sistema operacional e os softwares que o seu projeto exige: Windows Server, SQL Server, servidores de aplicação e mais.'],
                    ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'title' => 'Suporte que resolve', 'desc' => 'Atendimento próximo, em português, por quem conhece o seu ambiente. Nada de protocolos intermináveis: você fala direto com o especialista.'],
                    ['icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Previsibilidade de custos', 'desc' => 'Mensalidade fixa em reais, sem variação cambial. Você sabe exatamente quanto vai pagar pela sua infraestrutura todo mês.'],
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
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                    DataCenter Tier III
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">A estrutura por trás do DataCloud</h2>
                <p class="text-brand-200 mt-3">
                    Suas máquinas virtuais rodam em um DataCenter certificado Tier III, com redundância de energia, refrigeração e conectividade.
                </p>
            </div>
            <div class="rounded-2xl overflow-hidden aspect-video bg-slate-950 shadow-xl border border-white/10">
                <iframe
                    src="https://www.youtube.com/embed/yjguXjBhoZE"
                    class="w-full h-full"
                    title="Estrutura do DataCenter certificado Tier III da Databit"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </section>

    <section id="planos" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Planos de Máquinas Virtuais</h2>
                <p class="text-slate-500 mt-3">Configurações padrão prontas para contratar. Precisa de algo diferente? Dimensionamos caso a caso.</p>
            </div>
            @if ($plans->isNotEmpty())
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
            @endif
            <p class="text-center text-slate-500 text-sm mt-8">
                <strong class="text-slate-800">Precisa de mais que 12 vCPU / 64 GB / 400 GB?</strong>
                Configurações acima dos planos padrão são tratadas caso a caso.
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Preciso de uma VM com configuração especial.') }}" target="_blank" rel="noopener" class="font-semibold text-brand-700 hover:text-brand-800">
                    Fale com o especialista →
                </a>
            </p>
        </div>
    </section>

    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Seu projeto, <span class="text-accent-400">sua configuração</span></h2>
                <p class="text-brand-200 mt-4">
                    Nenhum negócio é igual ao outro. Por isso, além dos planos padrão, montamos ambientes completos de acordo com a demanda do seu projeto:
                </p>
                <ul class="space-y-3 mt-6">
                    @foreach ([
                        'Servidores de aplicação e ERP (incluindo o DataClassic)',
                        'Bancos de dados SQL Server dimensionados para produção',
                        'Redes privadas, VPN e integração com o seu ambiente local',
                        'Ambientes de homologação, testes e contingência',
                        'Migração assistida do seu servidor físico para a nuvem',
                    ] as $item)
                        <li class="flex items-start gap-3 text-brand-100 text-sm">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-accent-500 text-white mt-0.5">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero um orçamento de ambiente cloud sob medida.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition mt-8">
                    Solicitar orçamento sob medida
                </a>
            </div>
            <div class="rounded-2xl bg-white/5 border border-white/15 p-6 sm:p-8">
                <h3 class="text-accent-400 font-semibold uppercase text-sm tracking-wide mb-5">Todos os planos incluem</h3>
                <dl class="divide-y divide-white/10">
                    @foreach ([
                        'Uptime garantido' => '99,9%',
                        'Suporte técnico' => 'Especializado',
                        'Painel de gerenciamento' => 'Incluso',
                        'Firewall' => 'Incluso',
                        'Snapshot inicial' => 'Incluso',
                        'Tráfego de rede' => 'Generoso*',
                        'Cobrança' => 'Mensal, em reais',
                    ] as $label => $value)
                        <div class="flex items-center justify-between py-3 text-sm">
                            <dt class="text-brand-200">{{ $label }}</dt>
                            <dd class="font-semibold text-white">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Recursos adicionais</h2>
                <p class="text-slate-500 mt-3">Personalize sua VM com licenças e recursos extras. Valores de referência — confirme as condições com nosso time.</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-brand-950 text-white">
                            <th class="px-5 py-3.5 text-left font-semibold uppercase text-xs tracking-wide">Adicional</th>
                            <th class="px-5 py-3.5 text-left font-semibold uppercase text-xs tracking-wide">Descrição</th>
                            <th class="px-5 py-3.5 text-left font-semibold uppercase text-xs tracking-wide">Valor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ([
                            ['name' => 'Windows Server', 'badge' => 'Licença', 'desc' => 'Licenciamento Windows Server por VM (Standard)', 'price' => 'a partir de R$ 79/mês'],
                            ['name' => 'SQL Server Web', 'badge' => 'Licença', 'desc' => 'Ideal para aplicações e sites com banco de dados', 'price' => 'a partir de R$ 129/mês'],
                            ['name' => 'SQL Server Standard', 'badge' => 'Licença', 'desc' => 'Para cargas de produção e ERPs — dimensionado por núcleo', 'price' => 'sob consulta'],
                            ['name' => 'Disco SSD adicional', 'badge' => null, 'desc' => 'Expansão de armazenamento em blocos de 50 GB', 'price' => 'R$ 0,35/GB/mês'],
                            ['name' => 'IP público adicional', 'badge' => null, 'desc' => 'Endereço IPv4 dedicado extra por VM', 'price' => 'R$ 10/mês'],
                            ['name' => 'Backup gerenciado', 'badge' => null, 'desc' => 'Cópias automáticas diárias com retenção configurável', 'price' => 'R$ 0,40/GB/mês'],
                            ['name' => 'Snapshot adicional', 'badge' => null, 'desc' => 'Pontos de restauração sob demanda', 'price' => 'R$ 0,30/GB/mês'],
                            ['name' => 'VPN / rede privada', 'badge' => null, 'desc' => 'Conexão segura entre a nuvem e o seu escritório', 'price' => 'sob consulta'],
                            ['name' => 'Monitoramento e gestão', 'badge' => null, 'desc' => 'Administração do servidor pela equipe Databit', 'price' => 'sob consulta'],
                        ] as $row)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-semibold text-slate-900 whitespace-nowrap">
                                    {{ $row['name'] }}
                                    @if ($row['badge'])
                                        <span class="ml-1.5 inline-flex items-center rounded-full bg-brand-50 text-brand-700 text-[11px] font-semibold px-2 py-0.5">{{ $row['badge'] }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-slate-500">{{ $row['desc'] }}</td>
                                <td class="px-5 py-4 font-semibold text-brand-700 whitespace-nowrap">{{ $row['price'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-center text-xs text-slate-400 mt-4">
                * Valores de referência para contratação mensal. Impostos e condições comerciais confirmados em proposta. Licenças Microsoft seguem a política de licenciamento vigente (SPLA).
            </p>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Perguntas frequentes</h2>
            </div>
            <div class="space-y-3" x-data="{ open: null }">
                @foreach ([
                    ['q' => 'Quais sistemas operacionais posso utilizar?', 'a' => 'Distribuições Linux (Ubuntu, Debian, CentOS/Rocky, entre outras) já inclusas no plano, e Windows Server com licenciamento adicional. Também avaliamos imagens customizadas conforme o projeto.'],
                    ['q' => 'Posso mudar de plano depois de contratar?', 'a' => 'Sim. O upgrade de vCPU, memória e disco é feito de forma programada, sem migração complexa. Se o seu projeto crescer além do plano Enterprise, montamos uma configuração exclusiva.'],
                    ['q' => 'Como funciona o licenciamento de Windows e SQL Server?', 'a' => 'As licenças são fornecidas no modelo de assinatura mensal (SPLA), dimensionadas conforme os núcleos da VM. Você não precisa comprar licenças perpétuas nem se preocupar com auditoria de licenciamento.'],
                    ['q' => 'Vocês migram meu servidor atual para a nuvem?', 'a' => 'Sim. Nossa equipe planeja e executa a migração do seu servidor físico ou de outro provedor para o DataCloud, com janela de manutenção combinada para minimizar impacto na operação.'],
                    ['q' => 'O DataCloud atende ao ERP DataClassic?', 'a' => 'Perfeitamente. Dimensionamos VMs otimizadas para o DataClassic e demais sistemas da Databit, com banco de dados, backup e acesso remoto configurados pela mesma equipe que conhece o sistema.'],
                    ['q' => 'Qual o prazo de ativação da VM?', 'a' => 'Planos padrão são ativados em até 1 dia útil após a confirmação da contratação. Ambientes sob medida seguem cronograma definido em proposta.'],
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
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Pronto para levar sua infraestrutura para a nuvem?</h2>
                <p class="text-brand-100 mt-2">Fale com nossos especialistas e receba o dimensionamento ideal para o seu projeto — sem compromisso.</p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero levar minha infraestrutura para o DataCloud.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Fale com o especialista
            </a>
        </div>
    </section>
@endsection
