@extends('layouts.app')

@section('title', $licitacao->title)

@section('content')
    <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('licitacoes.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mb-6">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
            Voltar para licitações
        </a>

        <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-medium text-brand-700 mb-3">
            {{ $licitacao->modality }}
        </span>
        <h1 class="text-3xl font-bold text-slate-900">{{ $licitacao->title }}</h1>
        <p class="text-slate-500 mt-2 text-sm">
            @if ($licitacao->number) Nº {{ $licitacao->number }} @endif
            @if ($licitacao->year) &middot; {{ $licitacao->year }} @endif
            @if ($licitacao->published_at) &middot; Publicado em {{ $licitacao->published_at->format('d/m/Y') }} @endif
            &middot; <span class="capitalize">{{ $licitacao->status }}</span>
        </p>

        @if ($licitacao->description)
            <div class="prose prose-slate max-w-none mt-8">
                <p>{{ $licitacao->description }}</p>
            </div>
        @endif

        @if ($licitacao->documents->isNotEmpty())
            <div class="mt-10">
                <h2 class="font-semibold text-slate-900 mb-4">Documentos</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach ($licitacao->documents as $document)
                        <a
                            href="{{ $document->url }}" target="_blank" rel="noopener"
                            class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 hover:border-brand-300 hover:shadow-sm transition"
                        >
                            <svg class="h-5 w-5 shrink-0 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H8a2 2 0 01-2-2V5a2 2 0 012-2h6l6 6v11a2 2 0 01-2 2z" /></svg>
                            <span class="text-sm font-medium text-slate-800">{{ $document->label }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <p class="mt-10 text-sm text-slate-500">Nenhum documento publicado para este processo até o momento.</p>
        @endif

        <div class="mt-10 rounded-2xl bg-brand-50 p-6 text-sm text-slate-700">
            Dúvidas sobre este processo? Entre em contato: <a href="mailto:licitacao@crn9.org.br" class="text-brand-700 hover:underline font-medium">licitacao@crn9.org.br</a>
        </div>
    </article>
@endsection
