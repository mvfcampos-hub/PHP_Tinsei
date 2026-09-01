<div
    x-data="{
        open: false,
        fontScale: 1,
        highContrast: false,
        init() {
            this.fontScale = parseInt(localStorage.getItem('crn9_font_scale') || '1', 10);
            this.highContrast = localStorage.getItem('crn9_high_contrast') === '1';
        },
        applyFont() {
            document.documentElement.classList.remove('font-scale-2', 'font-scale-3');
            if (this.fontScale === 2) document.documentElement.classList.add('font-scale-2');
            if (this.fontScale === 3) document.documentElement.classList.add('font-scale-3');
            localStorage.setItem('crn9_font_scale', this.fontScale);
        },
        increaseFont() { if (this.fontScale < 3) { this.fontScale++; this.applyFont(); } },
        decreaseFont() { if (this.fontScale > 1) { this.fontScale--; this.applyFont(); } },
        resetFont() { this.fontScale = 1; this.applyFont(); },
        toggleContrast() {
            this.highContrast = !this.highContrast;
            document.documentElement.classList.toggle('high-contrast', this.highContrast);
            localStorage.setItem('crn9_high_contrast', this.highContrast ? '1' : '0');
        },
    }"
    class="relative"
>
    <button
        @click="open = !open"
        :aria-expanded="open.toString()"
        aria-haspopup="true"
        aria-label="Opções de acessibilidade"
        class="p-2 rounded-lg text-slate-700 hover:bg-slate-100"
    >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <circle cx="12" cy="5" r="1.75" fill="currentColor" stroke="none" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 9.5c2.5.9 5 1.3 7.5 1.3s5-.4 7.5-1.3M12 10.8V21m0-10.2l-3.5 4.6M12 10.8l3.5 4.6" />
        </svg>
    </button>

    <div
        x-show="open"
        x-cloak
        x-transition
        @click.outside="open = false"
        @keydown.escape.window="open = false"
        class="absolute right-0 top-full mt-2 w-64 rounded-xl border border-slate-200 bg-white shadow-xl p-4 z-50"
        role="menu"
        aria-label="Opções de acessibilidade"
    >
        <p class="text-xs font-bold uppercase tracking-wide text-brand-700 mb-2">Tamanho do texto</p>
        <div class="flex items-center gap-2 mb-4">
            <button
                @click="decreaseFont()"
                :disabled="fontScale <= 1"
                class="flex-1 rounded-lg border border-slate-300 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed"
                aria-label="Diminuir tamanho do texto"
            >A-</button>
            <button
                @click="resetFont()"
                class="flex-1 rounded-lg border border-slate-300 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                aria-label="Tamanho de texto padrão"
            >A</button>
            <button
                @click="increaseFont()"
                :disabled="fontScale >= 3"
                class="flex-1 rounded-lg border border-slate-300 py-1.5 text-base font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed"
                aria-label="Aumentar tamanho do texto"
            >A+</button>
        </div>

        <p class="text-xs font-bold uppercase tracking-wide text-brand-700 mb-2">Contraste</p>
        <button
            @click="toggleContrast()"
            :aria-pressed="highContrast.toString()"
            class="w-full flex items-center justify-between rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
        >
            <span>Alto contraste</span>
            <span class="inline-flex h-5 w-9 items-center rounded-full transition-colors" :class="highContrast ? 'bg-brand-700' : 'bg-slate-300'">
                <span class="h-4 w-4 rounded-full bg-white shadow transform transition-transform" :class="highContrast ? 'translate-x-4' : 'translate-x-0.5'"></span>
            </span>
        </button>
    </div>
</div>
