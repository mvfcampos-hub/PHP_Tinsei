@props(['url', 'title' => 'Vídeo', 'poster' => null])
@php $id = youtube_id($url); @endphp
@if ($id)
    {{-- Carrega o player do YouTube só ao clicar (página mais leve e sem cookies antes da interação). --}}
    <div x-data="{ playing: false }" {{ $attributes->merge(['class' => 'relative aspect-video overflow-hidden rounded-2xl bg-brand-950 shadow-soft']) }}>
        <template x-if="playing">
            <iframe class="absolute inset-0 h-full w-full" src="https://www.youtube-nocookie.com/embed/{{ $id }}?autoplay=1&rel=0" title="{{ $title }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </template>
        <button type="button" x-show="!playing" @click="playing = true" class="group absolute inset-0 h-full w-full" aria-label="Assistir: {{ $title }}">
            <img src="{{ $poster ?? "https://i.ytimg.com/vi/{$id}/hqdefault.jpg" }}" alt="" loading="lazy" class="h-full w-full object-cover opacity-80 transition group-hover:opacity-95">
            <span class="absolute inset-0 bg-gradient-to-t from-brand-950/70 to-transparent"></span>
            <span class="absolute left-1/2 top-1/2 flex h-16 w-16 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-gold-400 text-brand-950 shadow-xl transition group-hover:scale-110">
                <x-ico name="play" class="h-7 w-7 translate-x-0.5" />
            </span>
            <span class="absolute bottom-4 left-5 right-5 text-left text-sm font-semibold text-white">{{ $title }}</span>
        </button>
    </div>
@endif
