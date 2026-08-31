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
        <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden mb-16">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
                <a href="{{ route('events.index', ['month' => $month->copy()->subMonth()->format('Y-m')]) }}" class="p-2 rounded-lg hover:bg-slate-100" aria-label="Mês anterior">
                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <h2 class="font-semibold text-slate-900 capitalize">{{ $month->translatedFormat('F \d\e Y') }}</h2>
                <a href="{{ route('events.index', ['month' => $month->copy()->addMonth()->format('Y-m')]) }}" class="p-2 rounded-lg hover:bg-slate-100" aria-label="Próximo mês">
                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>

            <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50 text-center">
                @foreach (['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $day)
                    <div class="py-2 text-xs font-semibold text-slate-500">{{ $day }}</div>
                @endforeach
            </div>

            <div class="grid grid-cols-7">
                @foreach ($calendarWeeks as $week)
                    @foreach ($week as $day)
                        <div class="min-h-[92px] border-b border-r border-slate-100 p-1.5 {{ $day['isCurrentMonth'] ? 'bg-white' : 'bg-slate-50/60' }}">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full text-xs {{ $day['isToday'] ? 'bg-brand-600 text-white font-semibold' : ($day['isCurrentMonth'] ? 'text-slate-700' : 'text-slate-300') }}">
                                {{ $day['date']->day }}
                            </span>
                            <div class="mt-1 space-y-1">
                                @foreach ($day['events']->take(3) as $event)
                                    @if ($event->external_url)
                                        <a href="{{ $event->external_url }}" target="_blank" rel="noopener" class="block truncate rounded bg-brand-50 px-1.5 py-0.5 text-[11px] text-brand-800 hover:bg-brand-100" title="{{ $event->title }}">
                                            {{ $event->title }}
                                        </a>
                                    @else
                                        <span class="block truncate rounded bg-brand-50 px-1.5 py-0.5 text-[11px] text-brand-800" title="{{ $event->title }}">
                                            {{ $event->title }}
                                        </span>
                                    @endif
                                @endforeach
                                @if ($day['events']->count() > 3)
                                    <span class="block text-[11px] text-slate-400">+{{ $day['events']->count() - 3 }} mais</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
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
