@props(['news'])
<article class="group card flex flex-col overflow-hidden transition hover:-translate-y-1 hover:shadow-soft">
    <a href="{{ route('news.show', $news->slug) }}" class="relative block aspect-[16/9] overflow-hidden bg-brand-100">
        @if ($cover = $news->coverUrl())
            <img src="{{ $cover }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-800 to-brand-600">
                <img src="{{ asset('images/brand/tinsei-mark.png') }}" alt="" class="h-14 opacity-80">
            </div>
        @endif
        @if ($news->youtubeId())
            <span class="absolute inset-0 flex items-center justify-center">
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-white/90 text-brand-800 shadow-lg"><x-ico name="play" class="h-5 w-5 translate-x-0.5" /></span>
            </span>
        @endif
        @if ($news->category)
            <span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-semibold text-brand-800">{{ $news->category }}</span>
        @endif
    </a>
    <div class="flex flex-1 flex-col p-5">
        <time datetime="{{ $news->published_at?->toDateString() }}" class="text-xs font-medium text-slate-400">{{ $news->published_at?->translatedFormat('d \d\e F \d\e Y') }}</time>
        <h3 class="mt-2 text-lg font-semibold leading-snug text-brand-900 group-hover:text-brand-600">
            <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
        </h3>
        @if ($news->excerpt)
            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-500">{{ $news->excerpt }}</p>
        @endif
        <a href="{{ route('news.show', $news->slug) }}" class="mt-auto pt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-700 group-hover:gap-2 transition-all">
            Ler mais <x-ico name="arrow-right" class="h-4 w-4" />
        </a>
    </div>
</article>
