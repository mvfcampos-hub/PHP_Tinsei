@php
    $mapData = require resource_path('data/brazil-states.php');
    $stateCounts = $presenceStates->pluck('device_count', 'code');
    $maxCount = $stateCounts->max() ?: 1;
    $topStates = $presenceStates->sortByDesc('device_count')->take(6)->values();
    $totalDevices = $presenceStates->sum('device_count') + $presenceCountries->sum('device_count');

    $flags = ['MX' => '🇲🇽', 'US' => '🇺🇸'];
@endphp

<section class="bg-brand-950 bg-grid-pattern">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                Onde estamos
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Databit pelo Brasil e além</h2>
            <p class="text-brand-200 mt-3">
                @if ($totalDevices > 0)
                    Mais de {{ number_format($totalDevices, 0, ',', '.') }} dispositivos usando as nossas soluções, em todas as regiões do Brasil e também no México e nos Estados Unidos.
                @else
                    Presente em todas as regiões do Brasil e também no México e nos Estados Unidos.
                @endif
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 items-start" x-data="{ hovered: null }">
            <div class="lg:col-span-2 rounded-2xl border border-white/10 bg-white/5 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3 min-h-[28px]">
                    <p class="text-sm font-semibold text-white" x-show="!hovered">Passe o mouse sobre um estado</p>
                    <p class="text-sm font-semibold text-white" x-show="hovered" x-cloak x-text="hovered ? (hovered.name + ' — ' + (hovered.count > 0 ? hovered.count.toLocaleString('pt-BR') + ' dispositivos' : 'sem clientes cadastrados')) : ''"></p>
                    <span class="text-xs text-brand-300">Brasil por estado</span>
                </div>
                <svg viewBox="{{ $mapData['view_box'] }}" class="w-full h-auto max-h-[420px] mx-auto">
                    @foreach ($mapData['states'] as $state)
                        @php
                            $count = (int) ($stateCounts[$state['code']] ?? 0);
                            $opacity = $count > 0 ? 0.28 + (0.72 * ($count / $maxCount)) : 0.06;
                        @endphp
                        <path
                            d="{{ $state['d'] }}"
                            style="fill: rgba(34, 211, 238, {{ $opacity }}); stroke: #0e1836; stroke-width: 1.3; transition: fill .15s;"
                            :style="hovered && hovered.code === '{{ $state['code'] }}' ? 'fill: rgba(34, 211, 238, 1); stroke: #fff; stroke-width: 1.5; transition: fill .15s;' : 'fill: rgba(34, 211, 238, {{ $opacity }}); stroke: #0e1836; stroke-width: 1.3; transition: fill .15s;'"
                            class="cursor-pointer"
                            @mouseenter="hovered = { code: '{{ $state['code'] }}', name: '{{ addslashes($state['name']) }}', count: {{ $count }} }"
                            @mouseleave="hovered = null"
                        ><title>{{ $state['name'] }}: {{ $count }} dispositivos</title></path>
                    @endforeach
                </svg>
                <p class="text-[11px] text-brand-400 mt-2 text-right">Mapa: svg-maps.com (CC BY 4.0)</p>
            </div>

            <div class="space-y-6">
                @if ($topStates->isNotEmpty())
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <p class="text-xs font-semibold text-accent-400 uppercase tracking-wide mb-4">Estados em destaque</p>
                        <ul class="space-y-3">
                            @foreach ($topStates as $state)
                                <li>
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="font-medium text-white">{{ $state->name }}</span>
                                        <span class="text-brand-300">{{ number_format($state->device_count, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="h-1.5 rounded-full bg-white/10 overflow-hidden">
                                        <div class="h-full rounded-full bg-accent-400" style="width: {{ $maxCount > 0 ? max(4, round(($state->device_count / $maxCount) * 100)) : 0 }}%"></div>
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
