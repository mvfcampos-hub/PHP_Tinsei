@extends('layouts.app')

@section('title', 'Instituições de Ensino')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Instituições de Ensino</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Instituições de Ensino Superior que oferecem o curso de Nutrição em Minas Gerais.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
        <form method="get" class="mb-8 flex flex-wrap gap-3">
            <input
                type="text" name="q" value="{{ request('q') }}"
                placeholder="Buscar por nome ou cidade..."
                class="w-full sm:w-72 rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
            >
            <select name="cidade" onchange="this.form.submit()" class="rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                <option value="">Todas as cidades</option>
                @foreach ($cities as $city)
                    <option value="{{ $city }}" @selected(request('cidade') === $city)>{{ $city }}</option>
                @endforeach
            </select>
            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 transition">
                Buscar
            </button>
            @if (request('q') || request('cidade'))
                <a href="{{ route('institutions.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700">Limpar filtros</a>
            @endif
        </form>

        <p class="text-sm text-slate-500 mb-4">{{ $institutions->total() }} instituição(ões) encontrada(s)</p>

        <div class="space-y-3">
            @forelse ($institutions as $institution)
                <div class="rounded-2xl border border-slate-200 bg-white p-5">
                    <h2 class="font-semibold text-slate-900">{{ $institution->name }}</h2>
                    <dl class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 text-sm text-slate-600">
                        @if ($institution->city)
                            <div class="flex gap-1"><dt class="font-medium text-slate-700">Cidade:</dt><dd>{{ $institution->city }}</dd></div>
                        @endif
                        @if ($institution->phone)
                            <div class="flex gap-1"><dt class="font-medium text-slate-700">Telefone:</dt><dd>{{ $institution->phone }}</dd></div>
                        @endif
                        @if ($institution->address)
                            <div class="flex gap-1 sm:col-span-2"><dt class="font-medium text-slate-700 shrink-0">Endereço:</dt><dd>{{ $institution->address }}</dd></div>
                        @endif
                        @if ($institution->email)
                            <div class="flex gap-1 sm:col-span-2"><dt class="font-medium text-slate-700 shrink-0">E-mail:</dt><dd class="break-all">{{ $institution->email }}</dd></div>
                        @endif
                    </dl>
                </div>
            @empty
                <p class="text-slate-500">Nenhuma instituição encontrada.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $institutions->links() }}
        </div>
    </section>
@endsection
