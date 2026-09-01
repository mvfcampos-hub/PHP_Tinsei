<div
    x-data="{
        show: false,
        init() {
            try {
                this.show = !localStorage.getItem('crn9_cookie_notice_dismissed');
            } catch (e) {
                this.show = true;
            }
        },
        dismiss() {
            this.show = false;
            try { localStorage.setItem('crn9_cookie_notice_dismissed', '1'); } catch (e) {}
        }
    }"
    x-show="show"
    x-cloak
    x-transition
    class="fixed inset-x-0 bottom-0 z-50 px-4 pb-4 sm:px-6"
>
    <div class="mx-auto max-w-3xl rounded-2xl border border-slate-200 bg-white shadow-xl p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center gap-4">
        <p class="text-sm text-slate-600 flex-1">
            Este site utiliza apenas cookies estritamente necessários ao seu funcionamento (sessão e proteção de formulários), sem rastreamento ou publicidade. Saiba mais na
            <a href="{{ route('pages.show', 'politica-de-cookies') }}" class="font-medium text-brand-700 hover:text-brand-800 underline">Política de Cookies</a>.
        </p>
        <button
            type="button"
            @click="dismiss()"
            class="shrink-0 inline-flex items-center justify-center rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800 transition"
        >
            Entendi
        </button>
    </div>
</div>
