@props(['product'])

<article class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-0.5 transition">
    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
        @if ($product->icon)
            <x-dynamic-component :component="$product->icon" class="h-6 w-6" />
        @else
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25-2.25m-2.25 2.25V6.75m-8.25.75h16.5" /></svg>
        @endif
    </span>
    <span class="text-xs font-medium text-accent-600 uppercase tracking-wide mb-1">{{ $product->categoryLabel() }}</span>
    <h3 class="font-semibold text-slate-900 text-lg leading-snug mb-2">
        <a href="{{ $product->resolveUrl() }}" @if ($product->opens_externally) target="_blank" rel="noopener" @endif class="hover:text-brand-700 transition">
            {{ $product->name }}
        </a>
    </h3>
    @if ($product->summary)
        <p class="text-sm text-slate-600 line-clamp-3 mb-4">{{ $product->summary }}</p>
    @endif
    <a href="{{ $product->resolveUrl() }}" @if ($product->opens_externally) target="_blank" rel="noopener" @endif class="mt-auto inline-flex items-center gap-1 text-sm font-medium text-brand-700 group-hover:text-brand-800">
        Conhecer o produto
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
    </a>
</article>
