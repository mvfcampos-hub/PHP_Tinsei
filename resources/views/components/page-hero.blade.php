@props(['eyebrow' => null, 'title', 'subtitle' => null, 'image' => null])
<section class="relative overflow-hidden bg-brand-900 bg-grid-pattern bg-grid">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-brand-900/95 to-brand-800/80"></div>
    @if ($image)
        <img src="{{ $image }}" alt="" class="absolute inset-y-0 right-0 hidden h-full w-1/2 object-cover opacity-25 lg:block [mask-image:linear-gradient(to_left,black,transparent)]">
    @endif
    <img src="{{ asset('images/brand/tinsei-mark.png') }}" alt="" class="pointer-events-none absolute -right-10 -bottom-16 h-72 w-auto opacity-[0.06]">
    <div class="container-site relative py-16 sm:py-20">
        <nav class="mb-6 text-xs text-brand-300" aria-label="Você está em">
            <a href="{{ route('home') }}" class="hover:text-white">Início</a>
            <span class="mx-1.5 text-brand-500">/</span>
            <span class="text-brand-100">{{ $title }}</span>
        </nav>
        @if ($eyebrow)
            <span class="eyebrow eyebrow-light">{{ $eyebrow }}</span>
        @endif
        <h1 class="mt-3 max-w-3xl text-4xl font-bold text-white sm:text-5xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-5 max-w-2xl text-lg leading-relaxed text-brand-100/90">{{ $subtitle }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
