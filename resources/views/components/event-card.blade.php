@props(['event', 'compact' => false])
<article @class(['group card flex gap-5 p-5 transition hover:shadow-soft', 'opacity-80' => $event->starts_at->isPast() && ! ($event->ends_at?->isFuture())])>
    <div class="flex h-20 w-16 shrink-0 flex-col items-center justify-center rounded-xl bg-brand-800 text-white">
        <span class="text-2xl font-bold font-display leading-none">{{ $event->starts_at->format('d') }}</span>
        <span class="mt-1 text-[11px] font-semibold uppercase tracking-wide text-gold-300">{{ $event->starts_at->translatedFormat('M') }}</span>
        <span class="text-[10px] text-brand-200">{{ $event->starts_at->format('Y') }}</span>
    </div>
    <div class="min-w-0 flex-1">
        <span class="inline-flex rounded-full bg-gold-100 px-2 py-0.5 text-[11px] font-semibold text-gold-800">{{ $event->typeLabel() }}</span>
        <h3 class="mt-1.5 font-semibold leading-snug text-brand-900">{{ $event->title }}</h3>
        <div class="mt-1.5 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
            <span class="inline-flex items-center gap-1"><x-ico name="clock" class="h-3.5 w-3.5" />
                {{ $event->starts_at->format('H:i') !== '00:00' ? $event->starts_at->format('H\hi') : 'Dia inteiro' }}
                @if ($event->ends_at && ! $event->ends_at->isSameDay($event->starts_at)) · até {{ $event->ends_at->format('d/m') }} @endif
            </span>
            @if ($event->location)
                <span class="inline-flex items-center gap-1"><x-ico name="pin" class="h-3.5 w-3.5" /> {{ $event->location }}</span>
            @endif
        </div>
        @if (! $compact && $event->description)
            <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $event->description }}</p>
        @endif
        @if ($event->external_url)
            <a href="{{ $event->external_url }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-brand-700 hover:underline">
                Mais informações <x-ico name="arrow-up-right" class="h-3.5 w-3.5" />
            </a>
        @endif
    </div>
</article>
