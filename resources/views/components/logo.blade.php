@props(['variant' => 'color'])

{{-- Logomarca oficial da Databit, extraída da home atual (databit.com.br).
     A variante "white" usa a mesma arte colorida com um filtro CSS para
     branco sólido (preserva a transparência), já que o arquivo branco
     publicado no site atual está com a arte trocada por engano. --}}
<img
    src="{{ asset('images/brand/logo-color.png') }}"
    alt="Databit — Soluções em Tecnologia"
    width="1024"
    height="200"
    {{ $attributes->merge(['class' => 'h-9 w-auto select-none '.($variant === 'white' ? 'brightness-0 invert' : '')]) }}
>
