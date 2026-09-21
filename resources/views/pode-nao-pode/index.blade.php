@extends('layouts.app')

@section('title', 'Pode ou Não Pode?')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Pode ou Não Pode?</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Respostas diretas e objetivas para dúvidas comuns sobre o exercício profissional do(a) nutricionista, com base nas Resoluções do CFN/CRN.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        <form method="get" class="mb-10 flex flex-wrap gap-3">
            <input
                type="text" name="q" value="{{ request('q') }}"
                placeholder="Ex.: fitoterápico, suplemento, exame, prontuário..."
                class="w-full sm:w-96 rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
            >
            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 transition">
                Buscar
            </button>
            @if (request('q'))
                <a href="{{ route('pode-nao-pode.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700">Limpar busca</a>
            @endif
        </form>

        @forelse ($questions as $category => $items)
            <div class="mb-10">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">{{ $category }}</h2>
                <div class="space-y-4">
                    @foreach ($items as $item)
                        <div class="rounded-2xl border border-slate-200 bg-white p-5">
                            <h3 class="font-semibold text-slate-900">{{ $item->question }}</h3>
                            <p class="text-sm text-slate-600 mt-2 leading-relaxed">{!! nl2br(e($item->answer)) !!}</p>

                            @if ($item->template_text)
                                <div x-data="{ copied: false }" class="mt-4 rounded-lg bg-slate-50 border border-slate-200 p-3">
                                    <pre class="text-xs text-slate-700 whitespace-pre-wrap font-sans">{{ $item->template_text }}</pre>
                                    <button
                                        type="button"
                                        @click="navigator.clipboard.writeText(@js($item->template_text)); copied = true; setTimeout(() => copied = false, 2000)"
                                        class="mt-2 inline-flex items-center gap-1.5 text-xs font-medium text-brand-700 hover:text-brand-800"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                        <span x-show="!copied">{{ $item->template_label ?? 'Copiar modelo' }}</span>
                                        <span x-show="copied" x-cloak class="text-green-600">Copiado!</span>
                                    </button>
                                </div>
                            @endif

                            @if ($item->resolution_reference)
                                <p class="text-xs text-slate-400 mt-3">Base normativa: {{ $item->resolution_reference }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-slate-500">Nenhum resultado encontrado para essa busca.</p>
        @endforelse

        <div class="mt-10 rounded-xl border border-amber-200 bg-amber-50 p-6 text-sm text-amber-900">
            As respostas aqui são orientações gerais e não substituem a leitura da Resolução citada em cada item nem a consulta direta ao setor de fiscalização do CRN-9 em casos específicos.
        </div>
    </section>
@endsection
