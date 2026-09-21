@extends('layouts.app')

@section('title', $term !== '' ? "Busca: {$term}" : 'Busca')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Resultados da busca</h1>

            <form action="{{ route('search.index') }}" method="GET" class="mt-6 flex gap-2">
                <input
                    type="search"
                    name="q"
                    value="{{ $term }}"
                    placeholder="Buscar notícias, páginas, vagas, revistas..."
                    class="flex-1 rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500"
                >
                <button type="submit" class="rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 transition">
                    Buscar
                </button>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-10">
        @if ($term === '')
            <p class="text-slate-500">Digite um termo acima para buscar em todo o site do CRN-9.</p>
        @elseif ($results->isEmpty())
            <p class="text-slate-500">Nenhum resultado encontrado para <strong>"{{ $term }}"</strong>.</p>
        @else
            <p class="text-sm text-slate-500 mb-6">{{ $results->count() }} resultado(s) para "{{ $term }}"</p>
            <ul class="space-y-4">
                @foreach ($results as $result)
                    <li class="rounded-xl border border-slate-200 bg-white p-5 hover:shadow-md transition">
                        <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700 mb-2">
                            {{ $result['type'] }}
                        </span>
                        <h2 class="font-semibold text-slate-900">
                            <a href="{{ $result['url'] }}" class="hover:text-brand-700 transition">{{ $result['title'] }}</a>
                        </h2>
                        @if (!empty($result['excerpt']))
                            <p class="text-sm text-slate-600 mt-1">{{ $result['excerpt'] }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
