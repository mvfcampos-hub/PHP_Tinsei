@props(['article'])

<a href="{{ route('kb.show', $article->slug) }}" class="group flex flex-col rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition">
    <div class="aspect-[16/9] bg-slate-100 overflow-hidden relative">
        @if ($article->cover_image)
            <img src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
        @else
            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-brand-100 to-brand-200 text-brand-700">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
            </div>
        @endif
        @if ($article->video_url)
            <span class="absolute top-3 right-3 flex h-8 w-8 items-center justify-center rounded-full bg-black/60 text-white">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" /></svg>
            </span>
        @endif
    </div>
    <div class="flex flex-col flex-1 p-5">
        <div class="flex flex-wrap items-center gap-2 mb-2">
            <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700">
                {{ $article->solutionTypeLabel() }}
            </span>
            @if ($article->product)
                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                    {{ $article->product->name }}
                </span>
            @endif
        </div>
        <h3 class="font-semibold text-slate-900 leading-snug mb-2 group-hover:text-brand-700 transition">
            {{ $article->title }}
        </h3>
        @if ($article->excerpt)
            <p class="text-sm text-slate-600 line-clamp-2">{{ $article->excerpt }}</p>
        @endif
    </div>
</a>
