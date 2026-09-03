@extends('layouts.app')

@section('title', 'DataBackup+ — Backup em nuvem para VMs, servidores e Microsoft 365')
@section('description', 'DataBackup+: app e espaço em nuvem para backup de máquinas virtuais, bancos de dados, Microsoft 365 e servidores físicos, com criptografia, retenção configurável e suporte especializado. Parceria com Comet Backup.')
@section('canonical', route('databackup.show'))

@section('content')
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <x-brand-mark class="hidden lg:block absolute -right-8 -top-10 h-36 w-auto opacity-[0.08] pointer-events-none select-none" aria-hidden="true" />
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24 text-center relative">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-5 tracking-wide uppercase">
                DataBackup+
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
                Backup completo, na nuvem, <span class="text-accent-400">com o suporte que sua empresa precisa</span>
            </h1>
            <p class="text-brand-200 mt-5 max-w-2xl mx-auto text-lg">
                App e espaço em nuvem para proteger o que a sua empresa não pode perder: máquinas virtuais, bancos de dados,
                Microsoft 365, servidores físicos e muito mais. Backup automático, criptografado e testado — com a equipe
                Databit cuidando de tudo.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
                <a href="#planos" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                    Ver planos e preços
                </a>
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero saber mais sobre o DataBackup+.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                    Falar com um especialista
                </a>
            </div>
            <p class="text-xs text-brand-300 mt-6">Tecnologia em parceria com <strong class="text-brand-100">Comet Backup</strong> — usada por provedores de TI no mundo todo.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ([
                ['icon' => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z', 'label' => 'Criptografia de ponta a ponta', 'desc' => 'Dados protegidos em trânsito e em repouso (AES-256)'],
                ['icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99', 'label' => 'Backup automático diário', 'desc' => 'Agendamento sem depender de ninguém apertar um botão'],
                ['icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'label' => 'Parceria Comet Backup', 'desc' => 'Tecnologia usada por MSPs no mundo todo'],
                ['icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'label' => 'Suporte especializado', 'desc' => 'Time Databit acompanhando testes de restauração'],
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
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">O que o DataBackup+ protege</h2>
                <p class="text-slate-500 mt-3">Uma única solução para todas as fontes de dados críticas da sua empresa.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125', 'title' => 'Máquinas Virtuais', 'desc' => 'VMware, Hyper-V e Proxmox — backup em nível de imagem, com restauração rápida do ambiente inteiro.'],
                    ['icon' => 'M21.75 17.25v-.228a4.5 4.5 0 00-.12-1.03l-2.268-9.64a3.375 3.375 0 00-3.285-2.602H7.923a3.375 3.375 0 00-3.285 2.602l-2.268 9.64a4.5 4.5 0 00-.12 1.03v.228m19.5 0a3 3 0 01-3 3H5.25a3 3 0 01-3-3m19.5 0a3 3 0 00-3-3H5.25a3 3 0 00-3 3m16.5 0h.008v.008h-.008v-.008zm-3 0h.008v.008h-.008v-.008z', 'title' => 'Servidores Físicos', 'desc' => 'Windows e Linux, com backup completo do sistema ou de pastas e volumes específicos.'],
                    ['icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125', 'title' => 'Bancos de Dados', 'desc' => 'SQL Server e MySQL, com backup consistente mesmo em bancos ativos, sem parar a operação.'],
                    ['icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75', 'title' => 'Microsoft 365', 'desc' => 'E-mail (Exchange Online), OneDrive, SharePoint e Teams — protegidos contra exclusão acidental e ataques.'],
                    ['icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25', 'title' => 'Estações de Trabalho', 'desc' => 'Notebooks e desktops da equipe, com backup silencioso em segundo plano.'],
                    ['icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'title' => 'NAS e Armazenamento', 'desc' => 'Dispositivos NAS (Synology e similares) com sincronização programada para a nuvem.'],
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

    <section id="planos" class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Planos DataBackup+</h2>
                <p class="text-brand-200 mt-3">Preços competitivos para o mercado brasileiro, por espaço de armazenamento. Precisa de mais? Dimensionamos caso a caso.</p>
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
                        <x-backup-plan-card :plan="$plan" />
                    @endforeach
                </div>
            @endif
            <p class="text-center text-brand-200 text-sm mt-8">
                <strong class="text-white">Precisa de mais que 2 TB ou de um SLA dedicado?</strong>
                Fale com a gente para uma proposta sob medida.
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Preciso de um plano de backup sob medida.') }}" target="_blank" rel="noopener" class="font-semibold text-accent-300 hover:text-accent-200">
                    Falar com o especialista →
                </a>
            </p>
        </div>
    </section>

    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Como funciona</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['step' => '1', 'title' => 'Instalação do agente', 'desc' => 'Instalamos o software de backup (Comet Backup) em cada VM, servidor, estação ou conta Microsoft 365 a proteger.'],
                    ['step' => '2', 'title' => 'Agendamento automático', 'desc' => 'Configuramos a rotina de backup ideal para o seu ambiente, sem depender de ninguém iniciar manualmente.'],
                    ['step' => '3', 'title' => 'Envio criptografado', 'desc' => 'Os dados são compactados, criptografados e enviados para o armazenamento em nuvem do seu plano.'],
                    ['step' => '4', 'title' => 'Testes de restauração', 'desc' => 'Nossa equipe testa periodicamente a restauração, para garantir que o backup funciona quando você mais precisar.'],
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

    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                    Parceria de tecnologia
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Por trás do DataBackup+: <span class="text-accent-400">Comet Backup</span></h2>
                <p class="text-brand-200 mt-4">
                    O DataBackup+ é operado pela equipe Databit sobre a plataforma da <strong class="text-white">Comet Backup</strong>,
                    uma das soluções de backup mais usadas por provedores de TI e MSPs no mundo — com criptografia forte,
                    infraestrutura de nuvem robusta e suporte a praticamente qualquer fonte de dados.
                </p>
                <ul class="space-y-3 mt-6">
                    @foreach ([
                        'Criptografia AES-256 de ponta a ponta, com chave que só a sua empresa controla',
                        'Backup incremental: só envia o que mudou, economizando tempo e banda',
                        'Restauração granular — de um arquivo até o ambiente completo',
                        'Retenção configurável, com proteção contra ransomware (versões imutáveis)',
                    ] as $item)
                        <li class="flex items-start gap-3 text-brand-100 text-sm">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-accent-500 text-white mt-0.5">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-2xl bg-white/5 border border-white/15 p-6 sm:p-8">
                <h3 class="text-accent-400 font-semibold uppercase text-sm tracking-wide mb-5">Suporte especializado Databit</h3>
                <p class="text-brand-100 text-sm leading-relaxed">
                    Diferente de contratar uma ferramenta de backup sozinho, com o DataBackup+ você tem a equipe Databit
                    cuidando de toda a configuração, monitoramento e testes de restauração — a mesma equipe que já
                    conhece o seu ambiente pelo DataClassic, DataCloud ou Databit MSP.
                </p>
                <dl class="divide-y divide-white/10 mt-6">
                    @foreach ([
                        'Monitoramento' => 'Diário',
                        'Alertas de falha' => 'Automáticos',
                        'Testes de restauração' => 'Periódicos',
                        'Suporte' => 'Em português',
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

    <section class="bg-slate-50">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Perguntas frequentes</h2>
            </div>
            <div class="space-y-3" x-data="{ open: null }">
                @foreach ([
                    ['q' => 'O DataBackup+ substitui o backup que já tenho?', 'a' => 'Pode complementar ou substituir, dependendo do seu cenário. Avaliamos o que você já tem e propomos a melhor forma de migrar para o DataBackup+ sem deixar sua empresa desprotegida durante a transição.'],
                    ['q' => 'Como funciona a cobrança quando eu me aproximo do limite do plano?', 'a' => 'Avisamos com antecedência quando o uso se aproxima do limite contratado e ajudamos você a migrar para o plano seguinte, sem interrupção do backup.'],
                    ['q' => 'Vocês testam se o backup realmente funciona?', 'a' => 'Sim. Testes de restauração são parte do serviço — um backup nunca testado é uma falsa sensação de segurança, por isso validamos periodicamente que os dados podem ser recuperados.'],
                    ['q' => 'O DataBackup+ protege contra ransomware?', 'a' => 'Sim. Além da criptografia, oferecemos retenção com versões imutáveis, que não podem ser alteradas ou apagadas por um ataque — mesmo que o ambiente de origem seja comprometido.'],
                    ['q' => 'Preciso ter o Databit MSP contratado para ter o DataBackup+?', 'a' => 'Não, o DataBackup+ pode ser contratado de forma independente. Ele também está disponível como add-on para clientes do Databit MSP.'],
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
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Sua empresa está a um incidente de perder tudo?</h2>
                <p class="text-brand-100 mt-2">Fale com a gente e coloque o DataBackup+ para proteger o que importa.</p>
            </div>
            <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero contratar o DataBackup+.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com o especialista
            </a>
        </div>
    </section>
@endsection
