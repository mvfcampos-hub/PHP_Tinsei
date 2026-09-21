@extends('layouts.app')

@section('title', 'Nutrição em Minas')

@php
    $areaIcons = [
        'Saúde Pública' => 'M12 21c-4.97-3.29-9-7.5-9-11.5A6 6 0 0112 3a6 6 0 019 6.5c0 4-4.03 8.21-9 11.5z',
        'Hospitais' => 'M9 3h6v4h4v14H5V7h4V3zm3 6v6m-3-3h6',
        'Alimentação Escolar' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12.02 12.02 0 0112 20a12.02 12.02 0 01-6.16-9.42L12 14zm0 0v7',
        'Segurança Alimentar e Nutricional' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'Alimentação Coletiva' => 'M3 12h18M3 6h18M3 18h18',
        'Consultórios' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        'Universidades e Pesquisa' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l9-5m-9 5v7',
        'Políticas Públicas' => 'M3 21h18M5 21V7l8-4v18M13 21V11l6 3v7M9 9h.01M9 12h.01M9 15h.01',
        'Outras áreas de atuação' => 'M5 13l4 4L19 7',
    ];
@endphp

@section('content')
    <section class="bg-gradient-to-br from-brand-900 to-brand-700 text-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-16">
            <span class="inline-block rounded-full bg-white/10 px-3 py-1 text-xs font-semibold tracking-wide uppercase mb-4">Nutrição em Minas</span>
            <h1 class="text-3xl sm:text-4xl font-bold max-w-2xl">A Nutrição acontecendo em Minas Gerais</h1>
            <p class="text-brand-100 mt-4 max-w-2xl">
                O CRN-9 não existe só para fiscalizar. Aqui você conhece histórias reais de nutricionistas e técnicos em nutrição transformando a saúde pública, os hospitais, as escolas, os consultórios, a pesquisa e as políticas públicas em todas as regiões do estado.
            </p>
            <a href="{{ route('nutrition-stories.suggest') }}" class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 mt-6 text-sm font-semibold text-brand-800 hover:bg-brand-50 transition">
                Indicar uma história
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>
    </section>

    {{-- Faixa de números reais --}}
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-2 sm:grid-cols-3 gap-6 text-center">
            <div>
                <p class="text-2xl sm:text-3xl font-bold text-brand-700">{{ number_format($stats['nutricionistas'], 0, ',', '.') }}+</p>
                <p class="text-xs text-slate-500 mt-1">nutricionistas atuando em Minas Gerais</p>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-bold text-brand-700">{{ number_format($stats['municipios'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-1">municípios com profissionais registrados</p>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <p class="text-2xl sm:text-3xl font-bold text-brand-700">{{ count($areas) - 1 }}+</p>
                <p class="text-xs text-slate-500 mt-1">áreas de atuação da Nutrição</p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-12">
        @if (session('suggested'))
            <div class="mb-8 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                Obrigado! Sua indicação foi enviada e será avaliada pela equipe de comunicação do CRN-9.
            </div>
        @endif

        {{-- Índice de áreas --}}
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Explore por área de atuação</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mb-12">
            <a
                href="{{ route('nutrition-stories.index') }}"
                class="rounded-xl border p-4 text-sm font-medium transition {{ request('area') ? 'border-slate-200 bg-white text-slate-600 hover:border-brand-300' : 'border-brand-600 bg-brand-50 text-brand-800' }}"
            >
                Todas as áreas
            </a>
            @foreach ($areas as $area)
                <a
                    href="{{ route('nutrition-stories.index', ['area' => $area]) }}"
                    class="flex items-center gap-2 rounded-xl border p-4 text-sm font-medium transition {{ request('area') === $area ? 'border-brand-600 bg-brand-50 text-brand-800' : 'border-slate-200 bg-white text-slate-600 hover:border-brand-300' }}"
                >
                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $areaIcons[$area] }}" /></svg>
                    {{ $area }}
                </a>
            @endforeach
        </div>

        {{-- Histórias --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($stories as $story)
                <a href="{{ route('nutrition-stories.show', $story) }}" class="group rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition">
                    <div class="aspect-[16/9] bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center overflow-hidden">
                        @if ($story->cover_image)
                            <img src="{{ Storage::url($story->cover_image) }}" alt="{{ $story->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <svg class="h-10 w-10 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $areaIcons[$story->area] ?? $areaIcons['Outras áreas de atuação'] }}" /></svg>
                        @endif
                    </div>
                    <div class="p-5">
                        <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700 mb-3">{{ $story->area }}</span>
                        <h3 class="font-semibold text-slate-900 leading-snug group-hover:text-brand-700 transition">{{ $story->title }}</h3>
                        @if ($story->role)
                            <p class="text-xs text-slate-500 mt-1">{{ $story->role }}</p>
                        @endif
                        <p class="text-sm text-slate-600 mt-2 line-clamp-2">{{ $story->summary }}</p>
                        <p class="text-xs text-slate-400 mt-4">{{ $story->region }}</p>
                    </div>
                </a>
            @empty
                <p class="text-slate-500 col-span-full">Nenhuma história publicada nesta área ainda.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $stories->links() }}
        </div>
    </section>
@endsection
