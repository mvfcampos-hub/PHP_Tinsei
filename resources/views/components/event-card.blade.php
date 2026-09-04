@props(['event'])

<article class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 hover:shadow-md transition">
    <div class="flex flex-col items-center justify-center rounded-xl bg-brand-700 text-white w-16 h-16 shrink-0">
        <span class="text-xs uppercase leading-none">{{ $event->starts_at->translatedFormat('M') }}</span>
        <span class="text-xl font-bold leading-none mt-1">{{ $event->starts_at->format('d') }}</span>
    </div>
    <div class="min-w-0">
        <div class="flex items-center gap-2 mb-1">
            <span @class([
                'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium',
                'bg-accent-50 text-accent-600' => $event->type === 'lancamento',
                'bg-brand-50 text-brand-700' => $event->type !== 'lancamento',
            ])>
                {{ $event->typeLabel() }}
            </span>
        </div>
        <h3 class="font-semibold text-slate-900 leading-snug">{{ $event->title }}</h3>
        <p class="text-sm text-slate-500 mt-1">
            {{ $event->starts_at->translatedFormat('d \d\e F, H:i') }}
            @if ($event->location)
                &middot; {{ $event->location }}
            @endif
        </p>
        <div class="flex items-center gap-4 mt-2">
            @if ($event->external_url)
                <a href="{{ $event->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800">
                    Saiba mais
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            @endif
            @if ($event->product)
                <a href="{{ $event->product->resolveUrl() }}" class="inline-flex items-center gap-1 text-sm font-medium text-accent-600 hover:text-accent-700">
                    Ver produto
                </a>
            @endif
        </div>
    </div>
</article>
