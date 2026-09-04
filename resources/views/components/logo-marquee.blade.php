@props(['items', 'label' => null, 'reverse' => false])

@php
    $duration = max(20, $items->count() * 4);
@endphp

<div class="w-full">
    @if ($label)
        <h2 class="text-center text-sm font-semibold text-slate-400 uppercase tracking-wide mb-6">{{ $label }}</h2>
    @endif

    <div class="group relative overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_5%,black_95%,transparent)] [-webkit-mask-image:linear-gradient(to_right,transparent,black_5%,black_95%,transparent)]">
        <div
            class="flex w-max items-center gap-5 animate-marquee group-hover:[animation-play-state:paused]"
            style="animation-duration: {{ $duration }}s;{{ $reverse ? ' animation-direction: reverse;' : '' }}"
        >
            @for ($set = 0; $set < 2; $set++)
                @foreach ($items as $item)
                    <a
                        href="{{ $item->url ?? '#' }}"
                        @if ($item->url) target="_blank" rel="noopener" @endif
                        @class([
                            'flex h-28 w-60 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white px-8 shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-md',
                            'pointer-events-none' => ! $item->url,
                        ])
                    >
                        <img src="{{ Storage::url($item->logo) }}" alt="{{ $item->name }}" class="max-h-16 max-w-full object-contain" loading="lazy">
                    </a>
                @endforeach
            @endfor
        </div>
    </div>
</div>
