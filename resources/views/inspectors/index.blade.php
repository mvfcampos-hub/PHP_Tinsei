@extends('layouts.app')

@section('title', 'Fiscalização')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Fiscalização</h1>
            <p class="text-slate-500 mt-2">Conheça a equipe responsável pela fiscalização do exercício profissional</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($inspectors as $inspector)
                <div class="rounded-2xl border border-slate-200 bg-white p-5 text-center">
                    <div class="mx-auto h-20 w-20 rounded-full bg-slate-100 overflow-hidden mb-4">
                        @if ($inspector->photo)
                            <img src="{{ Storage::url($inspector->photo) }}" alt="{{ $inspector->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-brand-100 text-brand-700 font-semibold">
                                {{ collect(explode(' ', $inspector->name))->map(fn ($n) => $n[0])->take(2)->implode('') }}
                            </div>
                        @endif
                    </div>
                    <h3 class="font-semibold text-slate-900">{{ $inspector->name }}</h3>
                    <p class="text-sm text-brand-700">{{ $inspector->role }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $inspector->region }}</p>
                </div>
            @empty
                <p class="text-slate-500 col-span-full">Equipe de fiscalização em atualização.</p>
            @endforelse
        </div>
    </section>
@endsection
