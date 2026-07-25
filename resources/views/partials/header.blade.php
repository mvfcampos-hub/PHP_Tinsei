<header x-data="{ mobileOpen: false, searchOpen: false }" class="bg-white/95 backdrop-blur sticky top-0 z-40 border-b border-slate-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                <img src="{{ asset('images/brand/logo-crn9.png') }}" alt="CRN-9 — Conselho Regional de Nutrição da 9ª Região" class="h-9 sm:h-10 w-auto">
            </a>

            <nav class="hidden lg:flex items-center gap-1">
                @foreach ($mainMenu ?? [] as $item)
                    <div class="relative group">
                        <a
                            href="{{ $item->resolveUrl() }}"
                            @if ($item->opens_new_tab) target="_blank" rel="noopener" @endif
                            class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-brand-50 hover:text-brand-800 transition"
                        >
                            {{ $item->label }}
                            @if ($item->children->isNotEmpty())
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            @endif
                        </a>
                        @if ($item->children->isNotEmpty())
                            <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition absolute left-0 top-full pt-2 w-64">
                                <div class="rounded-xl border border-slate-200 bg-white shadow-lg py-2">
                                    @foreach ($item->children as $child)
                                        <a href="{{ $child->resolveUrl() }}" @if ($child->opens_new_tab) target="_blank" rel="noopener" @endif class="block px-4 py-2 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-800">
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
                <button
                    @click="searchOpen = !searchOpen"
                    class="p-2 rounded-lg text-slate-700 hover:bg-slate-100"
                    :aria-expanded="searchOpen.toString()"
                    aria-label="Buscar no site"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </button>
                <a href="{{ route('pages.show', 'denuncia') }}" class="hidden md:inline-flex items-center rounded-lg border border-brand-orange px-3 py-2 text-sm font-semibold text-brand-orange hover:bg-brand-orange hover:text-white transition">
                    Denúncia
                </a>
                <a href="http://www.incorpnet.com.br/app/incorpnet.asp?conselho=crnmg" target="_blank" rel="noopener" class="hidden sm:inline-flex items-center rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800 transition">
                    Área do Profissional
                </a>
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg text-slate-700 hover:bg-slate-100" aria-label="Abrir menu">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>

        <div x-show="searchOpen" x-cloak x-transition x-on:keydown.escape.window="searchOpen = false" class="pb-4">
            <form action="{{ route('search.index') }}" method="GET" class="flex gap-2">
                <input
                    type="search"
                    name="q"
                    x-ref="searchInput"
                    x-init="$watch('searchOpen', value => value && $nextTick(() => $refs.searchInput.focus()))"
                    placeholder="Buscar notícias, páginas, vagas, revistas..."
                    class="flex-1 rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-brand-500 focus:ring-brand-500"
                >
                <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800 transition">
                    Buscar
                </button>
            </form>
        </div>

        <div x-show="mobileOpen" x-cloak x-transition class="lg:hidden pb-4">
            <form action="{{ route('search.index') }}" method="GET" class="flex gap-2 mb-3">
                <input
                    type="search"
                    name="q"
                    placeholder="Buscar no site..."
                    class="flex-1 rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-brand-500 focus:ring-brand-500"
                >
                <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800 transition">
                    Buscar
                </button>
            </form>
            <nav class="flex flex-col gap-1">
                @foreach ($mainMenu ?? [] as $item)
                    <a href="{{ $item->resolveUrl() }}" @if ($item->opens_new_tab) target="_blank" rel="noopener" @endif class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-brand-50">
                        {{ $item->label }}
                    </a>
                    @foreach ($item->children as $child)
                        <a href="{{ $child->resolveUrl() }}" class="px-6 py-2 rounded-lg text-sm text-slate-600 hover:bg-brand-50">
                            {{ $child->label }}
                        </a>
                    @endforeach
                @endforeach
            </nav>
        </div>
    </div>
</header>
