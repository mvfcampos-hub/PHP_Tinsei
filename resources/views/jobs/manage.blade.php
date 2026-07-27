@extends('layouts.app')

@section('title', 'Gerenciar Oportunidade')

@section('content')
    <section class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-16">
        @if (session('submitted'))
            <div class="mb-6 rounded-xl border border-brand-200 bg-brand-50 p-4 text-sm text-brand-800">
                <p class="font-semibold mb-1">Vaga enviada com sucesso!</p>
                <p>Sua oportunidade foi enviada para análise da Secretaria do CRN-9 e aparecerá no Banco de Oportunidades assim que for aprovada.</p>
            </div>
            <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                <p class="font-semibold mb-1">Guarde este endereço</p>
                <p>Este link é a sua forma de acompanhar o status da vaga e de solicitar a remoção quando ela for preenchida. Ele não é enviado por e-mail — salve-o agora:</p>
                <p class="mt-2 break-all font-mono text-xs bg-white rounded-lg border border-amber-200 px-3 py-2">{{ url()->current() }}</p>
            </div>
        @endif

        @if (session('removed'))
            <div class="mb-6 rounded-xl border border-brand-200 bg-brand-50 p-4 text-sm text-brand-800">
                Remoção confirmada — sua vaga não aparece mais no Banco de Oportunidades.
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">{{ $job->title }}</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        @if ($job->company) {{ $job->company }} &middot; @endif
                        {{ $job->location }}
                    </p>
                </div>

                @if ($job->status === 'pending')
                    <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700 shrink-0">
                        Aguardando aprovação
                    </span>
                @elseif ($job->status === 'rejected')
                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700 shrink-0">
                        Não aprovada
                    </span>
                @elseif (! $job->is_active)
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 shrink-0">
                        Removida
                    </span>
                @else
                    <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700 shrink-0">
                        Publicada
                    </span>
                @endif
            </div>

            <p class="text-sm text-slate-600 mt-4">{{ $job->description }}</p>

            @if ($job->status === 'approved' && $job->is_active)
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <p class="text-sm text-slate-600 mb-3">Vaga preenchida? Você pode remover o anúncio do Banco de Oportunidades a qualquer momento.</p>
                    <form method="POST" action="{{ route('jobs.remove', $job->removal_token) }}" onsubmit="return confirm('Confirma a remoção desta vaga do Banco de Oportunidades?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-red-300 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50 transition">
                            Solicitar remoção (vaga preenchida)
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </section>
@endsection
