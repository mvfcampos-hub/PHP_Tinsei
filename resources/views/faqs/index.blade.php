@extends('layouts.app')

@section('title', 'Perguntas Frequentes')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Perguntas Frequentes</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Respostas rápidas sobre inscrição, anuidade, transferências, documentos e demais serviços do CRN-9.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        <form method="get" class="mb-10 flex flex-wrap gap-3">
            <input
                type="text" name="q" value="{{ request('q') }}"
                placeholder="Buscar por palavra-chave..."
                class="w-full sm:w-80 rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
            >
            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 transition">
                Buscar
            </button>
            @if (request('q'))
                <a href="{{ route('faqs.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700">Limpar busca</a>
            @endif
        </form>

        @forelse ($faqs as $category => $items)
            <div class="mb-10">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">{{ $category }}</h2>
                <div class="space-y-3">
                    @foreach ($items as $faq)
                        <div x-data="{ open: false }" class="rounded-xl border border-slate-200 bg-white overflow-hidden">
                            <button
                                type="button"
                                @click="open = !open"
                                class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left"
                            >
                                <span class="font-medium text-slate-900">{{ $faq->question }}</span>
                                <svg :class="open ? 'rotate-180' : ''" class="h-4 w-4 shrink-0 text-slate-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="open" x-cloak x-transition class="px-5 pb-4 text-sm text-slate-600 leading-relaxed">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-slate-500">Nenhuma pergunta encontrada para essa busca.</p>
        @endforelse

        <div class="mt-10 rounded-xl border border-slate-200 bg-slate-50 p-6 text-center">
            <p class="text-sm text-slate-600">Não encontrou o que procurava?</p>
            <a href="{{ route('pages.show', 'fale-conosco') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mt-2">
                Fale com o atendimento do CRN-9
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>
    </section>
@endsection
