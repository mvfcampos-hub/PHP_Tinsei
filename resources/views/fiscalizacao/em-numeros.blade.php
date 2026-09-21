@extends('layouts.app')

@section('title', 'Fiscalização em Números')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Fiscalização em Números</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Transparência é também mostrar o trabalho que o CRN-9 realiza. Confira os indicadores consolidados
                da atuação da equipe de fiscalização.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
        @if ($stats->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($stats as $stat)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center">
                        <p class="text-3xl font-bold text-brand-700">{{ $stat->value }}</p>
                        <p class="text-sm text-slate-500 mt-2">{{ $stat->label }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-slate-500">Nenhum indicador cadastrado no momento.</p>
        @endif

        @if ($regionStats->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Visitas de Fiscalização por Região</h2>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">
                    @foreach ($regionStats as $region)
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700">{{ $region->region }}</span>
                                <span class="text-slate-500">{{ $region->visits_count }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full bg-brand-600" style="width: {{ round(($region->visits_count / $maxRegionVisits) * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-slate-400 mt-3">
                    Regiões correspondentes à Sede e às Delegacias Regionais do CRN-9 em Minas Gerais.
                </p>
            </div>
        @endif

        <div class="mt-8 rounded-xl border border-amber-200 bg-amber-50 p-6 text-sm text-amber-900">
            Os números acima são exemplos ilustrativos da estrutura deste painel. Serão substituídos pelos dados
            reais e periodicamente atualizados pela equipe de fiscalização do CRN-9 através do Painel Administrativo.
        </div>
    </section>
@endsection
