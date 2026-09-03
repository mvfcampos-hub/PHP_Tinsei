<footer class="bg-brand-950 text-brand-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <x-logo variant="white" class="mb-4" />
            <p class="text-sm text-brand-200">
                Especialistas em ERP, serviços de TI e produtos de informática — há mais de 30 anos simplificando
                a gestão empresarial em todo o Brasil.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wide mb-4">Sistemas</h3>
            <ul class="space-y-2 text-sm text-brand-200">
                <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Todos os sistemas</a></li>
                <li><a href="{{ route('cloud.show') }}" class="hover:text-white transition">DataCloud</a></li>
                <li><a href="{{ route('it-services.show') }}" class="hover:text-white transition">Serviços de TI</a></li>
                <li><a href="https://datasac.com.br" target="_blank" rel="noopener" class="hover:text-white transition">DataSAC</a></li>
                <li><a href="https://datamdfe.com.br" target="_blank" rel="noopener" class="hover:text-white transition">DataMDFe</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wide mb-4">Institucional</h3>
            <ul class="space-y-2 text-sm text-brand-200">
                <li><a href="{{ route('pages.show', 'grupo-databit') }}" class="hover:text-white transition">Grupo Databit</a></li>
                <li><a href="{{ route('news.index') }}" class="hover:text-white transition">Notícias</a></li>
                <li><a href="{{ route('events.index') }}" class="hover:text-white transition">Agenda</a></li>
                <li><a href="{{ route('kb.index') }}" class="hover:text-white transition">Base de Conhecimento</a></li>
                <li><a href="{{ route('pages.show', 'perguntas-frequentes') }}" class="hover:text-white transition">Perguntas Frequentes</a></li>
                <li><a href="{{ route('pages.show', 'politicas-de-privacidade') }}" class="hover:text-white transition">Políticas de Privacidade</a></li>
                <li><a href="{{ route('pages.show', 'politicas-de-cookies') }}" class="hover:text-white transition">Políticas de Cookies</a></li>
                <li><a href="mailto:relacionamento@databit.com.br" class="hover:text-white transition">Ouvidoria</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wide mb-4">Contato</h3>
            <ul class="space-y-2 text-sm text-brand-200">
                <li>R. Mário Campos, 197 - Inconfidência, Belo Horizonte/MG</li>
                <li><a href="https://wa.me/553134168225" target="_blank" rel="noopener" class="hover:text-white transition">(31) 3416-8225</a></li>
                <li><a href="tel:+553134168225" class="hover:text-white transition">(31) 3416-8225</a></li>
                <li><a href="mailto:atendimento@databit.com.br" class="hover:text-white transition">atendimento@databit.com.br</a></li>
            </ul>
            <div class="flex items-center gap-3 mt-4">
                <a href="https://www.facebook.com" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-accent-500 transition" aria-label="Facebook">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94z"/></svg>
                </a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-accent-500 transition" aria-label="Instagram">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2c2.72 0 3.06.01 4.12.06 1.06.05 1.79.22 2.43.47.66.26 1.21.6 1.76 1.15.5.5.9 1.1 1.15 1.76.25.64.42 1.37.47 2.43C21.99 8.94 22 9.28 22 12s-.01 3.06-.06 4.12c-.05 1.06-.22 1.79-.47 2.43a4.9 4.9 0 01-1.15 1.76c-.5.5-1.1.9-1.76 1.15-.64.25-1.37.42-2.43.47C15.06 21.99 14.72 22 12 22s-3.06-.01-4.12-.06c-1.06-.05-1.79-.22-2.43-.47a4.9 4.9 0 01-1.76-1.15 4.9 4.9 0 01-1.15-1.76c-.25-.64-.42-1.37-.47-2.43C2.01 15.06 2 14.72 2 12s.01-3.06.06-4.12c.05-1.06.22-1.79.47-2.43.26-.66.6-1.21 1.15-1.76A4.9 4.9 0 015.45.54c.64-.25 1.37-.42 2.43-.47C8.94.01 9.28 0 12 0zm0 5a5 5 0 100 10 5 5 0 000-10zm0 8.2a3.2 3.2 0 110-6.4 3.2 3.2 0 010 6.4zm5.2-8.4a1.17 1.17 0 100-2.34 1.17 1.17 0 000 2.34z"/></svg>
                </a>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-accent-500 transition" aria-label="LinkedIn">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.62 0 4.29 2.38 4.29 5.48v6.26zM5.34 7.43a2.07 2.07 0 110-4.13 2.07 2.07 0 010 4.13zM7.12 20.45H3.56V9h3.56v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z"/></svg>
                </a>
                <a href="https://www.youtube.com" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-accent-500 transition" aria-label="YouTube">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.5 6.2a3.02 3.02 0 00-2.12-2.14C19.51 3.5 12 3.5 12 3.5s-7.51 0-9.38.56A3.02 3.02 0 00.5 6.2 31.6 31.6 0 000 12a31.6 31.6 0 00.5 5.8 3.02 3.02 0 002.12 2.14c1.87.56 9.38.56 9.38.56s7.51 0 9.38-.56a3.02 3.02 0 002.12-2.14A31.6 31.6 0 0024 12a31.6 31.6 0 00-.5-5.8zM9.6 15.6V8.4l6.4 3.6-6.4 3.6z"/></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="border-t border-brand-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <a
                href="{{ route('hardware.index') }}"
                class="group flex flex-col sm:flex-row items-center gap-5 rounded-2xl border border-brand-800 bg-brand-900 p-6 hover:border-accent-500 transition"
            >
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-accent-500/15 text-accent-400">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                </span>
                <div class="flex-1 text-center sm:text-left">
                    <span class="text-xs font-semibold text-accent-400 uppercase tracking-wide">Também na Databit</span>
                    <h3 class="text-lg font-bold text-white mt-1">Produtos de informática</h3>
                    <p class="text-sm text-brand-200 mt-1">Notebooks, desktops, servidores, periféricos, celulares, firewall, wi-fi, nobreak e CFTV — apoiamos a escolha e a compra do equipamento certo.</p>
                </div>
                <span class="shrink-0 inline-flex items-center gap-1 rounded-lg bg-accent-500 px-5 py-2.5 text-sm font-semibold text-white group-hover:bg-accent-600 transition">
                    Ver produtos
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </span>
            </a>
        </div>
    </div>

    <div class="border-t border-brand-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 text-xs text-brand-300 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ now()->year }} Databit Tecnologia e Sistemas. Todos os direitos reservados.</p>
            <p>Conteúdo em migração a partir do site atual — layout de demonstração.</p>
        </div>
    </div>
</footer>
