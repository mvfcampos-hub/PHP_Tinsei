@extends('layouts.app')

@section('title', 'Licitações')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Licitações</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Pregões, tomadas de preços, chamamentos públicos e demais processos licitatórios do CRN-9, com editais, anexos e resultados para download.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <form method="get" class="mb-8 flex flex-wrap gap-3">
            <select name="modalidade" onchange="this.form.submit()" class="rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                <option value="">Todas as modalidades</option>
                @foreach ($modalities as $modality)
                    <option value="{{ $modality }}" @selected(request('modalidade') === $modality)>{{ $modality }}</option>
                @endforeach
            </select>
            <select name="ano" onchange="this.form.submit()" class="rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                <option value="">Todos os anos</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}" @selected((int) request('ano') === $year)>{{ $year }}</option>
                @endforeach
            </select>
            @if (request('modalidade') || request('ano'))
                <a href="{{ route('licitacoes.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700">Limpar filtros</a>
            @endif
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($licitacoes as $licitacao)
                <a href="{{ route('licitacoes.show', $licitacao) }}" class="rounded-2xl border border-slate-200 bg-white p-5 hover:border-brand-300 hover:shadow-sm transition flex flex-col">
                    <span class="inline-flex self-start items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-medium text-brand-700 mb-3">
                        {{ $licitacao->modality }}
                    </span>
                    <h2 class="font-semibold text-slate-900 leading-snug">{{ $licitacao->title }}</h2>
                    @if ($licitacao->description)
                        <p class="text-sm text-slate-500 mt-2 line-clamp-3">{{ $licitacao->description }}</p>
                    @endif
                    <p class="text-xs text-slate-400 mt-4">
                        {{ $licitacao->documents_count }} documento(s)
                        @if ($licitacao->published_at)
                            &middot; {{ $licitacao->published_at->format('d/m/Y') }}
                        @endif
                    </p>
                </a>
            @empty
                <p class="text-slate-500 col-span-full">Nenhuma licitação encontrada.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $licitacoes->links() }}
        </div>
    </section>
@endsection
