<div
    x-data="{ visible: false }"
    x-init="visible = !localStorage.getItem('databit-cookie-consent')"
    x-show="visible"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-5 left-5 right-5 sm:right-auto sm:bottom-6 sm:left-6 z-50 max-w-sm rounded-2xl border border-slate-200 bg-white shadow-xl p-5"
    role="dialog"
    aria-label="Aviso de cookies"
>
    <p class="text-sm text-slate-600">
        Usamos cookies necessários para o funcionamento do site e, mediante o seu consentimento, cookies de análise de audiência (Google Analytics) para entender como o site é usado. Saiba mais na nossa
        <a href="{{ route('pages.show', 'politicas-de-cookies') }}" class="font-semibold text-brand-700 hover:underline">Política de Cookies</a>.
    </p>
    <div class="flex flex-wrap items-center gap-2 mt-4">
        <button
            @click="
                visible = false;
                localStorage.setItem('databit-cookie-consent', 'accepted');
                if (window.loadGoogleAnalytics) window.loadGoogleAnalytics();
            "
            class="inline-flex items-center rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800 transition"
        >
            Aceitar
        </button>
        <button
            @click="visible = false; localStorage.setItem('databit-cookie-consent', 'declined')"
            class="inline-flex items-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition"
        >
            Recusar
        </button>
        <a href="{{ route('pages.show', 'politicas-de-cookies') }}" class="inline-flex items-center rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
            Saiba mais
        </a>
    </div>
</div>
