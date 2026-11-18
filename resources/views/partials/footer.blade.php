<footer class="relative overflow-hidden bg-brand-950 text-brand-200">
    <div class="absolute inset-0 bg-grid-pattern bg-grid opacity-60"></div>
    <img src="{{ asset('images/brand/tinsei-mark.png') }}" alt="" class="pointer-events-none absolute -bottom-20 -left-10 h-80 opacity-[0.04]">

    {{-- Faixa de chamada para o portfólio --}}
    <div class="relative border-b border-white/10">
        <div class="container-site flex flex-col items-start justify-between gap-6 py-10 md:flex-row md:items-center">
            <div>
                <p class="font-display text-2xl font-bold text-white">{{ setting('portfolio_items') }} itens prontos para a sua revenda.</p>
                <p class="mt-1 text-brand-200">Equipamentos novos e recondicionados, suprimentos e peças — consulte preços e disponibilidade na loja.</p>
            </div>
            <div class="flex shrink-0 flex-wrap gap-3">
                <a href="{{ setting('store_url') }}" target="_blank" rel="noopener" class="btn-gold" onclick="window.trackEvent && window.trackEvent('store_click', { location: 'footer' })">
                    <x-ico name="grid" class="h-4 w-4" /> Acessar o portfólio
                </a>
                <a href="{{ setting('store_reseller_url') }}" target="_blank" rel="noopener" class="btn-ghost-light">Cadastre sua revenda</a>
            </div>
        </div>
    </div>

    <div class="container-site relative grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-12">
        <div class="lg:col-span-4">
            <x-logo variant="white" class="h-12" />
            <p class="mt-5 max-w-sm text-sm leading-relaxed">
                Importação, recondicionamento e distribuição de equipamentos de impressão, suprimentos e peças — com qualidade, confiança, preço competitivo e sustentabilidade no DNA.
            </p>
            <x-social-links class="mt-6 gap-4 text-white" icon-class="h-5 w-5" />
        </div>

        <div class="lg:col-span-2">
            <p class="text-sm font-semibold text-white">A Tinsei</p>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('about') }}" class="hover:text-white">Quem somos</a></li>
                <li><a href="{{ route('about') }}#historia" class="hover:text-white">Nossa história</a></li>
                <li><a href="{{ route('about') }}#socios" class="hover:text-white">Sócios</a></li>
                <li><a href="{{ route('sustainability') }}" class="hover:text-white">Sustentabilidade</a></li>
                <li><a href="{{ route('careers.index') }}" class="hover:text-white">Trabalhe conosco</a></li>
            </ul>
        </div>

        <div class="lg:col-span-2">
            <p class="text-sm font-semibold text-white">Conteúdo</p>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('portfolio') }}" class="hover:text-white">Portfólio</a></li>
                <li><a href="{{ route('news.index') }}" class="hover:text-white">Notícias</a></li>
                <li><a href="{{ route('events.index') }}" class="hover:text-white">Agenda</a></li>
                <li><a href="{{ route('testimonials') }}" class="hover:text-white">Depoimentos</a></li>
                <li><a href="{{ route('presence') }}" class="hover:text-white">Onde estamos</a></li>
            </ul>
        </div>

        <div class="sm:col-span-2 lg:col-span-4">
            <p class="text-sm font-semibold text-white">Fale com a Tinsei</p>
            <ul class="mt-4 space-y-3 text-sm">
                <li class="flex gap-3"><x-ico name="pin" class="h-5 w-5 shrink-0 text-gold-400" /><span class="whitespace-pre-line">{{ setting('address') }}</span></li>
                <li class="flex gap-3"><x-ico name="phone" class="h-5 w-5 shrink-0 text-gold-400" /><a href="tel:{{ preg_replace('/\D/', '', setting('phone')) }}" class="hover:text-white">{{ setting('phone') }}</a></li>
                <li class="flex gap-3"><x-ico name="mail" class="h-5 w-5 shrink-0 text-gold-400" /><a href="mailto:{{ setting('email') }}" class="hover:text-white">{{ setting('email') }}</a></li>
                @if (setting('business_hours'))
                    <li class="flex gap-3"><x-ico name="clock" class="h-5 w-5 shrink-0 text-gold-400" />{{ setting('business_hours') }}</li>
                @endif
            </ul>
            <a href="{{ route('contact.index') }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-gold-300 hover:text-gold-200">Enviar uma mensagem <x-ico name="arrow-right" class="h-4 w-4" /></a>
        </div>
    </div>

    <div class="relative border-t border-white/10">
        <div class="container-site flex flex-col gap-3 py-6 text-xs text-brand-300 md:flex-row md:items-center md:justify-between">
            <p>© {{ now()->year }} {{ setting('legal_name') }} · CNPJ {{ setting('cnpj') }}</p>
            <div class="flex flex-wrap gap-x-5 gap-y-2">
                <a href="{{ route('pages.show', 'politica-de-privacidade') }}" class="hover:text-white">Política de Privacidade</a>
                <a href="{{ route('pages.show', 'termos-de-uso') }}" class="hover:text-white">Termos de Uso</a>
                <a href="{{ route('sitemap') }}" class="hover:text-white">Mapa do site</a>
                <span>Desenvolvido por <a href="https://www.databit.com.br/" target="_blank" rel="noopener" class="font-semibold text-brand-100 hover:text-white">Databit</a></span>
            </div>
        </div>
    </div>
</footer>
