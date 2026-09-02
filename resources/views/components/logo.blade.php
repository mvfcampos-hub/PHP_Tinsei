@props(['variant' => 'color'])

{{-- Wordmark de espera: substituir pelo arquivo oficial da logomarca da Databit
     (SVG/PNG) assim que recebido do cliente. Mantém a leitura "databit" em azul,
     conforme identidade atual do site databit.com.br. --}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 leading-none select-none']) }}>
    <span class="relative flex h-9 w-9 items-center justify-center rounded-lg {{ $variant === 'white' ? 'bg-white/10' : 'bg-brand-600' }}">
        <span class="h-3 w-3 rounded-full {{ $variant === 'white' ? 'bg-white' : 'bg-accent-400' }}"></span>
    </span>
    <span class="text-2xl font-extrabold tracking-tight {{ $variant === 'white' ? 'text-white' : 'text-brand-700' }}">
        data<span class="{{ $variant === 'white' ? 'text-accent-300' : 'text-accent-500' }}">bit</span>
    </span>
</span>
