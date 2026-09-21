@extends('layouts.app')

@section('title', 'Cadastrar Oportunidade')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mb-6">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
                Voltar para o banco de oportunidades
            </a>
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Cadastrar Oportunidade</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                O CRN-9 divulga, como cortesia, oportunidades de emprego para Nutricionistas e Técnicos em Nutrição e Dietética. Após o envio, sua vaga passa por uma análise da Secretaria e só aparece no site depois de aprovada.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
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

        <form method="POST" action="{{ route('jobs.submit.store') }}" class="space-y-8">
            @csrf

            <div class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">
                <h2 class="font-semibold text-slate-900">Dados da vaga</h2>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Título da vaga *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Empresa / Instituição</label>
                        <input type="text" name="company" value="{{ old('company') }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tipo de contrato</label>
                        <input type="text" name="contract_type" value="{{ old('contract_type') }}" placeholder="CLT, PJ, Estágio..." class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Cidade / Local</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Descrição da vaga *</label>
                    <textarea name="description" rows="6" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">
                <h2 class="font-semibold text-slate-900">Como os candidatos devem entrar em contato</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">E-mail para candidatura</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email') }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Telefone para candidatura</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Link externo para candidatura (opcional)</label>
                    <input type="url" name="external_url" value="{{ old('external_url') }}" placeholder="https://..." class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">
                <h2 class="font-semibold text-slate-900">Seus dados (não aparecem publicamente)</h2>
                <p class="text-xs text-slate-500">
                    Usados apenas pela Secretaria do CRN-9 para validar o anúncio e para que você possa solicitar a remoção da vaga depois que ela for preenchida.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Seu nome *</label>
                        <input type="text" name="submitter_name" value="{{ old('submitter_name') }}" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Seu telefone</label>
                        <input type="text" name="submitter_phone" value="{{ old('submitter_phone') }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Seu e-mail *</label>
                    <input type="email" name="submitter_email" value="{{ old('submitter_email') }}" required class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
            </div>

            <button type="submit" class="w-full inline-flex justify-center items-center rounded-lg bg-brand-600 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-700 transition">
                Enviar para análise
            </button>
        </form>
    </section>
@endsection
