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

        <div class="mt-8 rounded-xl border border-amber-200 bg-amber-50 p-6 text-sm text-amber-900">
            Os números acima são exemplos ilustrativos da estrutura deste painel. Serão substituídos pelos dados
            reais e periodicamente atualizados pela equipe de fiscalização do CRN-9 através do Painel Administrativo.
        </div>
    </section>
@endsection
