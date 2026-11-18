@foreach ($globalNoticeBanners ?? [] as $notice)
    <div class="bg-gold-400 text-brand-950">
        <div class="container-site flex flex-wrap items-center justify-center gap-x-3 gap-y-1 py-2 text-center text-sm">
            <span class="font-semibold">{{ $notice->title }}</span>
            @if ($notice->subtitle)
                <span class="hidden sm:inline text-brand-900/80">{{ $notice->subtitle }}</span>
            @endif
            @if ($notice->link_url)
                <a href="{{ $notice->link_url }}" class="inline-flex items-center gap-1 font-semibold underline underline-offset-2 hover:no-underline">
                    {{ $notice->link_label ?: 'Saiba mais' }} →
                </a>
            @endif
        </div>
    </div>
@endforeach
