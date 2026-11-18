@php
    $storeUrl = setting('store_url');
    $isActive = fn (string $url) => $url !== '#' && (request()->url() === $url || (strlen($url) > strlen(url('/')) && str_starts_with(request()->url(), rtrim($url, '/'))));
@endphp
<header
    x-data="{ mobileOpen: false, searchOpen: false, scrolled: false }"
    x-init="scrolled = window.scrollY > 10"
    @scroll.window="scrolled = window.scrollY > 10"
    @keydown.escape.window="searchOpen = false; mobileOpen = false"
    :class="scrolled ? 'shadow-soft bg-white/95' : 'bg-white'"
    class="sticky top-0 z-40 border-b border-slate-200/70 backdrop-blur transition"
>
    <div class="container-site">
        <div class="flex h-[72px] items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="shrink-0" aria-label="Tinsei — página inicial">
                <x-logo class="h-11" />
            </a>

            <nav class="hidden lg:flex items-center gap-1" aria-label="Menu principal">
                @foreach ($mainMenu ?? [] as $item)
                    @continue($item->is_highlighted)
                    @php $url = $item->resolveUrl(); @endphp
                    <div class="relative group">
                        <a
                            href="{{ $url }}"
                            @if ($item->opens_new_tab) target="_blank" rel="noopener" @endif
                            @class([
                                'flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-semibold transition',
                                'text-brand-800 bg-brand-50' => $isActive($url),
                                'text-slate-600 hover:text-brand-800 hover:bg-slate-50' => ! $isActive($url),
                            ])
                        >
                            {{ $item->label }}
                            @if ($item->children->isNotEmpty())
                                <x-ico name="chevron-down" class="h-3.5 w-3.5 text-slate-400 transition group-hover:rotate-180" />
                            @endif
                        </a>
                        @if ($item->children->isNotEmpty())
                            <div class="invisible absolute left-0 top-full z-50 w-60 translate-y-1 pt-2 opacity-0 transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
                                <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-soft">
                                    @foreach ($item->children as $child)
                                        <a href="{{ $child->resolveUrl() }}" @if ($child->opens_new_tab) target="_blank" rel="noopener" @endif class="block rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-brand-50 hover:text-brand-800">
                                            {{ $child->label }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <button type="button" @click="searchOpen = !searchOpen; $nextTick(() => $refs.searchInput?.focus())" class="hidden sm:flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 hover:text-brand-800 transition" aria-label="Buscar no site">
                    <x-ico name="search" class="h-5 w-5" />
                </button>
                <a href="{{ $storeUrl }}" target="_blank" rel="noopener" class="btn-gold !py-2.5 hidden sm:inline-flex" onclick="window.trackEvent && window.trackEvent('store_click', { location: 'header' })">
                    <x-ico name="grid" class="h-4 w-4" />
                    Portfólio de produtos
                </a>
                <button type="button" @click="mobileOpen = !mobileOpen" class="lg:hidden flex h-10 w-10 items-center justify-center rounded-xl text-brand-800 hover:bg-slate-100" :aria-expanded="mobileOpen" aria-label="Abrir menu">
                    <x-ico name="menu" class="h-6 w-6" x-show="!mobileOpen" />
                    <x-ico name="x" class="h-6 w-6" x-show="mobileOpen" x-cloak />
                </button>
            </div>
        </div>
    </div>

    {{-- Busca --}}
    <div x-show="searchOpen" x-cloak x-transition.opacity class="border-t border-slate-200 bg-white">
        <form action="{{ route('search') }}" method="GET" class="container-site flex items-center gap-3 py-4">
            <x-ico name="search" class="h-5 w-5 text-slate-400" />
            <input x-ref="searchInput" type="search" name="q" placeholder="Buscar notícias, eventos e páginas..." class="flex-1 border-0 bg-transparent text-base focus:ring-0 focus:outline-none" aria-label="Termo de busca">
            <a href="{{ $storeUrl }}" target="_blank" rel="noopener" class="hidden md:inline text-xs font-semibold text-brand-700 hover:underline">Procurando um produto? Busque na loja →</a>
        </form>
    </div>

    {{-- Menu mobile --}}
    <div x-show="mobileOpen" x-cloak x-transition class="lg:hidden border-t border-slate-200 bg-white">
        <nav class="container-site py-4 space-y-1" aria-label="Menu principal (celular)">
            @foreach ($mainMenu ?? [] as $item)
                @continue($item->is_highlighted)
                <a href="{{ $item->resolveUrl() }}" class="block rounded-xl px-3 py-2.5 text-base font-semibold text-slate-700 hover:bg-brand-50">{{ $item->label }}</a>
                @foreach ($item->children as $child)
                    <a href="{{ $child->resolveUrl() }}" class="block rounded-xl pl-7 pr-3 py-2 text-sm text-slate-500 hover:bg-brand-50">{{ $child->label }}</a>
                @endforeach
            @endforeach
            <form action="{{ route('search') }}" method="GET" class="pt-2">
                <input type="search" name="q" placeholder="Buscar no site..." class="form-input" aria-label="Buscar no site">
            </form>
            <a href="{{ $storeUrl }}" target="_blank" rel="noopener" class="btn-gold w-full mt-3">
                <x-ico name="grid" class="h-4 w-4" /> Portfólio de produtos
            </a>
            <a href="{{ setting('store_reseller_url') }}" target="_blank" rel="noopener" class="btn-outline w-full">Seja uma revenda</a>
        </nav>
    </div>
</header>
