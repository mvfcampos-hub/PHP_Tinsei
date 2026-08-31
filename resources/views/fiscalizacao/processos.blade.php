@extends('layouts.app')

@section('title', 'Processos de Fiscalização e Ética em Andamento')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Processos de Fiscalização e Ética em Andamento</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Painel de transparência com os processos ético-disciplinares e de fiscalização conduzidos pelo CRN-9,
                identificados por código para preservar o sigilo das partes envolvidas.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Categoria</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Código</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Assunto</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Início do Processo</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Situação Atual</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($processes as $process)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $process->category }}</td>
                            <td class="px-4 py-3 font-mono font-semibold text-brand-700">{{ $process->code }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $process->subject }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $process->started_at?->format('Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
                                    {{ $process->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">Nenhum processo cadastrado no momento.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-6 text-sm text-amber-900">
            Os códigos identificam cada processo sem expor a identidade das partes envolvidas. Categoria "A" refere-se
            a processos éticos; categoria "B", a processos de fiscalização. Este painel é atualizado periodicamente
            pela equipe responsável através do Painel Administrativo.
        </div>
    </section>
@endsection
