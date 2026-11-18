@extends('layouts.app')

@section('title', 'Onde estamos')
@section('description', 'Mapa de clientes da Tinsei: clientes ativos em todas as regiões do Brasil e no exterior, a partir da sede em Belo Horizonte.')

@section('content')
<x-page-hero eyebrow="Presença nacional" title="Onde estamos"
    subtitle="Com sede em Belo Horizonte, a Tinsei distribui equipamentos, suprimentos e peças para clientes em todas as regiões do Brasil — e também no exterior." />

<section class="relative overflow-hidden bg-brand-950 py-20">
    <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    <div class="container-site relative">
        <x-brazil-map :map="$map" />
    </div>
</section>

<section class="bg-white py-20">
    <div class="container-site">
        <x-section-heading eyebrow="Detalhamento" title="Clientes ativos por estado" />
        <div class="mt-10 overflow-hidden rounded-2xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-5 py-3">UF</th><th class="px-5 py-3">Estado</th><th class="hidden px-5 py-3 sm:table-cell">Região</th><th class="px-5 py-3 text-right">Clientes ativos</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach ($map['ranking'] as $row)
                        <tr class="hover:bg-brand-50/50">
                            <td class="px-5 py-3 font-bold text-brand-700">{{ $row->code }}</td>
                            <td class="px-5 py-3 text-brand-900">{{ $row->name }}</td>
                            <td class="hidden px-5 py-3 text-slate-500 sm:table-cell">{{ \App\Models\StateClientCount::regionOf($row->code) }}</td>
                            <td class="px-5 py-3 text-right tabular-nums font-semibold text-brand-900">{{ br_number($row->client_count) }}</td>
                        </tr>
                    @endforeach
                    @if ($map['abroad'] > 0)
                        <tr class="bg-gold-50/60"><td class="px-5 py-3 font-bold text-gold-700">EX</td><td class="px-5 py-3 text-brand-900">Exterior</td><td class="hidden px-5 py-3 text-slate-500 sm:table-cell">—</td><td class="px-5 py-3 text-right font-semibold tabular-nums text-brand-900">{{ br_number($map['abroad']) }}</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
