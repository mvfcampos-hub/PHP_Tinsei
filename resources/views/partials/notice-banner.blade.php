@if (($globalNoticeBanners ?? collect())->isNotEmpty())
    <div class="bg-accent-600 text-white">
        @foreach ($globalNoticeBanners as $banner)
            <div
                x-data="{ open: true, id: 'databit-notice-{{ $banner->id }}' }"
                x-init="if (localStorage.getItem(id) === 'dismissed') open = false"
                x-show="open"
                x-cloak
                class="border-t border-white/10 first:border-t-0"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-2.5 flex items-center gap-3">
                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                    <a href="{{ $banner->link_url ?? '#' }}" @if ($banner->link_url) target="_blank" rel="noopener" @endif class="text-sm font-medium flex-1 hover:underline">
                        {{ $banner->title }}
                    </a>
                    <button
                        @click="open = false; localStorage.setItem(id, 'dismissed')"
                        class="shrink-0 rounded-full p-1 hover:bg-white/10 transition"
                        aria-label="Fechar aviso"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif
