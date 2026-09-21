@extends('layouts.app')

@section('title', 'Comprovante de envio — ' . $submission->protocol)

@section('content')
    <article class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="rounded-2xl border border-green-200 bg-green-50 p-6 mb-8 text-center">
            <svg class="h-10 w-10 text-green-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <h1 class="text-xl font-bold text-slate-900">Comprovantes recebidos</h1>
            <p class="text-sm text-slate-600 mt-1">Protocolo: <span class="font-mono font-semibold">{{ $submission->protocol }}</span></p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">
            <div>
                <p class="text-xs uppercase text-slate-400">Profissional</p>
                <p class="text-sm text-slate-800">{{ $submission->nutritionist_name }} — CRN-9 nº {{ $submission->crn_number }}</p>
            </div>
            @if ($submission->inspection_reference)
                <div>
                    <p class="text-xs uppercase text-slate-400">Referência da fiscalização</p>
                    <p class="text-sm text-slate-800">{{ $submission->inspection_reference }}</p>
                </div>
            @endif
            @if ($submission->notes)
                <div>
                    <p class="text-xs uppercase text-slate-400">Observações</p>
                    <p class="text-sm text-slate-800">{{ $submission->notes }}</p>
                </div>
            @endif
            <div>
                <p class="text-xs uppercase text-slate-400 mb-2">Arquivos enviados</p>
                <ul class="space-y-1">
                    @foreach ($submission->files as $file)
                        <li class="text-sm text-slate-700 flex items-center gap-2">
                            <svg class="h-4 w-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            {{ $file->original_name }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="text-xs uppercase text-slate-400">Status</p>
                <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">
                    {{ $submission->status === 'pending' ? 'Aguardando análise' : 'Analisado' }}
                </span>
            </div>
        </div>

        <p class="text-sm text-slate-500 mt-6 text-center">
            Guarde este número de protocolo. A equipe de fiscalização do CRN-9 analisará os comprovantes enviados.
        </p>
    </article>
@endsection
