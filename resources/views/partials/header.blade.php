<header x-data="{ mobileOpen: false, searchOpen: false }" @keydown.escape.window="searchOpen = false" class="bg-white/95 backdrop-blur sticky top-0 z-40 border-b border-slate-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="shrink-0">
                <x-logo />
            </a>

            <nav class="hidden lg:flex items-center gap-8 xl:gap-10">
                @foreach ($mainMenu ?? [] as $item)
                    @php
                        $isSystems = $item->url === '/sistemas';
                        $isItServices = $item->url === '/servicos-ti';
                    @endphp
                    <div class="relative group py-7 -my-7">
                        <a
                            href="{{ $item->resolveUrl() }}"
                            @if ($item->opens_new_tab) target="_blank" rel="noopener" @endif
                            class="relative flex items-center gap-1.5 whitespace-nowrap text-sm font-semibold text-slate-700 transition group-hover:text-brand-700"
                        >
                            {{ $item->label }}
                            @if ($item->children->isNotEmpty() || $isSystems || $isItServices)
                                <svg class="h-3.5 w-3.5 text-slate-400 transition group-hover:rotate-180 group-hover:text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            @endif
                            <span class="absolute -bottom-2 left-0 h-0.5 w-0 bg-accent-500 transition-all duration-200 group-hover:w-full"></span>
                        </a>

                        {{-- Mega menu: Sistemas --}}
                        @if ($isSystems)
                            <div class="invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition absolute left-1/2 -translate-x-1/2 top-full pt-3 w-[720px] max-w-[90vw]">
                                <div class="rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden grid grid-cols-3">
                                    <div class="col-span-2 p-5 grid grid-cols-2 gap-1">
                                        @foreach ($systemsMenuProducts ?? [] as $product)
                                            <a href="{{ route('products.show', $product->slug) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 hover:bg-brand-50 transition">
                                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                                                    @if ($product->icon)
                                                        <x-dynamic-component :component="$product->icon" class="h-5 w-5" />
                                                    @endif
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold text-slate-800 truncate">{{ $product->name }}</span>
                                                    <span class="block text-xs text-slate-400 truncate">{{ $product->categoryLabel() }}</span>
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="bg-brand-950 bg-grid-pattern p-5 flex flex-col gap-3">
                                        <span class="text-[11px] font-semibold text-accent-400 uppercase tracking-wide">Fora do catálogo de sistemas</span>
                                        <a href="{{ route('cloud.show') }}" class="flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2.5 hover:border-accent-500 transition">
                                            <svg class="h-5 w-5 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" /></svg>
                                            <span class="text-sm font-semibold text-white">DataCloud</span>
                                        </a>
                                        <a href="{{ route('it-services.show') }}" class="flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2.5 hover:border-accent-500 transition">
                                            <svg class="h-5 w-5 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" /></svg>
                                            <span class="text-sm font-semibold text-white">Serviços de TI</span>
                                        </a>
                                        <a href="{{ route('hardware.index') }}" class="flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2.5 hover:border-accent-500 transition">
                                            <svg class="h-5 w-5 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                                            <span class="text-sm font-semibold text-white">Produtos de informática</span>
                                        </a>
                                        <a href="{{ route('products.index') }}" class="mt-auto inline-flex items-center gap-1 text-xs font-semibold text-accent-300 hover:text-accent-200">
                                            Ver todos os sistemas
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif ($isItServices)
                            {{-- Mega menu: Serviços TI --}}
                            <div class="invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition absolute left-1/2 -translate-x-1/2 top-full pt-3 w-[720px] max-w-[90vw]">
                                <div class="rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden grid grid-cols-3">
                                    <div class="col-span-2 p-5 grid grid-cols-2 gap-1">
                                        @foreach ([
                                            ['name' => 'Databit MSP', 'category' => 'Serviços Gerenciados', 'icon' => 'heroicon-o-document-text', 'url' => route('msp.show')],
                                            ['name' => 'DataGateway+', 'category' => 'Rede e segurança de perímetro', 'icon' => 'heroicon-o-globe-alt', 'url' => route('msp.show').'#addon-datagateway'],
                                            ['name' => 'DataBackup+', 'category' => 'Backup e recuperação', 'icon' => 'heroicon-o-cloud-arrow-up', 'url' => route('msp.show').'#addon-databackup'],
                                            ['name' => 'DataSecurity+', 'category' => 'Segurança avançada', 'icon' => 'heroicon-o-shield-check', 'url' => route('msp.show').'#addon-datasecurity'],
                                        ] as $service)
                                            <a href="{{ $service['url'] }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 hover:bg-brand-50 transition">
                                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                                                    <x-dynamic-component :component="$service['icon']" class="h-5 w-5" />
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold text-slate-800 truncate">{{ $service['name'] }}</span>
                                                    <span class="block text-xs text-slate-400 truncate">{{ $service['category'] }}</span>
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="bg-brand-950 bg-grid-pattern p-5 flex flex-col gap-3">
                                        <span class="text-[11px] font-semibold text-accent-400 uppercase tracking-wide">Fora do catálogo de serviços TI</span>
                                        <a href="{{ route('cloud.show') }}" class="flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2.5 hover:border-accent-500 transition">
                                            <svg class="h-5 w-5 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" /></svg>
                                            <span class="min-w-0">
                                                <span class="block text-sm font-semibold text-white truncate">DataCloud</span>
                                                <span class="block text-xs text-brand-300 truncate">Serviços de Cloud e Colocation</span>
                                            </span>
                                        </a>
                                        <a href="{{ route('it-services.show') }}" class="mt-auto inline-flex items-center gap-1 text-xs font-semibold text-accent-300 hover:text-accent-200">
                                            Ver todos os serviços de TI
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif ($item->children->isNotEmpty())
                            <div class="invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition absolute left-0 top-full pt-3 w-64">
                                <div class="rounded-2xl border border-slate-200 bg-white shadow-xl py-2">
                                    @foreach ($item->children as $child)
                                        <a href="{{ $child->resolveUrl() }}" @if ($child->opens_new_tab) target="_blank" rel="noopener" @endif class="block px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">
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
                <div class="relative hidden lg:block" @click.outside="searchOpen = false">
                    <button
                        @click="searchOpen = !searchOpen; if (searchOpen) $nextTick(() => $refs.searchInput.focus())"
                        class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-brand-700 transition"
                        :aria-expanded="searchOpen"
                        aria-label="Buscar no site"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    </button>
                    <div
                        x-show="searchOpen"
                        x-cloak
                        x-transition
                        class="absolute right-0 top-full pt-3 w-80"
                    >
                        <form action="{{ route('search') }}" method="GET" class="rounded-2xl border border-slate-200 bg-white shadow-xl p-3">
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                <input
                                    x-ref="searchInput"
                                    type="search"
                                    name="q"
                                    placeholder="Buscar sistemas, serviços, novidades..."
                                    class="w-full rounded-lg border border-slate-200 bg-slate-50 pl-9 pr-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none"
                                >
                            </div>
                        </form>
                    </div>
                </div>

                <a href="#" class="hidden md:inline-flex items-center rounded-lg border border-brand-200 px-4 py-2 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                    Área do Cliente
                </a>
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg text-slate-700 hover:bg-slate-100" aria-label="Abrir menu">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>

        <div x-show="mobileOpen" x-cloak x-transition class="lg:hidden pb-4 max-h-[70vh] overflow-y-auto">
            <form action="{{ route('search') }}" method="GET" class="px-3 pb-3">
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    <input
                        type="search"
                        name="q"
                        placeholder="Buscar no site..."
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 pl-9 pr-3 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none"
                    >
                </div>
            </form>
            <nav class="flex flex-col gap-1">
                @foreach ($mainMenu ?? [] as $item)
                    <a href="{{ $item->resolveUrl() }}" @if ($item->opens_new_tab) target="_blank" rel="noopener" @endif class="px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-brand-50">
                        {{ $item->label }}
                    </a>
                    @if ($item->url === '/sistemas')
                        @foreach ($systemsMenuProducts ?? [] as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="px-6 py-2 rounded-lg text-sm text-slate-600 hover:bg-brand-50">
                                {{ $product->name }}
                            </a>
                        @endforeach
                    @endif
                    @if ($item->url === '/servicos-ti')
                        <a href="{{ route('msp.show') }}" class="px-6 py-2 rounded-lg text-sm text-slate-600 hover:bg-brand-50">Databit MSP</a>
                        <a href="{{ route('msp.show') }}#addon-datagateway" class="px-6 py-2 rounded-lg text-sm text-slate-600 hover:bg-brand-50">DataGateway+</a>
                        <a href="{{ route('msp.show') }}#addon-databackup" class="px-6 py-2 rounded-lg text-sm text-slate-600 hover:bg-brand-50">DataBackup+</a>
                        <a href="{{ route('msp.show') }}#addon-datasecurity" class="px-6 py-2 rounded-lg text-sm text-slate-600 hover:bg-brand-50">DataSecurity+</a>
                        <a href="{{ route('cloud.show') }}" class="px-6 py-2 rounded-lg text-sm text-slate-600 hover:bg-brand-50">DataCloud</a>
                    @endif
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
