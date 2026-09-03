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
                <li><a href="{{ route('news.index') }}" class="hover:text-white transition">Novidades</a></li>
                <li><a href="{{ route('events.index') }}" class="hover:text-white transition">Agenda</a></li>
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
                <li><a href="https://wa.me/5531997278589" target="_blank" rel="noopener" class="hover:text-white transition">(31) 99727-8589</a></li>
                <li><a href="tel:+553134168225" class="hover:text-white transition">(31) 3416-8225</a></li>
                <li><a href="mailto:atendimento@databit.com.br" class="hover:text-white transition">atendimento@databit.com.br</a></li>
            </ul>
            <div class="flex items-center gap-3 mt-4">
                <a href="https://www.facebook.com" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="Facebook">f</a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="Instagram">ig</a>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="LinkedIn">in</a>
                <a href="https://www.youtube.com" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="YouTube">yt</a>
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
