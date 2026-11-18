@props(['testimonial'])
<figure class="card relative flex h-full flex-col p-6 sm:p-7">
    <x-ico name="quote" class="absolute right-6 top-6 h-8 w-8 text-gold-200" />
    <div class="flex gap-0.5 text-gold-400" aria-label="Avaliação: {{ $testimonial->rating }} de 5">
        @for ($i = 1; $i <= 5; $i++)
            <svg class="h-4 w-4 {{ $i <= $testimonial->rating ? '' : 'opacity-25' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        @endfor
    </div>
    <blockquote class="mt-4 flex-1 text-[15px] leading-relaxed text-slate-600">“{{ $testimonial->quote }}”</blockquote>
    @if ($testimonial->youtubeId())
        <a href="{{ $testimonial->video_url }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 hover:underline">
            <x-ico name="play" class="h-4 w-4" /> Assistir ao depoimento
        </a>
    @endif
    <figcaption class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
        @if ($testimonial->photo)
            <img src="{{ media_url($testimonial->photo) }}" alt="" class="h-11 w-11 rounded-full object-cover">
        @else
            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-800 text-sm font-bold text-gold-300">{{ $testimonial->initials() }}</span>
        @endif
        <div class="min-w-0">
            <p class="font-semibold text-brand-900">{{ $testimonial->client_name }}</p>
            <p class="truncate text-xs text-slate-500">
                {{ collect([$testimonial->role, $testimonial->company])->filter()->join(' · ') }}
                @if ($testimonial->city || $testimonial->state)
                    — {{ collect([$testimonial->city, $testimonial->state])->filter()->join('/') }}
                @endif
            </p>
        </div>
    </figcaption>
</figure>
