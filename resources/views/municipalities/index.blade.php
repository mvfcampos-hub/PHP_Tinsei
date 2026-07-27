@extends('layouts.app')

@section('title', 'Profissionais por Município')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Profissionais por Município</h1>
            <p class="text-slate-500 mt-2">
                Quantidade de profissionais ativos (nutricionistas, TND e pessoas jurídicas) por município de Minas Gerais
                @if ($referenceDate)
                    &mdash; atualizado em {{ \Illuminate\Support\Carbon::parse($referenceDate)->format('d/m/Y') }}
                @endif
            </p>
            <div class="mt-4 flex flex-wrap gap-3">
                <p class="inline-flex items-center rounded-full bg-brand-50 px-4 py-1.5 text-sm font-medium text-brand-700">
                    Total de profissionais: {{ number_format($totalProfessionals, 0, ',', '.') }}
                </p>
                <p class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1.5 text-sm font-medium text-slate-700">
                    Municípios cobertos: {{ number_format($totalMunicipalities, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
        <form method="get" class="mb-6">
            <input
                type="text" name="municipio" value="{{ request('municipio') }}"
                placeholder="Buscar município..."
                class="w-full sm:w-80 rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm"
            >
        </form>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-slate-700">Município</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-700">Nutricionistas</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-700">TND</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-700">Pessoas Jurídicas</th>
                        <th class="px-6 py-3 text-right font-semibold text-slate-700">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($counts as $count)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-3 text-slate-900 font-medium">{{ $count->municipality }}/{{ $count->state }}</td>
                            <td class="px-4 py-3 text-right text-slate-600">{{ number_format($count->nutritionists_count, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-slate-600">{{ number_format($count->technicians_count, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-slate-600">{{ number_format($count->legal_entities_count, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-right text-slate-900 font-semibold">{{ number_format($count->total_count, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-slate-500">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $counts->links() }}
        </div>
    </section>
@endsection
