@extends('layouts.app')

@section('title', 'Agenda')
@section('description', 'Agenda Databit: eventos, webinars, treinamentos e lançamentos de produtos.')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Agenda</h1>
            <p class="text-slate-500 mt-2">Eventos, webinars, treinamentos e lançamentos de produtos da Databit</p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-xl font-bold text-slate-900 mb-6">Próximos compromissos</h2>
        <div class="space-y-4 mb-16">
            @forelse ($upcomingEvents as $event)
                <x-event-card :event="$event" />
            @empty
                <p class="text-slate-500">Nenhum evento futuro cadastrado no momento.</p>
            @endforelse
        </div>

        @if ($pastEvents->isNotEmpty())
            <h2 class="text-xl font-bold text-slate-900 mb-6">Já aconteceu</h2>
            <div class="space-y-4 opacity-75">
                @foreach ($pastEvents as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        @endif
    </section>
@endsection
