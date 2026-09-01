<header x-data="{ mobileOpen: false, searchOpen: false }" class="bg-white/95 backdrop-blur sticky top-0 z-40 border-b border-slate-200">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                <img src="{{ asset('images/brand/logo-crn9.png') }}" alt="CRN-9 — Conselho Regional de Nutrição da 9ª Região" class="min-[1460px]:hidden h-9 sm:h-10 w-auto">
                <img src="{{ asset('images/brand/logo-crn9-compacto.png') }}" alt="CRN-9 — Conselho Regional de Nutrição da 9ª Região" class="hidden min-[1460px]:block h-9 sm:h-10 w-auto">
            </a>

            <nav class="hidden min-[1460px]:flex items-center gap-1">
                @foreach ($mainMenu ?? [] as $item)
                    <div class="relative group">
                        <a
                            href="{{ $item->resolveUrl() }}"
                            @if ($item->opens_new_tab) target="_blank" rel="noopener" @endif
                            class="relative flex items-center whitespace-nowrap px-3.5 py-2.5 text-sm font-semibold text-slate-700 rounded-lg hover:bg-brand-50 hover:text-brand-800 transition after:content-[''] after:absolute after:left-3.5 after:right-3.5 after:-bottom-0.5 after:h-0.5 after:rounded-full after:bg-brand-700 after:scale-x-0 group-hover:after:scale-x-100 after:transition-transform"
                        >
                            {{ $item->label }}
                        </a>
                        @if ($item->children->isNotEmpty())
                            @php
                                $sections = $item->children->pluck('section')->filter()->unique();
                                $colCount = min(max($sections->count(), 1), 3);
                                $panelWidth = $colCount * 16 + ($colCount - 1) * 2;
                                $alignRight = ($mainMenu ?? collect())->count() > 0 && $loop->index >= intdiv(($mainMenu ?? collect())->count(), 2);
                            @endphp
                            @if ($sections->isNotEmpty())
                                <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition absolute {{ $alignRight ? 'right-0' : 'left-0' }} top-full pt-3">
                                    <div class="rounded-xl border border-slate-200 bg-white shadow-xl p-6" style="column-count: {{ $colCount }}; column-gap: 2.5rem; width: {{ $panelWidth }}rem;">
                                        @foreach ($item->children->groupBy(fn ($child) => $child->section ?? '') as $sectionLabel => $sectionItems)
                                            <div class="mb-6" style="break-inside: avoid;">
                                                @if ($sectionLabel !== '')
                                                    <p class="px-1 pb-2.5 text-xs font-bold uppercase tracking-wider text-brand-700 border-b border-brand-100">{{ $sectionLabel }}</p>
                                                @endif
                                                <div class="space-y-1 pt-1">
                                                    @foreach ($sectionItems as $child)
                                                        <a href="{{ $child->resolveUrl() }}" @if ($child->opens_new_tab) target="_blank" rel="noopener" @endif class="block rounded-lg px-1.5 py-2 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-800 hover:font-medium">
                                                            {{ $child->label }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition absolute left-0 top-full pt-3 w-72">
                                    <div class="rounded-xl border border-slate-200 bg-white shadow-xl py-3">
                                        @foreach ($item->children as $child)
                                            @if ($child->children->isNotEmpty())
                                                <div class="relative group/sub">
                                                    <a
                                                        href="{{ $child->resolveUrl() }}"
                                                        @if ($child->opens_new_tab) target="_blank" rel="noopener" @endif
                                                        class="flex items-center justify-between gap-2 px-5 py-2.5 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-800 hover:font-medium"
                                                    >
                                                        {{ $child->label }}
                                                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                                    </a>
                                                    <div class="invisible opacity-0 group-hover/sub:visible group-hover/sub:opacity-100 transition absolute left-full top-0 pl-3 w-72">
                                                        <div class="rounded-xl border border-slate-200 bg-white shadow-xl py-3">
                                                            @foreach ($child->children as $grandchild)
                                                                <a href="{{ $grandchild->resolveUrl() }}" @if ($grandchild->opens_new_tab) target="_blank" rel="noopener" @endif class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-800 hover:font-medium">
                                                                    {{ $grandchild->label }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <a href="{{ $child->resolveUrl() }}" @if ($child->opens_new_tab) target="_blank" rel="noopener" @endif class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-800 hover:font-medium">
                                                    {{ $child->label }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach
            </nav>

            <div class="flex items-center gap-2 shrink-0">
                @include('partials.accessibility-widget')
                <button
                    @click="searchOpen = !searchOpen"
                    class="p-2 rounded-lg text-slate-700 hover:bg-slate-100"
                    :aria-expanded="searchOpen.toString()"
                    aria-label="Buscar no site"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </button>
                <a href="{{ route('pages.show', 'denuncia') }}" class="hidden md:inline-flex items-center rounded-lg border border-brand-orange px-2.5 2xl:px-3 py-2 text-xs 2xl:text-sm font-semibold text-brand-orange hover:bg-brand-orange hover:text-white transition">
                    Denúncia
                </a>
                <a href="http://www.incorpnet.com.br/app/incorpnet.asp?conselho=crnmg" target="_blank" rel="noopener" class="hidden sm:inline-flex items-center rounded-lg bg-brand-700 px-2.5 2xl:px-4 py-2 text-xs 2xl:text-sm font-semibold text-white hover:bg-brand-800 transition">
                    Área do Profissional
                </a>
                <button @click="mobileOpen = !mobileOpen" class="min-[1460px]:hidden p-2 rounded-lg text-slate-700 hover:bg-slate-100" :aria-expanded="mobileOpen.toString()" aria-label="Abrir menu">
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
                    aria-label="Buscar notícias, páginas, vagas, revistas"
                    class="flex-1 rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-brand-500 focus:ring-brand-500"
                >
                <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800 transition">
                    Buscar
                </button>
            </form>
        </div>

        <div x-show="mobileOpen" x-cloak x-transition class="min-[1460px]:hidden pb-4 max-h-[calc(100vh-5rem)] overflow-y-auto overscroll-contain">
            <form action="{{ route('search.index') }}" method="GET" class="flex gap-2 mb-3">
                <input
                    type="search"
                    name="q"
                    placeholder="Buscar no site..."
                    aria-label="Buscar no site"
                    class="flex-1 rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-brand-500 focus:ring-brand-500"
                >
                <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800 transition">
                    Buscar
                </button>
            </form>
            <nav class="flex flex-col gap-1 pb-2">
                @foreach ($mainMenu ?? [] as $item)
                    <a href="{{ $item->resolveUrl() }}" @if ($item->opens_new_tab) target="_blank" rel="noopener" @endif class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-brand-50">
                        {{ $item->label }}
                    </a>
                    @php $lastSection = null; @endphp
                    @foreach ($item->children as $child)
                        @if ($child->section && $child->section !== $lastSection)
                            <p class="px-6 pt-2 pb-0.5 text-[11px] font-semibold uppercase tracking-wide text-slate-400">{{ $child->section }}</p>
                            @php $lastSection = $child->section; @endphp
                        @endif
                        <a href="{{ $child->resolveUrl() }}" @if ($child->opens_new_tab) target="_blank" rel="noopener" @endif class="px-6 py-2 rounded-lg text-sm text-slate-600 hover:bg-brand-50">
                            {{ $child->label }}
                        </a>
                        @foreach ($child->children as $grandchild)
                            <a href="{{ $grandchild->resolveUrl() }}" @if ($grandchild->opens_new_tab) target="_blank" rel="noopener" @endif class="px-9 py-2 rounded-lg text-sm text-slate-500 hover:bg-brand-50">
                                {{ $grandchild->label }}
                            </a>
                        @endforeach
                    @endforeach
                @endforeach
            </nav>
        </div>
    </div>
</header>
