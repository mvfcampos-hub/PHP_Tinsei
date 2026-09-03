@extends('layouts.app')

@section('title', 'Base de Conhecimento')
@section('description', 'Base de Conhecimento Databit: artigos, tutoriais e vídeos de apoio para os sistemas, DataCloud, Serviços de TI e produtos de informática.')

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-16 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                Central de apoio
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white">Base de Conhecimento</h1>
            <p class="text-brand-200 mt-4 max-w-2xl mx-auto text-lg">
                Artigos, tutoriais e vídeos para tirar dúvidas sobre os sistemas, o DataCloud, os Serviços de TI e os
                produtos de informática da Databit.
            </p>

            <form action="{{ route('kb.index') }}" method="GET" class="mt-8 max-w-xl mx-auto">
                @if ($solutionType)
                    <input type="hidden" name="tipo" value="{{ $solutionType }}">
                @endif
                <div class="relative">
                    <svg class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    <input
                        type="search"
                        name="q"
                        value="{{ $term }}"
                        placeholder="Buscar na base de conhecimento..."
                        class="w-full rounded-xl border border-white/10 bg-white/5 pl-11 pr-28 py-3 text-sm text-white placeholder:text-brand-300 focus:border-accent-500 focus:ring-2 focus:ring-accent-500/30 outline-none"
                    >
                    <button type="submit" class="absolute right-1.5 top-1.5 rounded-lg bg-accent-500 px-4 py-2 text-sm font-semibold text-white hover:bg-accent-600 transition">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center gap-4">
            <div class="flex flex-wrap items-center gap-2 flex-1">
                <a
                    href="{{ route('kb.index', array_filter(['q' => $term ?: null])) }}"
                    @class([
                        'inline-flex items-center rounded-full px-3.5 py-1.5 text-sm font-medium transition',
                        'bg-brand-700 text-white' => ! $solutionType,
                        'bg-slate-100 text-slate-600 hover:bg-slate-200' => $solutionType,
                    ])
                >Todos os tipos</a>
                @foreach ($solutionTypes as $key => $label)
                    <a
                        href="{{ route('kb.index', array_filter(['q' => $term ?: null, 'tipo' => $key])) }}"
                        @class([
                            'inline-flex items-center rounded-full px-3.5 py-1.5 text-sm font-medium transition',
                            'bg-brand-700 text-white' => $solutionType === $key,
                            'bg-slate-100 text-slate-600 hover:bg-slate-200' => $solutionType !== $key,
                        ])
                    >{{ $label }}</a>
                @endforeach
            </div>

            @if ($modules->isNotEmpty())
                <form action="{{ route('kb.index') }}" method="GET" onchange="this.submit()" class="shrink-0 w-full sm:w-auto">
                    <input type="hidden" name="q" value="{{ $term }}">
                    @if ($solutionType)
                        <input type="hidden" name="tipo" value="{{ $solutionType }}">
                    @endif
                    <select name="modulo" class="w-full sm:w-56 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none">
                        <option value="">Todos os módulos</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}" @selected((string) $moduleId === (string) $module->id)>{{ $module->name }}</option>
                        @endforeach
                    </select>
                </form>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-12">
        <x-kb-ask-ai :solution-type="$solutionType" />
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        @if ($term !== '' || $solutionType || $moduleId)
            {{-- Resultado filtrado: lista simples --}}
            @if ($articles->isNotEmpty())
                <p class="text-sm text-slate-500 mb-6">{{ $articles->count() }} {{ $articles->count() === 1 ? 'artigo encontrado' : 'artigos encontrados' }}</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($articles as $article)
                        <x-kb-article-card :article="$article" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-lg font-semibold text-slate-800">Nenhum artigo encontrado</p>
                    <p class="text-slate-500 mt-2">Tente buscar por outro termo ou remover os filtros aplicados.</p>
                </div>
            @endif
        @else
            {{-- Sem filtro: agrupado por tipo de solução --}}
            <div class="space-y-14">
                @foreach ($solutionTypes as $key => $label)
                    @php $group = $grouped->get($key, collect()); @endphp
                    @if ($group->isNotEmpty())
                        <div>
                            <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wide mb-6">{{ $label }} ({{ $group->count() }})</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($group as $article)
                                    <x-kb-article-card :article="$article" />
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                @if ($articles->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-lg font-semibold text-slate-800">Ainda não há artigos publicados</p>
                        <p class="text-slate-500 mt-2">Em breve, novos conteúdos de apoio estarão disponíveis aqui.</p>
                    </div>
                @endif
            </div>
        @endif
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Não encontrou o que precisava?</h2>
                <p class="text-brand-100 mt-2">Nossa equipe de suporte pode ajudar diretamente.</p>
            </div>
            <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Preciso de ajuda e não encontrei o que procurava na Base de Conhecimento.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com o suporte
            </a>
        </div>
    </section>
@endsection
