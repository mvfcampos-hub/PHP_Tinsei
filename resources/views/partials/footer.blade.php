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
                <a href="https://www.facebook.com/CRN9online" target="_blank" rel="noopener" aria-label="Facebook" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 text-white hover:bg-brand-700 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M13.5 21v-8.06h2.7l.4-3.14h-3.1V7.94c0-.91.25-1.53 1.56-1.53h1.66V3.6c-.29-.04-1.27-.12-2.41-.12-2.39 0-4.02 1.46-4.02 4.13v2.3H7.58v3.14h2.71V21h3.21z"/>
                    </svg>
                </a>
                <a href="https://www.instagram.com/crn9online/" target="_blank" rel="noopener" aria-label="Instagram" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 text-white hover:bg-brand-700 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <rect x="3" y="3" width="18" height="18" rx="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                </a>
                <a href="https://www.youtube.com/channel/UCWIAlOTOXRyU3TlguLHgcuw" target="_blank" rel="noopener" aria-label="YouTube" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 text-white hover:bg-brand-700 transition">
                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M22.5 7.2c-.26-1-1.04-1.76-2.03-2.02C18.74 4.7 12 4.7 12 4.7s-6.74 0-8.47.48c-.99.26-1.77 1.02-2.03 2.02C1 8.94 1 12 1 12s0 3.06.5 4.8c.26 1 1.04 1.76 2.03 2.02 1.73.48 8.47.48 8.47.48s6.74 0 8.47-.48c.99-.26 1.77-1.02 2.03-2.02.5-1.74.5-4.8.5-4.8s0-3.06-.5-4.8zM9.75 15.4V8.6L15.8 12l-6.05 3.4z"/>
                    </svg>
                </a>
                <a href="https://api.whatsapp.com/send/?phone=5531995917825&amp;text=Ol%C3%A1!%20Gostaria%20de%20falar%20com%20a%20equipe%20do%20CRN9." target="_blank" rel="noopener" aria-label="WhatsApp" class="h-9 w-9 flex items-center justify-center rounded-full bg-brand-900 text-white hover:bg-brand-700 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.9 9.9 0 004.74 1.21h.005c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.87 9.87 0 0012.04 2zm5.79 14.11c-.24.68-1.4 1.3-1.93 1.35-.49.05-1.02.24-3.44-.72-2.91-1.16-4.78-4.13-4.93-4.32-.14-.19-1.18-1.57-1.18-3 0-1.43.75-2.13 1.02-2.42.27-.29.58-.36.78-.36.19 0 .39 0 .56.01.18.01.42-.07.66.5.24.58.83 2 .9 2.15.07.15.12.32.02.51-.1.19-.15.31-.29.48-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.29.75 1.24 1.62 2.01 1.11.99 2.04 1.3 2.33 1.45.29.15.46.12.63-.07.17-.19.72-.84.91-1.13.19-.29.39-.24.65-.14.27.1 1.68.79 1.97.94.29.14.48.21.55.33.07.12.07.7-.17 1.38z"/>
                    </svg>
                </a>
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
