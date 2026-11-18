@props(['partner', 'full' => false, 'compact' => false])
<article class="group card overflow-hidden lg:grid lg:grid-cols-5">
    <div class="relative aspect-[4/5] overflow-hidden bg-gradient-to-br from-brand-800 via-brand-900 to-brand-950 lg:col-span-2 lg:aspect-auto">
        @if ($partner->photo)
            <img src="{{ media_url($partner->photo) }}" alt="{{ $partner->name }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
        @else
            <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
            <div class="relative flex h-full min-h-[260px] flex-col items-center justify-center gap-4">
                <span class="flex h-28 w-28 items-center justify-center rounded-full border border-gold-400/40 bg-white/5 font-display text-4xl font-bold text-gold-300">{{ $partner->initials() }}</span>
                <img src="{{ asset('images/brand/tinsei-mark.png') }}" alt="" class="h-6 opacity-70">
            </div>
        @endif
        @if ($partner->since_label)
            <span class="absolute left-4 top-4 rounded-full bg-gold-400 px-3 py-1 text-xs font-bold text-brand-950">Na Tinsei desde {{ $partner->since_label }}</span>
        @endif
    </div>
    <div class="flex flex-col p-6 sm:p-8 lg:col-span-3">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gold-600">{{ $partner->role }}</p>
        <h3 class="mt-2 text-2xl font-bold text-brand-900">{{ $partner->name }}</h3>
        @if ($partner->summary)
            <p class="mt-3 leading-relaxed text-slate-600">{{ $partner->summary }}</p>
        @endif
        @if ($full && $partner->bio)
            <div class="prose prose-sm prose-slate mt-4 max-w-none">{!! $partner->bio !!}</div>
        @endif
        @if (! $compact && ! empty($partner->highlights))
            <ul class="mt-5 grid gap-2 sm:grid-cols-2">
                @foreach ($partner->highlights as $highlight)
                    <li class="flex items-start gap-2 text-sm text-slate-600">
                        <x-ico name="check" class="mt-0.5 h-4 w-4 shrink-0 text-leaf-600" /> {{ $highlight }}
                    </li>
                @endforeach
            </ul>
        @endif
        @if ($partner->quote)
            <blockquote class="mt-6 border-l-2 border-gold-400 pl-4 italic text-brand-800">“{{ $partner->quote }}”</blockquote>
        @endif
        @if ($compact)
            <a href="{{ route('about') }}#socios" class="mt-auto inline-flex items-center gap-1 pt-6 text-sm font-semibold text-brand-700 hover:gap-2 transition-all">Conheça a trajetória <x-ico name="arrow-right" class="h-4 w-4" /></a>
        @endif
        @if ($partner->linkedin_url || $partner->instagram_url)
            <div class="mt-auto flex gap-3 pt-6 text-sm font-semibold">
                @if ($partner->linkedin_url)<a href="{{ $partner->linkedin_url }}" target="_blank" rel="noopener" class="text-brand-700 hover:underline">LinkedIn ↗</a>@endif
                @if ($partner->instagram_url)<a href="{{ $partner->instagram_url }}" target="_blank" rel="noopener" class="text-brand-700 hover:underline">Instagram ↗</a>@endif
            </div>
        @endif
    </div>
</article>
