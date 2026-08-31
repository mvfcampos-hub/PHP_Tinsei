<footer class="bg-brand-950 text-brand-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('images/brand/logo-crn9-compacto.png') }}" alt="CRN-9" class="h-9 w-auto brightness-0 invert">
            </div>
            <p class="text-sm text-brand-200">
                Conselho Regional de Nutrição da 9ª Região — orientação, disciplina e fiscalização do exercício profissional da Nutrição.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wide mb-4">Institucional</h3>
            <ul class="space-y-2 text-sm text-brand-200">
                <li><a href="{{ route('pages.show', 'o-crn-9') }}" class="hover:text-white transition">O CRN-9</a></li>
                <li><a href="{{ route('faqs.index') }}" class="hover:text-white transition">Perguntas Frequentes</a></li>
                <li><a href="{{ route('pages.show', 'identidade-visual-do-crn-9') }}" class="hover:text-white transition">Identidade Visual</a></li>
                <li><a href="{{ route('pages.show', 'fale-conosco') }}" class="hover:text-white transition">Fale Conosco</a></li>
                <li><a href="{{ route('pages.show', 'lgpd') }}" class="hover:text-white transition">Política de Privacidade</a></li>
                <li><a href="{{ route('pages.show', 'politica-de-cookies') }}" class="hover:text-white transition">Política de Cookies</a></li>
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
                <li>R. Maranhão, 310, 4º Andar — Santa Efigênia, Belo Horizonte/MG</li>
                <li>(31) 3226-8403</li>
                <li>crn9@crn9.org.br</li>
            </ul>
            <div class="flex items-center gap-3 mt-4">
                <a href="https://www.facebook.com/CRN9online" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="Facebook">f</a>
                <a href="https://www.instagram.com/crn9online/" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="Instagram">ig</a>
                <a href="https://www.youtube.com/channel/UCWIAlOTOXRyU3TlguLHgcuw" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="YouTube">yt</a>
                <a href="https://api.whatsapp.com/send/?phone=5531995917825&amp;text=Ol%C3%A1!%20Gostaria%20de%20falar%20com%20a%20equipe%20do%20CRN9." target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 hover:bg-brand-700 transition" aria-label="WhatsApp">wa</a>
            </div>
        </div>
    </div>
    <div class="border-t border-brand-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 text-xs text-brand-300 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ now()->year }} CRN-9 — Conselho Regional de Nutrição da 9ª Região. Todos os direitos reservados.</p>
            <p>Conteúdo institucional migrado de crn9.org.br — em atualização contínua pela equipe de comunicação.</p>
        </div>
    </div>
</footer>
