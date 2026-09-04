@props(['gradient' => true])

{{-- Marca gráfica da Databit (o símbolo das três linhas), usada como
     elemento decorativo de marca em pontos de destaque do site. --}}
<svg viewBox="0 0 120 70" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => 'h-8 w-auto']) }}>
    @if ($gradient)
        <defs>
            <linearGradient id="brand-mark-grad" x1="0" y1="70" x2="120" y2="0" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#1d38ab"/>
                <stop offset="55%" stop-color="#3363f0"/>
                <stop offset="100%" stop-color="#22d3ee"/>
            </linearGradient>
        </defs>
    @endif
    <g stroke="{{ $gradient ? 'url(#brand-mark-grad)' : 'currentColor' }}" stroke-width="7" stroke-linecap="round" fill="none">
        <path d="M12 54 C 45 62, 78 50, 108 40"/>
        <path d="M28 36 C 55 42, 84 34, 112 24"/>
        <path d="M44 18 C 65 22, 90 16, 116 10"/>
    </g>
    <circle cx="12" cy="54" r="7" fill="{{ $gradient ? 'url(#brand-mark-grad)' : 'currentColor' }}"/>
    <circle cx="28" cy="36" r="6.5" fill="{{ $gradient ? 'url(#brand-mark-grad)' : 'currentColor' }}"/>
    <circle cx="44" cy="18" r="6" fill="{{ $gradient ? 'url(#brand-mark-grad)' : 'currentColor' }}"/>
</svg>
