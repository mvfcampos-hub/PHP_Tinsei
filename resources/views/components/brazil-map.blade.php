@props(['map', 'dark' => true, 'showRanking' => true])
@php
    use App\Support\ClientMap;
    $counts = $map['counts'];
    $max = $map['max'];
    $top = collect($map['ranking'])->take(8);
@endphp
<div
    x-data="{ hovered: null }"
    {{ $attributes->merge(['class' => 'grid items-start gap-8 lg:grid-cols-5']) }}
>
    <div @class(['relative rounded-3xl p-4 sm:p-6 lg:col-span-3', 'border border-white/10 bg-white/[0.04]' => $dark, 'card' => ! $dark])>
        <div class="mb-2 flex min-h-[44px] items-start justify-between gap-4">
            <div>
                <p @class(['text-sm font-semibold', 'text-white' => $dark, 'text-brand-900' => ! $dark]) x-show="!hovered">Passe o mouse (ou toque) em um estado</p>
                <p x-show="hovered" x-cloak @class(['text-sm font-semibold', 'text-white' => $dark, 'text-brand-900' => ! $dark])>
                    <span x-text="hovered?.name"></span>
                    <span class="ml-1 font-display text-lg text-gold-400" x-text="hovered ? hovered.count.toLocaleString('pt-BR') : ''"></span>
                    <span @class(['text-xs font-normal', 'text-brand-200' => $dark, 'text-slate-500' => ! $dark])> clientes ativos</span>
                </p>
            </div>
            <div @class(['flex items-center gap-2 text-[11px]', 'text-brand-200' => $dark, 'text-slate-500' => ! $dark])>
                <span>menos</span>
                <span class="h-2 w-20 rounded-full bg-gradient-to-r from-brand-400/20 to-brand-300"></span>
                <span>mais</span>
            </div>
        </div>

        <svg viewBox="{{ $map['svg']['view_box'] }}" class="mx-auto h-auto max-h-[520px] w-full" role="img" aria-label="Mapa do Brasil com a quantidade de clientes ativos da Tinsei por estado">
            <defs>
                <filter id="map-glow" x="-20%" y="-20%" width="140%" height="140%">
                    <feGaussianBlur stdDeviation="4" result="b" /><feMerge><feMergeNode in="b" /><feMergeNode in="SourceGraphic" /></feMerge>
                </filter>
            </defs>
            @foreach ($map['svg']['states'] as $state)
                @php
                    $count = (int) ($counts[$state['code']] ?? 0);
                    $alpha = ClientMap::intensity($count, $max);
                    $base = $count > 0 ? "rgba(140, 190, 219, {$alpha})" : ($dark ? 'rgba(255,255,255,0.04)' : 'rgba(0,59,90,0.06)');
                    $stroke = $dark ? '#012c44' : '#ffffff';
                @endphp
                <path
                    d="{{ $state['d'] }}"
                    tabindex="0"
                    style="fill: {{ $base }}; stroke: {{ $stroke }}; stroke-width: 1.2; transition: fill .15s, filter .15s; outline: none;"
                    :style="hovered && hovered.code === '{{ $state['code'] }}' ? 'fill: #e8b042; stroke: #fff; stroke-width: 1.6; filter: url(#map-glow); outline: none;' : 'fill: {{ $base }}; stroke: {{ $stroke }}; stroke-width: 1.2; outline: none;'"
                    class="cursor-pointer"
                    @mouseenter="hovered = { code: '{{ $state['code'] }}', name: @js($state['name']), count: {{ $count }} }"
                    @focus="hovered = { code: '{{ $state['code'] }}', name: @js($state['name']), count: {{ $count }} }"
                    @click="hovered = { code: '{{ $state['code'] }}', name: @js($state['name']), count: {{ $count }} }"
                    @mouseleave="hovered = null"
                    @blur="hovered = null"
                ><title>{{ $state['name'] }}: {{ br_number($count) }} clientes ativos</title></path>
            @endforeach
        </svg>
        <p @class(['mt-2 text-right text-[10px]', 'text-brand-400' => $dark, 'text-slate-400' => ! $dark])>Base do mapa: svg-maps.com (CC BY 4.0)</p>
    </div>

    @if ($showRanking)
        <div class="space-y-5 lg:col-span-2">
            <div class="grid grid-cols-3 gap-3">
                <div @class(['rounded-2xl p-4', 'bg-white/[0.06] border border-white/10' => $dark, 'card' => ! $dark])>
                    <p class="font-display text-2xl font-bold text-gold-400">{{ br_number($map['total']) }}</p>
                    <p @class(['mt-1 text-[11px] leading-tight', 'text-brand-200' => $dark, 'text-slate-500' => ! $dark])>clientes ativos</p>
                </div>
                <div @class(['rounded-2xl p-4', 'bg-white/[0.06] border border-white/10' => $dark, 'card' => ! $dark])>
                    <p class="font-display text-2xl font-bold text-gold-400">{{ $map['states_served'] }}</p>
                    <p @class(['mt-1 text-[11px] leading-tight', 'text-brand-200' => $dark, 'text-slate-500' => ! $dark])>estados + DF atendidos</p>
                </div>
                <div @class(['rounded-2xl p-4', 'bg-white/[0.06] border border-white/10' => $dark, 'card' => ! $dark])>
                    <p class="font-display text-2xl font-bold text-gold-400">{{ br_number($map['abroad']) }}</p>
                    <p @class(['mt-1 text-[11px] leading-tight', 'text-brand-200' => $dark, 'text-slate-500' => ! $dark])>clientes no exterior</p>
                </div>
            </div>

            <div @class(['rounded-2xl p-5', 'bg-white/[0.04] border border-white/10' => $dark, 'card' => ! $dark])>
                <p class="mb-4 text-xs font-semibold uppercase tracking-[0.16em] text-gold-400">Estados com mais clientes</p>
                <ul class="space-y-2.5">
                    @foreach ($top as $row)
                        <li @mouseenter="hovered = { code: '{{ $row->code }}', name: @js($row->name), count: {{ $row->client_count }} }" @mouseleave="hovered = null" class="cursor-default">
                            <div class="mb-1 flex items-center justify-between text-sm">
                                <span @class(['font-medium', 'text-white' => $dark, 'text-brand-900' => ! $dark])>
                                    <span @class(['mr-2 inline-block w-7 text-xs font-bold', 'text-brand-300' => $dark, 'text-brand-500' => ! $dark])>{{ $row->code }}</span>{{ $row->name }}
                                </span>
                                <span @class(['tabular-nums', 'text-brand-100' => $dark, 'text-slate-600' => ! $dark])>{{ br_number($row->client_count) }}</span>
                            </div>
                            <div @class(['h-1.5 overflow-hidden rounded-full', 'bg-white/10' => $dark, 'bg-slate-100' => ! $dark])>
                                <div class="h-full rounded-full bg-gradient-to-r from-brand-400 to-gold-400" style="width: {{ max(3, round($row->client_count / $max * 100)) }}%"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="grid grid-cols-5 gap-2">
                @foreach ($map['regions'] as $region)
                    <div @class(['rounded-xl px-2 py-3 text-center', 'bg-white/[0.04] border border-white/10' => $dark, 'bg-brand-50' => ! $dark])>
                        <p @class(['font-display text-base font-bold', 'text-white' => $dark, 'text-brand-900' => ! $dark])>{{ br_number($region['count']) }}</p>
                        <p @class(['mt-0.5 text-[10px] leading-tight', 'text-brand-300' => $dark, 'text-slate-500' => ! $dark])>{{ $region['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
