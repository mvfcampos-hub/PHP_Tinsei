@extends('layouts.app')

@section('title', 'Guia do Recém-Formado')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Guia do Recém-Formado</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Acabou de colar grau? Este guia visual reúne, em 3 etapas, o que você precisa saber para começar a atuar como nutricionista ou técnico(a) em nutrição e dietética com tranquilidade.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12 space-y-16">
        {{-- Etapa 1 --}}
        <div class="relative pl-14">
            <span class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-full bg-brand-700 text-white font-bold">1</span>
            <h2 class="text-xl font-bold text-slate-900 mb-2">Emita seu registro no CRN-9</h2>
            <p class="text-sm text-slate-600 mb-5">Sem inscrição ativa, você não pode exercer legalmente a profissão. O passo a passo é simples:</p>

            <ol class="space-y-4">
                <li class="flex gap-3 rounded-xl border border-slate-200 bg-white p-4">
                    <span class="shrink-0 flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">1</span>
                    <div>
                        <p class="text-sm font-medium text-slate-900">Ainda não colou grau ou tem só a declaração de conclusão?</p>
                        <p class="text-sm text-slate-600 mt-1">Solicite a <strong>Inscrição Provisória</strong> — válida por 2 anos, com 50% de desconto na primeira anuidade se solicitada em até 365 dias após a formatura.</p>
                        <a href="{{ route('pages.show', 'servico-inscricao-provisoria-pf-nutri') }}" class="inline-flex items-center gap-1 text-xs font-medium text-brand-700 hover:text-brand-800 mt-2">Ver documentos e formulário →</a>
                    </div>
                </li>
                <li class="flex gap-3 rounded-xl border border-slate-200 bg-white p-4">
                    <span class="shrink-0 flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">2</span>
                    <div>
                        <p class="text-sm font-medium text-slate-900">Já tem o diploma registrado?</p>
                        <p class="text-sm text-slate-600 mt-1">Solicite direto a <strong>Inscrição Definitiva</strong> — validade indeterminada.</p>
                        <a href="{{ route('pages.show', 'servico-inscricao-definitiva-pf-nutri') }}" class="inline-flex items-center gap-1 text-xs font-medium text-brand-700 hover:text-brand-800 mt-2">Ver documentos e formulário →</a>
                    </div>
                </li>
                <li class="flex gap-3 rounded-xl border border-slate-200 bg-white p-4">
                    <span class="shrink-0 flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">3</span>
                    <div>
                        <p class="text-sm font-medium text-slate-900">Envie a documentação e aguarde a análise</p>
                        <p class="text-sm text-slate-600 mt-1">O prazo padrão de ativação é de até 30 dias úteis após o recebimento da documentação completa.</p>
                    </div>
                </li>
                <li class="flex gap-3 rounded-xl border border-slate-200 bg-white p-4">
                    <span class="shrink-0 flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">4</span>
                    <div>
                        <p class="text-sm font-medium text-slate-900">Inscrição ativa — você já pode atuar</p>
                        <p class="text-sm text-slate-600 mt-1">Guarde sua carteira profissional e mantenha seus dados cadastrais e a anuidade em dia.</p>
                    </div>
                </li>
            </ol>
            <p class="text-xs text-slate-400 mt-3">Dúvidas rápidas? Consulte as <a href="{{ route('faqs.index') }}" class="underline hover:text-slate-600">Perguntas Frequentes</a>.</p>
        </div>

        {{-- Etapa 2 --}}
        <div class="relative pl-14">
            <span class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-full bg-brand-700 text-white font-bold">2</span>
            <h2 class="text-xl font-bold text-slate-900 mb-2">Escolha como vai atuar: autônomo(a) ou empresa</h2>
            <p class="text-sm text-slate-600 mb-5">Antes de atender seu primeiro paciente, entenda as duas formas mais comuns de formalização — e procure um(a) contador(a) para a decisão que melhor se encaixa no seu caso.</p>

            <div class="grid sm:grid-cols-2 gap-4">
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <h3 class="font-semibold text-slate-900 mb-2">Pessoa Física (autônomo)</h3>
                    <ul class="space-y-1.5 text-sm text-slate-600">
                        <li>• Pode emitir Recibo de Profissional Liberal (RPA) sem CNPJ;</li>
                        <li>• Recolhe Imposto de Renda como pessoa física (tabela progressiva) e pode ter retenção de INSS na fonte;</li>
                        <li>• Simples para começar, mas geralmente menos vantajoso tributariamente conforme a renda cresce;</li>
                        <li>• Não exige registro de responsabilidade técnica de PJ no CRN-9.</li>
                    </ul>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <h3 class="font-semibold text-slate-900 mb-2">Pessoa Jurídica (abrir empresa)</h3>
                    <ul class="space-y-1.5 text-sm text-slate-600">
                        <li>• Geralmente enquadrada no Simples Nacional como MEI ou ME, com alíquotas menores sobre o faturamento;</li>
                        <li>• Exige CNPJ, registro no CRN-9 como pessoa jurídica e Nutricionista Responsável Técnico (você mesmo, se for o caso);</li>
                        <li>• Permite emitir nota fiscal de serviço e, em geral, contratar outros profissionais no futuro;</li>
                        <li>• Traz obrigações contábeis regulares (declarações, guias mensais).</li>
                    </ul>
                    <a href="{{ route('pages.show', 'servicos-pessoa-juridica') }}" class="inline-flex items-center gap-1 text-xs font-medium text-brand-700 hover:text-brand-800 mt-3">Ver registro de Pessoa Jurídica no CRN-9 →</a>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-3">Este resumo é uma orientação geral e não substitui a consulta a um(a) contador(a) — a melhor opção depende da sua renda esperada, do município e do tipo de atendimento.</p>
        </div>

        {{-- Etapa 3 --}}
        <div class="relative pl-14">
            <span class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-full bg-brand-700 text-white font-bold">3</span>
            <h2 class="text-xl font-bold text-slate-900 mb-2">Prepare seu consultório</h2>
            <p class="text-sm text-slate-600 mb-5">Vai atender em consultório próprio ou alugado? Estes são os requisitos mínimos mais comuns exigidos pela vigilância sanitária municipal — confirme sempre as exigências específicas da prefeitura do seu município.</p>

            <div class="grid sm:grid-cols-2 gap-3">
                @foreach ([
                    'Alvará de funcionamento e Alvará Sanitário emitidos pela prefeitura',
                    'Espaço com boa ventilação, iluminação e piso/paredes de fácil higienização',
                    'Sala de espera separada da sala de atendimento',
                    'Balança e antropômetro calibrados e em bom estado de conservação',
                    'Lavatório para higienização das mãos, com sabonete líquido e papel-toalha',
                    'Prontuário do paciente (físico ou eletrônico) devidamente identificado',
                    'Placa de identificação profissional visível, com nome completo e nº do CRN-9',
                    'Descarte adequado de materiais, quando aplicável',
                ] as $item)
                    <div class="flex items-start gap-2 rounded-xl border border-slate-200 bg-white p-4">
                        <svg class="h-5 w-5 shrink-0 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-sm text-slate-700">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-slate-400 mt-3">
                Lembre-se: o que deve constar no carimbo (nome completo + nº do CRN-9) tem um modelo pronto para copiar na ferramenta <a href="{{ route('pode-nao-pode.index') }}" class="underline hover:text-slate-600">Pode ou Não Pode?</a>.
            </p>
        </div>
    </section>

    <section class="bg-brand-900">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-10 text-center">
            <h2 class="text-lg font-semibold text-white">Ainda com dúvidas?</h2>
            <p class="text-brand-200 text-sm mt-1">Nossa equipe está pronta para orientar você nessa nova fase.</p>
            <a href="{{ route('pages.show', 'fale-conosco') }}" class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 mt-4 text-sm font-semibold text-brand-800 hover:bg-brand-50 transition">
                Falar com o CRN-9
            </a>
        </div>
    </section>
@endsection
