<div class="hidden md:block bg-brand-950 text-brand-200 text-xs">
    <div class="container-site flex h-9 items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <a href="tel:{{ preg_replace('/\D/', '', setting('phone')) }}" class="inline-flex items-center gap-1.5 hover:text-white transition">
                <x-ico name="phone" class="h-3.5 w-3.5 text-gold-400" /> {{ setting('phone') }}
            </a>
            <a href="mailto:{{ setting('email') }}" class="inline-flex items-center gap-1.5 hover:text-white transition">
                <x-ico name="mail" class="h-3.5 w-3.5 text-gold-400" /> {{ setting('email') }}
            </a>
            <span class="hidden lg:inline-flex items-center gap-1.5">
                <x-ico name="pin" class="h-3.5 w-3.5 text-gold-400" /> Belo Horizonte · MG — atendemos todo o Brasil
            </span>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ setting('store_reseller_url') }}" target="_blank" rel="noopener" class="font-semibold text-gold-300 hover:text-gold-200 transition">Seja uma revenda</a>
            <span class="h-3 w-px bg-white/15"></span>
            <x-social-links class="gap-3" icon-class="h-3.5 w-3.5" />
        </div>
    </div>
</div>
