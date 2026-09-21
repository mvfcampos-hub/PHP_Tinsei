@extends('layouts.app')

@section('title', 'Repositório de Modelos Editáveis')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Repositório de Modelos Editáveis</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Documentos prontos para baixar e usar na sua rotina profissional, ajustados às exigências normativas
                vigentes. Adapte os campos entre colchetes conforme o caso concreto antes de utilizar.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
        @forelse ($templates as $category => $items)
            <div class="mb-10">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">{{ $category }}</h2>
                <div class="grid sm:grid-cols-2 gap-5">
                    @foreach ($items as $template)
                        <div class="rounded-2xl border border-slate-200 bg-white p-5">
                            <h3 class="font-semibold text-slate-900">{{ $template->title }}</h3>
                            @if ($template->description)
                                <p class="text-sm text-slate-500 mt-2 leading-relaxed">{{ $template->description }}</p>
                            @endif

                            @if ($template->files->isNotEmpty())
                                <ul class="mt-4 space-y-2">
                                    @foreach ($template->files as $file)
                                        <li>
                                            <a href="{{ $file->url }}" target="_blank" rel="noopener"
                                                class="inline-flex items-center gap-2 text-sm font-medium text-brand-700 hover:text-brand-800">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" /></svg>
                                                {{ $file->label }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xs text-slate-400 mt-4">Nenhum arquivo disponível no momento.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-slate-500">Nenhum modelo disponível no momento.</p>
        @endforelse

        <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-6 text-sm text-amber-900">
            Os modelos aqui disponibilizados são referências gerais. A responsabilidade técnica e legal pelo
            preenchimento e uso de cada documento é do(a) nutricionista responsável pelo atendimento ou serviço.
        </div>
    </section>
@endsection
