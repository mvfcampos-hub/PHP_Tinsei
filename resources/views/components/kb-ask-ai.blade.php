@props(['solutionType' => null])

<div
    x-data="{
        question: '',
        loading: false,
        asked: false,
        answer: '',
        sources: [],
        configured: true,
        errored: false,
        async ask() {
            if (!this.question.trim() || this.loading) return;
            this.loading = true;
            this.asked = true;
            this.answer = '';
            this.sources = [];
            this.errored = false;
            window.trackEvent && window.trackEvent('kb_ai_question_asked', { page_path: window.location.pathname });
            try {
                const res = await fetch('{{ route('kb.ask') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({ question: this.question, tipo: @js($solutionType) }),
                });
                const data = await res.json();
                if (!res.ok) {
                    this.errored = true;
                    this.answer = 'Não foi possível obter uma resposta agora. Tente novamente em instantes.';
                } else if (data.configured === false) {
                    this.configured = false;
                    this.answer = data.message;
                } else if (data.error) {
                    this.errored = true;
                    this.answer = data.message;
                } else {
                    this.answer = data.answer;
                    this.sources = data.sources || [];
                }
            } catch (e) {
                this.errored = true;
                this.answer = 'Não foi possível obter uma resposta agora. Tente novamente em instantes.';
            } finally {
                this.loading = false;
            }
        },
    }"
    class="rounded-2xl border border-brand-100 bg-gradient-to-br from-brand-50 to-white p-6 sm:p-8"
>
    <div class="flex items-center gap-3 mb-3">
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-700 text-white">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" /></svg>
        </span>
        <h2 class="font-bold text-slate-900 text-lg">Pergunte à nossa IA</h2>
    </div>
    <p class="text-sm text-slate-500 mb-4">
        Descreva sua dúvida e a IA busca a resposta nos manuais e artigos da nossa Base de Conhecimento.
    </p>

    <form @submit.prevent="ask()" class="flex flex-col sm:flex-row gap-3">
        <input
            type="text"
            x-model="question"
            placeholder="Ex.: Como faço uma transferência entre depósitos no DataClassic?"
            class="flex-1 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none"
        >
        <button
            type="submit"
            :disabled="loading"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 transition disabled:opacity-60"
        >
            <svg x-show="loading" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
            <span x-text="loading ? 'Perguntando...' : 'Perguntar'"></span>
        </button>
    </form>

    <div x-show="asked" x-cloak x-transition class="mt-5 rounded-xl bg-white border border-slate-200 p-5">
        <template x-if="loading">
            <p class="text-sm text-slate-500">Buscando a melhor resposta...</p>
        </template>
        <template x-if="!loading && answer">
            <div>
                <p class="text-sm text-slate-700 whitespace-pre-line" x-text="answer"></p>
                <template x-if="sources.length">
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Fontes consultadas</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="source in sources" :key="source.title">
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs text-slate-600" x-text="source.title"></span>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>
