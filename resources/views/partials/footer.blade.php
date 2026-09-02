<footer class="bg-brand-950 text-brand-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <x-logo variant="white" class="mb-4" />
            <p class="text-sm text-brand-200">
                Há mais de 30 anos desenvolvendo tecnologia para simplificar a gestão empresarial:
                ERP, Cloud, mobilidade, atendimento ao cliente e serviços de TI para todo o Brasil.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wide mb-4">Produtos</h3>
            <ul class="space-y-2 text-sm text-brand-200">
                <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Todos os produtos</a></li>
                <li><a href="{{ route('cloud.show') }}" class="hover:text-white transition">DataCloud</a></li>
                <li><a href="https://databit.com.br/mobile.html" target="_blank" rel="noopener" class="hover:text-white transition">DataMobile</a></li>
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
                <li><a href="{{ route('pages.show', 'fale-conosco') }}" class="hover:text-white transition">Fale Conosco</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wide mb-4">Contato</h3>
            <ul class="space-y-2 text-sm text-brand-200">
                <li>Belo Horizonte/MG</li>
                <li><a href="https://wa.me/5531997278589" target="_blank" rel="noopener" class="hover:text-white transition">(31) 99727-8589</a></li>
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
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 text-xs text-brand-300 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ now()->year }} Databit Tecnologia e Sistemas. Todos os direitos reservados.</p>
            <p>Conteúdo em migração a partir do site atual — layout de demonstração.</p>
        </div>
    </div>
</footer>
