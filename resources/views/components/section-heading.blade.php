@props(['eyebrow' => null, 'title', 'subtitle' => null, 'align' => 'left', 'dark' => false])
<div {{ $attributes->merge(['class' => ($align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl')]) }}>
    @if ($eyebrow)
        <span @class(['eyebrow', 'eyebrow-light' => $dark])>{{ $eyebrow }}</span>
    @endif
    <h2 @class(['mt-3 text-3xl font-bold sm:text-4xl', 'text-white' => $dark, 'text-brand-900' => ! $dark])>{!! $title !!}</h2>
    @if ($subtitle)
        <p @class(['mt-4 text-lg leading-relaxed', 'text-brand-100/80' => $dark, 'text-slate-500' => ! $dark])>{{ $subtitle }}</p>
    @endif
</div>
