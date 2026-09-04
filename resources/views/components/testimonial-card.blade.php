@props(['testimonial'])

<a href="{{ route('success-stories.index') }}" class="flex flex-col rounded-2xl border border-slate-200 bg-white p-6 h-full hover:border-brand-300 hover:shadow-md transition">
    <div class="flex items-center gap-1 mb-4">
        @for ($i = 1; $i <= 5; $i++)
            <svg class="h-4 w-4 {{ $i <= $testimonial->rating ? 'text-accent-500' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.363 1.118l1.287 3.957c.3.922-.755 1.688-1.538 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.06 9.385c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.958z" /></svg>
        @endfor
    </div>
    <p class="text-slate-700 leading-relaxed flex-1">&ldquo;{{ $testimonial->quote }}&rdquo;</p>
    <div class="flex items-center gap-3 mt-6">
        @if ($testimonial->photo)
            <img src="{{ Storage::url($testimonial->photo) }}" alt="{{ $testimonial->client_name }}" class="h-11 w-11 rounded-full object-cover">
        @else
            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-100 text-brand-700 font-semibold">
                {{ Str::of($testimonial->client_name)->substr(0, 1) }}
            </span>
        @endif
        <div>
            <p class="font-semibold text-slate-900 text-sm">{{ $testimonial->client_name }}</p>
            <p class="text-xs text-slate-500">
                {{ $testimonial->role }}{{ $testimonial->role && $testimonial->company ? ' · ' : '' }}{{ $testimonial->company }}
            </p>
        </div>
    </div>
</a>
