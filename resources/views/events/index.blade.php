@extends('layouts.app')

@section('title', 'Agenda de Eventos')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Agenda de Eventos</h1>
            <p class="text-slate-500 mt-2">Acompanhe eventos, reuniões, capacitações e tudo o que acontece no CRN-9 e no Sistema CFN/CRN — com transparência.</p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Calendário mensal --}}
        <div x-data="{ selected: null }" class="rounded-2xl border border-slate-200 bg-white overflow-hidden mb-16 max-w-md mx-auto">
            <div class="flex items-center justify-between gap-2 px-4 py-3 border-b border-slate-200">
                <a href="{{ route('events.index', ['month' => $month->copy()->subMonth()->format('Y-m')]) }}" class="p-1.5 rounded-lg hover:bg-slate-100 shrink-0" aria-label="Mês anterior">
                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>

                <div class="flex items-center gap-1.5 min-w-0">
                    <h2 class="font-semibold text-slate-900 capitalize text-sm truncate">{{ $month->translatedFormat('F \d\e Y') }}</h2>
                    <form method="GET" action="{{ route('events.index') }}" class="shrink-0">
                        <label class="sr-only" for="month-picker">Ir para mês</label>
                        <input
                            type="month"
                            id="month-picker"
                            name="month"
                            value="{{ $month->format('Y-m') }}"
                            onchange="this.form.submit()"
                            aria-label="Selecionar mês e ano"
                            class="w-6 h-6 opacity-0 absolute cursor-pointer"
                        >
                        <label for="month-picker" class="flex items-center justify-center h-6 w-6 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 cursor-pointer" aria-hidden="true">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 4H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zM16 2v4M8 2v4M3 10h18" /></svg>
                        </label>
                    </form>
                </div>

                <div class="flex items-center gap-1 shrink-0">
                    @if ($month->isSameMonth(now()))
                        <span class="text-xs font-medium text-slate-300 px-2 py-1">Hoje</span>
                    @else
                        <a href="{{ route('events.index') }}" class="text-xs font-medium text-brand-700 hover:text-brand-800 px-2 py-1 rounded-lg hover:bg-brand-50">Hoje</a>
                    @endif
                    <a href="{{ route('events.index', ['month' => $month->copy()->addMonth()->format('Y-m')]) }}" class="p-1.5 rounded-lg hover:bg-slate-100" aria-label="Próximo mês">
                        <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50 text-center">
                @foreach (['D', 'S', 'T', 'Q', 'Q', 'S', 'S'] as $day)
                    <div class="py-1.5 text-[11px] font-semibold text-slate-500">{{ $day }}</div>
                @endforeach
            </div>

            <div class="grid grid-cols-7">
                @foreach ($calendarWeeks as $week)
                    @foreach ($week as $day)
                        @php $dateKey = $day['date']->format('Y-m-d'); @endphp
                        <button
                            type="button"
                            @click="selected = (selected === '{{ $dateKey }}') ? null : '{{ $dateKey }}'"
                            :class="selected === '{{ $dateKey }}' ? 'ring-2 ring-inset ring-brand-500' : ''"
                            class="relative flex flex-col items-center justify-start gap-1 h-14 border-b border-r border-slate-100 py-1.5 transition {{ $day['isCurrentMonth'] ? 'bg-white hover:bg-slate-50' : 'bg-slate-50/60 hover:bg-slate-100/60' }}"
                        >
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full text-xs {{ $day['isToday'] ? 'bg-brand-600 text-white font-semibold' : ($day['isCurrentMonth'] ? 'text-slate-700' : 'text-slate-300') }}">
                                {{ $day['date']->day }}
                            </span>
                            @if ($day['events']->isNotEmpty())
                                <span class="flex items-center gap-0.5">
                                    @foreach ($day['events']->take(3) as $event)
                                        <span class="h-1.5 w-1.5 rounded-full {{ $event->source === 'cfn_sync' ? 'bg-brand-blue' : 'bg-brand-700' }}"></span>
                                    @endforeach
                                </span>
                            @endif
                        </button>
                    @endforeach
                @endforeach
            </div>

            {{-- Legenda --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 px-4 py-2.5 border-t border-slate-200 bg-slate-50 text-xs text-slate-500">
                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-brand-700"></span> Eventos do CRN-9</span>
                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-brand-blue"></span> Calendário CFN Nacional</span>
            </div>

            {{-- Painel do dia selecionado --}}
            @foreach ($calendarWeeks as $week)
                @foreach ($week as $day)
                    @php $dateKey = $day['date']->format('Y-m-d'); @endphp
                    <div x-show="selected === '{{ $dateKey }}'" x-cloak x-transition class="border-t border-slate-200 px-4 py-4 space-y-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $day['date']->translatedFormat('l, d \d\e F') }}</p>
                        @forelse ($day['events'] as $event)
                            <div class="flex items-start gap-2">
                                <span class="mt-1.5 h-1.5 w-1.5 rounded-full shrink-0 {{ $event->source === 'cfn_sync' ? 'bg-brand-blue' : 'bg-brand-700' }}"></span>
                                <div class="min-w-0">
                                    @if ($event->external_url)
                                        <a href="{{ $event->external_url }}" target="_blank" rel="noopener" class="font-medium text-sm text-slate-900 hover:text-brand-700">{{ $event->title }}</a>
                                    @else
                                        <p class="font-medium text-sm text-slate-900">{{ $event->title }}</p>
                                    @endif
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ $event->starts_at->format('H:i') }}
                                        @if ($event->location)
                                            &middot; {{ $event->location }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">Nenhum evento cadastrado para este dia.</p>
                        @endforelse
                    </div>
                @endforeach
            @endforeach
        </div>

        <h2 class="text-xl font-bold text-slate-900 mb-6">Próximos eventos</h2>
        <div class="space-y-4 mb-16">
            @forelse ($upcomingEvents as $event)
                <x-event-card :event="$event" />
            @empty
                <p class="text-slate-500">Nenhum evento futuro cadastrado no momento.</p>
            @endforelse
        </div>

        @if ($pastEvents->isNotEmpty())
            <h2 class="text-xl font-bold text-slate-900 mb-6">Eventos anteriores</h2>
            <div class="space-y-4 opacity-75">
                @foreach ($pastEvents as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        @endif
    </section>
@endsection
