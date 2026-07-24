@props(['news'])

<article class="group flex flex-col rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition">
    <a href="{{ route('news.show', $news->slug) }}" class="block aspect-[16/9] bg-slate-100 overflow-hidden">
        @if ($news->cover_image)
            <img src="{{ Storage::url($news->cover_image) }}" alt="{{ $news->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
        @else
            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-brand-100 to-brand-200 text-brand-700 font-semibold">
                CRN-9
            </div>
        @endif
    </a>
    <div class="flex flex-col flex-1 p-5">
        @if ($news->category)
            <span class="inline-flex w-fit items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700 mb-3">
                {{ $news->category }}
            </span>
        @endif
        <h3 class="font-semibold text-slate-900 leading-snug mb-2">
            <a href="{{ route('news.show', $news->slug) }}" class="hover:text-brand-700 transition">
                {{ $news->title }}
            </a>
        </h3>
        @if ($news->excerpt)
            <p class="text-sm text-slate-600 line-clamp-2 mb-4">{{ $news->excerpt }}</p>
        @endif
        <p class="mt-auto text-xs text-slate-400">
            {{ optional($news->published_at)->translatedFormat('d \d\e F \d\e Y') }}
        </p>
    </div>
</article>
