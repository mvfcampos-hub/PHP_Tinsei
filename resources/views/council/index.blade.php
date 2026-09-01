@extends('layouts.app')

@section('title', 'Plenário')

@php
    $kindLabels = [
        'diretoria' => 'Diretoria',
        'comissao' => 'Comissão',
        'camara' => 'Câmara Técnica',
        'historico' => 'Arquivo histórico',
    ];
@endphp

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Plenário</h1>
            <p class="text-slate-500 mt-2 max-w-3xl">
                O Plenário é o órgão máximo de deliberação do CRN-9, responsável por definir as diretrizes de atuação do Conselho, aprovar seu orçamento e prestação de contas, e decidir sobre processos éticos e administrativos de sua competência. É composto pela Diretoria e por Conselheiros efetivos e suplentes, organizados em comissões e câmaras técnicas.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12 space-y-4">
        @forelse ($groups as $index => $group)
            <details class="rounded-2xl border border-slate-200 bg-white overflow-hidden group" @if ($index === 0) open @endif>
                <summary class="cursor-pointer list-none flex items-center justify-between gap-4 px-5 py-4 hover:bg-slate-50">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-medium text-brand-700 shrink-0">
                            {{ $kindLabels[$group->kind] ?? 'Grupo' }}
                        </span>
                        <h2 class="font-semibold text-slate-900 truncate">{{ $group->name }}</h2>
                    </div>
                    <svg class="h-5 w-5 shrink-0 text-slate-400 transition group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                </summary>

                <div class="border-t border-slate-100 px-5 py-5">
                    @if ($group->contact_email)
                        <p class="text-sm text-slate-500 mb-4">
                            Contato: <a href="mailto:{{ $group->contact_email }}" class="text-brand-700 hover:underline">{{ $group->contact_email }}</a>
                        </p>
                    @endif

                    @if ($group->members->isEmpty())
                        <p class="text-sm text-slate-500">
                            @if ($group->kind === 'camara')
                                Câmara técnica sem membros designados no momento.
                            @else
                                Sem membros cadastrados no momento.
                            @endif
                        </p>
                    @elseif ($group->kind === 'historico')
                        <div class="space-y-4">
                            @foreach ($group->members as $member)
                                <div x-data="{ open: false }" class="rounded-xl border border-slate-100 p-4">
                                    <button type="button" @click="open = !open" class="flex w-full items-center justify-between text-left">
                                        <span class="font-medium text-slate-900">{{ $member->name }}</span>
                                        <span class="text-slate-400 text-sm" x-text="open ? 'Ocultar' : 'Ver detalhes'"></span>
                                    </button>
                                    <div x-show="open" x-cloak class="mt-3 pt-3 border-t border-slate-100 text-sm text-slate-600 leading-relaxed">
                                        {!! $member->bio !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($group->members as $member)
                                <div x-data="{ open: false }" class="rounded-xl border border-slate-100 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="font-medium text-slate-900">{{ $member->name }}</p>
                                            @if ($member->role)
                                                <p class="text-sm text-brand-700">{{ $member->role }}</p>
                                            @endif
                                        </div>
                                        @if ($member->registration_number || $member->bio)
                                            <button
                                                type="button"
                                                @click="open = !open"
                                                :aria-expanded="open"
                                                class="shrink-0 h-7 w-7 rounded-full border border-slate-300 text-slate-500 hover:border-brand-500 hover:text-brand-700 flex items-center justify-center transition"
                                                :aria-label="open ? 'Ocultar detalhes' : 'Ver detalhes'"
                                            >
                                                <span x-show="!open">+</span>
                                                <span x-show="open" x-cloak>&minus;</span>
                                            </button>
                                        @endif
                                    </div>
                                    @if ($member->registration_number || $member->bio)
                                        <div x-show="open" x-cloak class="mt-3 pt-3 border-t border-slate-100 space-y-1.5 text-sm text-slate-600">
                                            @if ($member->registration_number)
                                                <p><span class="font-medium text-slate-700">Registro:</span> {{ $member->registration_number }}</p>
                                            @endif
                                            @if ($member->bio)
                                                <div class="leading-relaxed">{!! $member->bio !!}</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </details>
        @empty
            <p class="text-slate-500">Composição do Plenário em atualização.</p>
        @endforelse
    </section>
@endsection
