@extends('layouts.app')

@section('title', 'Recebi uma Fiscalização')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Guia Rápido: Recebi uma Fiscalização</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Orientações objetivas sobre o que esperar de uma visita fiscal ou técnica do CRN-9, seus direitos e deveres durante o processo, e como enviar comprovantes de adequação sem precisar de e-mail.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12 space-y-12">
        {{-- 1. O que o fiscal pode solicitar --}}
        <div>
            <h2 class="text-xl font-bold text-slate-900 mb-2">1. O que o fiscal pode solicitar</h2>
            <p class="text-sm text-slate-600 mb-4">
                Durante a visita, a fiscal do CRN-9 aplica o Roteiro de Visita Técnica (RVT), instrumento padronizado pelo CFN (Resoluções CFN nº 465/2010 e nº 600/2018). Para preenchê-lo, ela pode solicitar, conforme a área de atuação:
            </p>
            <div class="grid sm:grid-cols-2 gap-3">
                @foreach ([
                    'Escala de trabalho da equipe de nutrição',
                    'Manual de Boas Práticas de Fabricação (MBPF)',
                    'Procedimentos Operacionais Padronizados (POPs)',
                    'Cardápio vigente e fichas técnicas de preparações',
                    'Comprovante de Anotação de Responsabilidade Técnica (ART/RT)',
                    'Planilhas de controle de temperatura e de recebimento de alimentos',
                    'Comprovante de inscrição da empresa/instituição no CRN-9',
                    'Documentação referente a denúncias, quando aplicável',
                ] as $document)
                    <div class="flex items-start gap-2 rounded-xl border border-slate-200 bg-white p-4">
                        <svg class="h-5 w-5 shrink-0 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-sm text-slate-700">{{ $document }}</span>
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-slate-400 mt-3">
                A lista exata de itens verificados varia conforme a área de atuação profissional, definida no próprio RVT. Na ausência de RVT, a fiscal elabora um relatório descritivo das atividades observadas.
            </p>
        </div>

        {{-- 2. Direitos e deveres --}}
        <div>
            <h2 class="text-xl font-bold text-slate-900 mb-4">2. Seus direitos e deveres durante a inspeção</h2>
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-5">
                    <h3 class="font-semibold text-slate-900 mb-3">Direitos</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Exigir que a fiscal se identifique antes da visita.</li>
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Receber orientação técnica, e não apenas notificação de irregularidades.</li>
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Solicitar cópia do relatório ou do RVT preenchido ao final da visita.</li>
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Ter prazo razoável para regularizar pendências apontadas.</li>
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Recorrer administrativamente de Autos de Infração, nos prazos legais.</li>
                    </ul>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5">
                    <h3 class="font-semibold text-slate-900 mb-3">Deveres</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Apresentar-se e franquear o acesso da fiscal ao local de trabalho.</li>
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Fornecer informações verdadeiras sobre sua atuação profissional.</li>
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Manter a inscrição e os dados cadastrais atualizados junto ao CRN-9.</li>
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Cumprir os prazos estabelecidos em Comunicados Fiscais.</li>
                        <li class="flex gap-2"><span class="text-brand-600">•</span> Enviar os comprovantes de adequação solicitados pelo Portal abaixo.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- 3. Portal de Adequação --}}
        <div id="portal-adequacao">
            <h2 class="text-xl font-bold text-slate-900 mb-2">3. Portal de Adequação</h2>
            <p class="text-sm text-slate-600 mb-6">
                Já recebeu uma fiscalização e precisa enviar os comprovantes solicitados? Anexe os documentos diretamente aqui — sem precisar enviar e-mails avulsos. Você receberá um número de protocolo para acompanhamento.
            </p>

            @if (session('submitted'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                    Comprovantes enviados com sucesso! Guarde o número de protocolo desta página para referência futura.
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold mb-1">Corrija os campos abaixo:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('compliance.store') }}#portal-adequacao" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">
                @csrf

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nome completo *</label>
                        <input type="text" name="nutritionist_name" value="{{ old('nutritionist_name') }}" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Número de inscrição no CRN-9 *</label>
                        <input type="text" name="crn_number" value="{{ old('crn_number') }}" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Referência da fiscalização (nº do Comunicado Fiscal, se houver)</label>
                    <input type="text" name="inspection_reference" value="{{ old('inspection_reference') }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Observações</label>
                    <textarea name="notes" rows="3" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">{{ old('notes') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Arquivos comprobatórios * (PDF, DOC, JPG ou PNG — até 10 arquivos, 10MB cada)</label>
                    <input type="file" name="files[]" multiple required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
                </div>

                <button type="submit" class="inline-flex items-center rounded-lg bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition">
                    Enviar comprovantes
                </button>
            </form>
        </div>
    </section>
@endsection
