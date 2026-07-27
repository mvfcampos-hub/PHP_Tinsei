@extends('layouts.app')

@section('title', 'Fiscalização')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Equipe de Fiscalização</h1>
            <p class="text-slate-500 mt-2">Conheça a equipe responsável pela fiscalização do exercício profissional, organizada por unidade</p>

            @if ($roleSummary->isNotEmpty())
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($roleSummary as $role => $count)
                        <span class="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-700">
                            {{ $role }}: {{ $count }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 space-y-12">
        @forelse ($groupedInspectors as $region => $inspectors)
            <div>
                <h2 class="text-lg font-bold uppercase tracking-wide text-slate-900 border-b border-slate-200 pb-2 mb-6">
                    {{ $region ?: 'Outras unidades' }}
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($inspectors as $inspector)
                        <div
                            x-data="{ open: false }"
                            class="rounded-2xl border border-slate-200 bg-white p-5"
                        >
                            <div class="flex items-start gap-4">
                                <div class="h-14 w-14 shrink-0 rounded-full bg-slate-100 overflow-hidden">
                                    @if ($inspector->photo)
                                        <img src="{{ Storage::url($inspector->photo) }}" alt="{{ $inspector->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-brand-100 text-brand-700 font-semibold">
                                            {{ collect(explode(' ', $inspector->name))->map(fn ($n) => $n[0])->take(2)->implode('') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-slate-900 leading-tight">{{ $inspector->name }}</h3>
                                    <p class="text-sm text-brand-700">{{ $inspector->role }}</p>
                                </div>
                                @if ($inspector->registration_number || $inspector->email || $inspector->phone || $inspector->duty_notes)
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

                            @if ($inspector->registration_number || $inspector->email || $inspector->phone || $inspector->duty_notes)
                                <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100 space-y-1.5 text-sm text-slate-600">
                                    @if ($inspector->registration_number)
                                        <p><span class="font-medium text-slate-700">Registro:</span> {{ $inspector->registration_number }}</p>
                                    @endif
                                    @if ($inspector->email)
                                        <p><span class="font-medium text-slate-700">E-mail:</span> <a href="mailto:{{ $inspector->email }}" class="text-brand-700 hover:underline">{{ $inspector->email }}</a></p>
                                    @endif
                                    @if ($inspector->phone)
                                        <p><span class="font-medium text-slate-700">Telefone:</span> {{ $inspector->phone }}</p>
                                    @endif
                                    @if ($inspector->duty_notes)
                                        <p><span class="font-medium text-slate-700">Plantão:</span> {{ $inspector->duty_notes }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-slate-500">Equipe de fiscalização em atualização.</p>
        @endforelse
    </section>
@endsection
