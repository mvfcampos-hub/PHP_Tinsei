@props(['items', 'dark' => false])
{{-- Linha do tempo vertical, alternando lados no desktop. --}}
<ol class="relative mx-auto max-w-5xl">
    <span @class(['absolute left-[19px] top-2 bottom-2 w-px md:left-1/2', 'bg-white/15' => $dark, 'bg-brand-200' => ! $dark]) aria-hidden="true"></span>
    @foreach ($items as $item)
        @php $left = $loop->even; @endphp
        <li class="reveal relative grid gap-4 pb-10 last:pb-0 md:grid-cols-2 md:gap-12">
            <span class="absolute left-[11px] top-1.5 flex h-[17px] w-[17px] items-center justify-center rounded-full bg-gold-400 ring-4 {{ $dark ? 'ring-brand-900' : 'ring-white' }} md:left-1/2 md:-translate-x-1/2" aria-hidden="true">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-900"></span>
            </span>
            <div @class(['pl-12 md:pl-0', 'md:col-start-2' => ! $left, 'md:text-right' => $left])>
                <span @class(['font-display text-3xl font-extrabold', 'text-gold-300' => $dark, 'text-gold-500' => ! $dark])>{{ $item->year_label }}</span>
                <h3 @class(['mt-1 text-lg font-semibold', 'text-white' => $dark, 'text-brand-900' => ! $dark])>{{ $item->title }}</h3>
                @if ($item->description)
                    <p @class(['mt-2 text-sm leading-relaxed', 'text-brand-100/80' => $dark, 'text-slate-500' => ! $dark])>{{ $item->description }}</p>
                @endif
                @if ($item->highlight)
                    <span @class(['mt-3 inline-flex rounded-full px-3 py-1 text-xs font-semibold', 'bg-white/10 text-gold-200' => $dark, 'bg-leaf-50 text-leaf-700' => ! $dark])>{{ $item->highlight }}</span>
                @endif
                @if ($item->image)
                    <img src="{{ media_url($item->image) }}" alt="" loading="lazy" @class(['mt-4 rounded-xl max-h-48 object-cover', 'md:ml-auto' => $left])>
                @endif
            </div>
        </li>
    @endforeach
</ol>
