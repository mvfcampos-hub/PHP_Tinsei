@props(['hub', 'satellites'])

@php
    // Rótulos de duas linhas e paleta de acentos por produto — variações dentro
    // da família azul/ciano da marca (mantendo o azul como cor padrão) para
    // diferenciar cada nó, inspirado no diagrama de referência do cliente.
    $labels = [
        'datamobile' => ['Data', 'Mobile', 'text-indigo-600'],
        'datasac' => ['Data', 'SAC', 'text-cyan-600'],
        'dataclient-crm' => ['Data', 'Client', 'text-violet-600'],
        'datawhats' => ['Data', 'Whats', 'text-teal-600'],
        'dataservice' => ['Data', 'Service', 'text-sky-600'],
        'datacount' => ['Data', 'Count', 'text-rose-500'],
        'datainvoice' => ['Data', 'Invoice', 'text-amber-600'],
        'datashipping' => ['Data', 'Shipping', 'text-emerald-600'],
        'datadashboard' => ['Data', 'Dashboard', 'text-blue-700'],
        'datamdfe' => ['Data', 'MDFe', 'text-fuchsia-600'],
    ];

    $radius = 38;
    $count = max($satellites->count(), 1);
    $nodes = $satellites->values()->map(function ($product, $index) use ($count, $radius, $labels) {
        $angle = deg2rad(($index * 360 / $count) - 90);
        $label = $labels[$product->slug] ?? [Str::before($product->name, ' ') ?: $product->name, '', 'text-brand-600'];

        return [
            'product' => $product,
            'x' => 50 + $radius * cos($angle),
            'y' => 50 + $radius * sin($angle),
            'line1' => $label[0],
            'line2' => $label[1],
            'accent' => $label[2],
        ];
    });
@endphp

<div class="hidden lg:block relative mx-auto aspect-square w-full max-w-2xl select-none">
    {{-- Linhas de conexão --}}
    <svg class="absolute inset-0 h-full w-full overflow-visible" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
        @foreach ($nodes as $node)
            <line x1="50" y1="50" x2="{{ $node['x'] }}" y2="{{ $node['y'] }}" stroke="#cbd5e1" stroke-width="0.4" />
            <circle cx="{{ 50 + ($node['x'] - 50) * 0.35 }}" cy="{{ 50 + ($node['y'] - 50) * 0.35 }}" r="0.7" fill="#93c5fd" />
            <circle cx="{{ 50 + ($node['x'] - 50) * 0.7 }}" cy="{{ 50 + ($node['y'] - 50) * 0.7 }}" r="0.7" fill="#93c5fd" />
        @endforeach
    </svg>

    {{-- Hub central --}}
    <a
        href="{{ $hub->resolveUrl() }}"
        class="group absolute left-1/2 top-1/2 z-10 flex h-32 w-32 md:h-36 md:w-36 -translate-x-1/2 -translate-y-1/2 flex-col items-center justify-center rounded-full border-4 border-white bg-white text-center shadow-xl ring-4 ring-brand-100 transition hover:-translate-y-[calc(50%+2px)] hover:shadow-2xl hover:ring-accent-300"
    >
        <span class="text-xs font-bold uppercase tracking-wide text-slate-400 group-hover:text-slate-500">Data</span>
        <span class="text-lg md:text-xl font-extrabold text-brand-700">Classic</span>
        <span class="mt-1 text-[10px] font-medium text-slate-400">Núcleo do ecossistema</span>
    </a>

    {{-- Produtos satélites --}}
    @foreach ($nodes as $node)
        @php $product = $node['product']; @endphp
        <a
            href="{{ $product->resolveUrl() }}"
            @if ($product->opens_externally) target="_blank" rel="noopener" @endif
            style="left: {{ $node['x'] }}%; top: {{ $node['y'] }}%;"
            class="group absolute z-10 flex h-24 w-24 md:h-28 md:w-28 -translate-x-1/2 -translate-y-1/2 flex-col items-center justify-center gap-1 rounded-full border border-slate-200 bg-white text-center shadow-lg transition hover:-translate-y-[calc(50%+3px)] hover:shadow-xl hover:border-accent-300"
        >
            <span class="flex h-6 w-6 items-center justify-center {{ $node['accent'] }}">
                @if ($product->icon)
                    <x-dynamic-component :component="$product->icon" class="h-5 w-5" />
                @endif
            </span>
            <span class="leading-tight">
                <span class="block text-[10px] font-bold uppercase tracking-wide text-slate-400">{{ $node['line1'] }}</span>
                @if ($node['line2'])
                    <span class="block text-xs md:text-sm font-extrabold {{ $node['accent'] }}">{{ $node['line2'] }}</span>
                @endif
            </span>
        </a>
    @endforeach
</div>
