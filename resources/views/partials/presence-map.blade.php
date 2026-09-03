@php
    use App\Models\ClientPresence;

    $mapData = require resource_path('data/brazil-states.php');
    $regionCounts = $presenceRegions->pluck('device_count', 'code');
    $totalRegionDevices = $presenceRegions->sum('device_count') ?: 1;
    $regionPercent = fn ($count) => (int) round($count / $totalRegionDevices * 100);
    $maxCount = $regionCounts->max() ?: 1;
    $sortedRegions = $presenceRegions->sortByDesc('device_count')->values();
    $topRegion = $sortedRegions->first();
    $totalDevices = $totalRegionDevices + $presenceCountries->sum('device_count');

    $flags = ['MX' => '🇲🇽', 'US' => '🇺🇸'];
@endphp

<section class="relative bg-brand-950 bg-grid-pattern overflow-hidden">
    <x-brand-mark class="hidden lg:block absolute -left-6 -bottom-8 h-32 w-auto opacity-[0.07] pointer-events-none select-none" aria-hidden="true" />
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20 relative">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                Onde estamos
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Databit pelo Brasil e além</h2>
            <p class="text-brand-200 mt-3">
                @if ($topRegion)
                    Mais de {{ number_format($totalDevices, 0, ',', '.') }} dispositivos usando as nossas soluções, com maior concentração na região {{ $topRegion->name }} ({{ $regionPercent($topRegion->device_count) }}% dos clientes), e também no México e nos Estados Unidos.
                @else
                    Presente em todas as regiões do Brasil e também no México e nos Estados Unidos.
                @endif
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 items-start" x-data="{ hovered: null }">
            <div class="lg:col-span-2 rounded-2xl border border-white/10 bg-white/5 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3 min-h-[28px]">
                    <p class="text-sm font-semibold text-white" x-show="!hovered">Passe o mouse sobre uma região</p>
                    <p class="text-sm font-semibold text-white" x-show="hovered" x-cloak x-text="hovered ? (hovered.name + ' — ' + hovered.percent + '% dos clientes (' + hovered.count.toLocaleString('pt-BR') + ' dispositivos)') : ''"></p>
                    <span class="text-xs text-brand-300">Brasil por região</span>
                </div>
                <svg viewBox="{{ $mapData['view_box'] }}" class="w-full h-auto max-h-[420px] mx-auto">
                    @foreach ($mapData['states'] as $state)
                        @php
                            $regionCode = ClientPresence::STATE_REGIONS[$state['code']] ?? null;
                            $count = (int) ($regionCounts[$regionCode] ?? 0);
                            $percent = $regionPercent($count);
                            $regionName = ClientPresence::REGIONS[$regionCode] ?? $state['name'];
                            $opacity = $count > 0 ? 0.28 + (0.72 * ($count / $maxCount)) : 0.06;
                        @endphp
                        <path
                            d="{{ $state['d'] }}"
                            style="fill: rgba(34, 211, 238, {{ $opacity }}); stroke: #0e1836; stroke-width: 1.3; transition: fill .15s;"
                            :style="hovered && hovered.code === '{{ $regionCode }}' ? 'fill: rgba(34, 211, 238, 1); stroke: #fff; stroke-width: 1.5; transition: fill .15s;' : 'fill: rgba(34, 211, 238, {{ $opacity }}); stroke: #0e1836; stroke-width: 1.3; transition: fill .15s;'"
                            class="cursor-pointer"
                            @mouseenter="hovered = { code: '{{ $regionCode }}', name: '{{ addslashes($regionName) }}', percent: {{ $percent }}, count: {{ $count }} }"
                            @mouseleave="hovered = null"
                        ><title>{{ $state['name'] }} ({{ $regionName }}): {{ $percent }}% dos clientes</title></path>
                    @endforeach
                </svg>
                <p class="text-[11px] text-brand-400 mt-2 text-right">Mapa: svg-maps.com (CC BY 4.0)</p>
            </div>

            <div class="space-y-6">
                @if ($sortedRegions->isNotEmpty())
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <p class="text-xs font-semibold text-accent-400 uppercase tracking-wide mb-4">Regiões</p>
                        <ul class="space-y-3">
                            @foreach ($sortedRegions as $region)
                                <li>
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="font-medium text-white">{{ $region->name }}</span>
                                        <span class="text-brand-300">{{ $regionPercent($region->device_count) }}%</span>
                                    </div>
                                    <div class="h-1.5 rounded-full bg-white/10 overflow-hidden">
                                        <div class="h-full rounded-full bg-accent-400" style="width: {{ $maxCount > 0 ? max(4, round(($region->device_count / $maxCount) * 100)) : 0 }}%"></div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($presenceCountries->isNotEmpty())
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <p class="text-xs font-semibold text-accent-400 uppercase tracking-wide mb-4">Presença internacional</p>
                        <ul class="space-y-3">
                            @foreach ($presenceCountries as $country)
                                <li class="flex items-center gap-3">
                                    <span class="text-2xl leading-none">{{ $flags[$country->code] ?? '🌎' }}</span>
                                    <span class="flex-1 text-sm font-medium text-white">{{ $country->name }}</span>
                                    <span class="text-sm text-brand-300">{{ number_format($country->device_count, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
