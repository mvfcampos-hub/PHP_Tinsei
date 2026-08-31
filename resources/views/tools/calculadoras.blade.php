@extends('layouts.app')

@section('title', 'Calculadoras de Dimensionamento de Equipe')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Calculadoras de Dimensionamento de Equipe</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Informe as métricas da sua unidade e obtenha o parecer técnico de carga horária e número mínimo de
                nutricionistas exigidos pela Resolução CFN nº 380/2005 (Anexo III).
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12 space-y-12">

        {{-- UAN / Alimentação Coletiva --}}
        <div
            x-data="{
                refeicoes: null,
                modalidade: 'uma_grande',
                tabela1: [
                    { max: 100,  uma_grande: {n: 1, h: 10}, duas_grandes: {n: 1, h: 10} },
                    { max: 200,  uma_grande: {n: 1, h: 15}, duas_grandes: {n: 1, h: 15} },
                    { max: 300,  uma_grande: {n: 1, h: 20}, duas_grandes: {n: 1, h: 20} },
                    { max: 500,  uma_grande: {n: 1, h: 30}, duas_grandes: {n: 1, h: 30} },
                    { max: 1000, uma_grande: {n: 1, h: 40}, duas_grandes: {n: 2, h: 40} },
                    { max: 1500, uma_grande: {n: 2, h: 40}, duas_grandes: {n: 2, h: 40} },
                    { max: 2500, uma_grande: {n: 2, h: 40}, duas_grandes: {n: 3, h: 40} },
                ],
                tabela2: [
                    { max: 5000,  n: 1, h: 15 },
                    { max: 8000,  n: 1, h: 20 },
                    { max: 12000, n: 1, h: 30 },
                    { max: 20000, n: 1, h: 40 },
                ],
                get resultado() {
                    if (!this.refeicoes || this.refeicoes <= 0) return null;
                    if (this.modalidade === 'congelados') {
                        if (this.refeicoes > 20000) return { individualizado: true };
                        const row = this.tabela2.find(r => this.refeicoes <= r.max);
                        return { n: row.n, h: row.h };
                    }
                    if (this.refeicoes > 2500) return { individualizado: true };
                    const row = this.tabela1.find(r => this.refeicoes <= r.max);
                    return row[this.modalidade];
                }
            }"
            class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8"
        >
            <h2 class="text-xl font-bold text-slate-900">Alimentação Coletiva / UAN</h2>
            <p class="text-sm text-slate-500 mt-1">
                Empresas de alimentação coletiva, serviços de autogestão, restaurantes, cozinhas de estabelecimentos
                de saúde, serviços de buffet e alimentos congelados.
            </p>

            <div class="mt-6 grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Modalidade de serviço</label>
                    <select x-model="modalidade" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="uma_grande">Uma grande refeição/dia (por refeições/dia)</option>
                        <option value="duas_grandes">02 grandes refeições ou mais/dia (por refeições/dia)</option>
                        <option value="congelados">Alimentos congelados, buffet ou rotisseria (por porções/dia)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        <span x-show="modalidade !== 'congelados'">Número de refeições/dia</span>
                        <span x-show="modalidade === 'congelados'">Número de porções/dia</span>
                    </label>
                    <input type="number" min="1" x-model.number="refeicoes" placeholder="Ex.: 350"
                        class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
            </div>

            <template x-if="resultado && resultado.individualizado">
                <div class="mt-6 rounded-lg bg-amber-50 border border-amber-200 p-4 text-sm text-amber-900">
                    Volume acima do limite de referência da tabela. A Resolução determina <strong>estudo individualizado</strong>
                    pelo CRN-9 para definir o dimensionamento adequado.
                </div>
            </template>

            <template x-if="resultado && !resultado.individualizado">
                <div class="mt-6 rounded-lg bg-brand-50 border border-brand-200 p-4">
                    <p class="text-sm text-slate-600">Parecer técnico estimado:</p>
                    <p class="text-lg font-bold text-brand-800 mt-1">
                        <span x-text="resultado.n"></span> nutricionista(s) &middot; <span x-text="resultado.h"></span>h semanais (RT)
                    </p>
                </div>
            </template>

            <p class="text-xs text-slate-400 mt-4">Base normativa: Resolução CFN nº 380/2005, Anexo III, Item I-A (Tabelas 01 e 02).</p>
        </div>

        {{-- Hospital / SND --}}
        <div
            x-data="{
                leitos: null,
                nivel: 'primario',
                bases: { primario: 60, secundario: 30, terciario: 15 },
                get resultado() {
                    if (!this.leitos || this.leitos <= 0) return null;
                    const base = this.bases[this.nivel];
                    const n = Math.ceil(this.leitos / base);
                    return { n, h: 30 };
                }
            }"
            class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8"
        >
            <h2 class="text-xl font-bold text-slate-900">Área Hospitalar / SND</h2>
            <p class="text-sm text-slate-500 mt-1">
                Hospitais e clínicas em geral, por nível de complexidade do atendimento nutricional.
            </p>

            <div class="mt-6 grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nível de complexidade</label>
                    <select x-model="nivel" class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="primario">Primário (sem fatores de risco nutricional)</option>
                        <option value="secundario">Secundário (fatores de risco associados)</option>
                        <option value="terciario">Terciário (cuidados dietéticos específicos + risco associado)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Número de leitos/pacientes</label>
                    <input type="number" min="1" x-model.number="leitos" placeholder="Ex.: 80"
                        class="w-full rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
            </div>

            <template x-if="resultado">
                <div class="mt-6 rounded-lg bg-brand-50 border border-brand-200 p-4">
                    <p class="text-sm text-slate-600">Parecer técnico estimado:</p>
                    <p class="text-lg font-bold text-brand-800 mt-1">
                        <span x-text="resultado.n"></span> nutricionista(s) &middot; <span x-text="resultado.h"></span>h semanais cada
                    </p>
                </div>
            </template>

            <p class="text-xs text-slate-400 mt-4">
                Base normativa: Resolução CFN nº 380/2005, Anexo III, Item II-A. A assistência nutricional diária ao
                paciente hospitalizado deve ser de, no mínimo, 12h/dia ininterruptas, inclusive finais de semana e feriados.
            </p>
        </div>

        <div class="rounded-xl border border-amber-200 bg-amber-50 p-6 text-sm text-amber-900">
            Os resultados são estimativas automáticas com base nos parâmetros numéricos de referência da Resolução
            CFN nº 380/2005 e não substituem o estudo individualizado do CRN-9 nem a análise de critérios específicos
            (estrutura física, centralização, complexidade de cardápios, entre outros) previstos no Anexo IV da Resolução.
        </div>
    </section>
@endsection
