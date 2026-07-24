<footer class="bg-brand-950 text-brand-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-700 text-white font-bold">C9</span>
                <span class="font-bold text-white">CRN-9</span>
            </div>
            <p class="text-sm text-brand-200">
                Conselho Regional de Nutrição da 9ª Região — orientação, disciplina e fiscalização do exercício profissional da Nutrição.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wide mb-4">Institucional</h3>
            <ul class="space-y-2 text-sm text-brand-200">
                <li><a href="{{ route('pages.show', 'o-crn-9') }}" class="hover:text-white transition">O CRN-9</a></li>
                <li><a href="{{ route('pages.show', 'perguntas-frequentes') }}" class="hover:text-white transition">Perguntas Frequentes</a></li>
                <li><a href="{{ route('pages.show', 'identidade-visual-do-crn-9') }}" class="hover:text-white transition">Identidade Visual</a></li>
                <li><a href="{{ route('pages.show', 'fale-conosco') }}" class="hover:text-white transition">Fale Conosco</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wide mb-4">Serviços</h3>
            <ul class="space-y-2 text-sm text-brand-200">
                <li><a href="{{ route('jobs.index') }}" class="hover:text-white transition">Banco de Oportunidades</a></li>
                <li><a href="{{ route('magazines.index') }}" class="hover:text-white transition">Revista CRN-9</a></li>
                <li><a href="{{ route('inspectors.index') }}" class="hover:text-white transition">Fiscalização</a></li>
                <li><a href="{{ route('municipalities.index') }}" class="hover:text-white transition">Profissionais por Município</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wide mb-4">Contato</h3>
            <ul class="space-y-2 text-sm text-brand-200">
                <li>Endereço institucional (a confirmar)</li>
                <li>Telefone (a confirmar)</li>
                <li>crn9@crn9.org.br</li>
            </ul>
            <div class="flex items-center gap-3 mt-4">
                {{-- TODO: substituir pelos links reais das redes sociais do CRN-9 assim que recebidos --}}
                <a href="#" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="Facebook">f</a>
                <a href="#" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="Instagram">ig</a>
                <a href="#" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="LinkedIn">in</a>
            </div>
        </div>
    </div>
    <div class="border-t border-brand-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 text-xs text-brand-300 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ now()->year }} CRN-9 — Conselho Regional de Nutrição da 9ª Região. Todos os direitos reservados.</p>
            <p>Conteúdo institucional em migração — layout de demonstração.</p>
        </div>
    </div>
</footer>
