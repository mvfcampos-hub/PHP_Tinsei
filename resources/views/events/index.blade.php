@extends('layouts.app')

@section('title', 'Agenda')
@section('description', 'Feiras, eventos, treinamentos para revendas e lançamentos da Tinsei.')

@section('content')
<x-page-hero eyebrow="Agenda" title="Agenda Tinsei" subtitle="Feiras do setor, treinamentos para revendas, lançamentos e encontros: veja onde a Tinsei vai estar." />

<section class="bg-slate-50 py-16 sm:py-20">
    <div class="container-site grid gap-12 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold text-brand-900">Próximos eventos</h2>
            <div class="mt-6 space-y-4">
                @forelse ($upcomingEvents as $event)
                    <x-event-card :event="$event" />
                @empty
                    <div class="card p-8 text-center">
                        <x-ico name="calendar" class="mx-auto h-10 w-10 text-brand-300" />
                        <p class="mt-4 font-semibold text-brand-900">Nenhum evento agendado no momento</p>
                        <p class="mt-1 text-sm text-slate-500">Novas datas são publicadas aqui e no nosso Instagram.</p>
                        <a href="{{ setting('instagram_url') }}" target="_blank" rel="noopener" class="btn-outline mt-5">Seguir @tinseioficial</a>
                    </div>
                @endforelse
            </div>
        </div>
        <aside>
            <h2 class="text-lg font-bold text-brand-900">Eventos anteriores</h2>
            <div class="mt-6 space-y-3">
                @forelse ($pastEvents as $event)
                    <div class="flex gap-3 rounded-xl border border-slate-200 bg-white p-4">
                        <span class="w-14 shrink-0 text-center"><span class="block font-display text-lg font-bold text-brand-800">{{ $event->starts_at->format('d/m') }}</span><span class="text-[11px] text-slate-400">{{ $event->starts_at->format('Y') }}</span></span>
                        <div class="min-w-0"><p class="text-sm font-semibold text-brand-900">{{ $event->title }}</p><p class="text-xs text-slate-500">{{ $event->typeLabel() }}@if ($event->location) · {{ $event->location }}@endif</p></div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Ainda não há eventos anteriores registrados.</p>
                @endforelse
            </div>
        </aside>
    </div>
</section>
@endsection
