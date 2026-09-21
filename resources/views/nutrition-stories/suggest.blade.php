@extends('layouts.app')

@section('title', 'Indicar uma história — Nutrição em Minas')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-12">
            <a href="{{ route('nutrition-stories.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mb-6">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
                Voltar para Nutrição em Minas
            </a>
            <h1 class="text-3xl font-bold text-slate-900">Indicar uma história</h1>
            <p class="text-slate-500 mt-2">
                Conhece um trabalho de destaque de um(a) nutricionista ou técnico(a) em nutrição em Minas Gerais? Conte pra gente. Sua indicação passa por uma análise da equipe de comunicação do CRN-9 antes de ser publicada.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-12">
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-semibold mb-1">Corrija os campos abaixo:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('nutrition-stories.suggest.store') }}" class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Título da história (ex.: nome do(a) profissional ou do projeto) *</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Área de atuação *</label>
                    <select name="area" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="">Selecione...</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area }}" @selected(old('area') === $area)>{{ $area }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Cidade / Região *</label>
                    <input type="text" name="region" value="{{ old('region') }}" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Cargo / Função</label>
                <input type="text" name="role" value="{{ old('role') }}" placeholder="Ex.: Nutricionista da rede municipal de saúde" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Resumo curto *</label>
                <textarea name="summary" rows="2" maxlength="500" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">{{ old('summary') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Conte a história completa *</label>
                <textarea name="body" rows="6" maxlength="5000" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">{{ old('body') }}</textarea>
            </div>

            <div class="grid sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Seu nome *</label>
                    <input type="text" name="submitter_name" value="{{ old('submitter_name') }}" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Seu e-mail *</label>
                    <input type="email" name="submitter_email" value="{{ old('submitter_email') }}" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
            </div>

            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition">
                Enviar indicação
            </button>
        </form>
    </section>
@endsection
