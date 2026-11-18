@props(['variant' => 'color'])
<img
    src="{{ asset($variant === 'white' ? 'images/brand/logo-tinsei-white.png' : 'images/brand/logo-tinsei-color.png') }}"
    alt="Tinsei"
    width="198"
    height="93"
    {{ $attributes->merge(['class' => 'h-10 w-auto select-none']) }}
>
