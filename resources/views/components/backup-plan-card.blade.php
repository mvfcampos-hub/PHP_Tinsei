@props(['plan'])

<div @class([
    'relative flex flex-col rounded-2xl p-6 border transition',
    'border-accent-400 bg-brand-900 text-white shadow-xl scale-[1.02]' => $plan->is_popular,
    'border-slate-200 bg-white hover:shadow-md' => ! $plan->is_popular,
])>
    @if ($plan->is_popular)
        <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-accent-500 px-3 py-1 text-xs font-semibold text-white">
            Mais contratado
        </span>
    @endif

    <h3 @class(['font-semibold text-lg mb-1', 'text-white' => $plan->is_popular, 'text-slate-900' => ! $plan->is_popular])>
        {{ $plan->name }}
    </h3>
    @if ($plan->description)
        <p @class(['text-sm mb-4', 'text-brand-200' => $plan->is_popular, 'text-slate-500' => ! $plan->is_popular])>
            {{ $plan->description }}
        </p>
    @endif

    <div class="mb-5">
        <span @class(['text-3xl font-bold', 'text-white' => $plan->is_popular, 'text-slate-900' => ! $plan->is_popular])>
            R$ {{ number_format($plan->price_monthly, 0, ',', '.') }}
        </span>
        <span @class(['text-sm', 'text-brand-200' => $plan->is_popular, 'text-slate-500' => ! $plan->is_popular])>/mês</span>
    </div>

    <ul @class(['space-y-2 text-sm mb-6', 'text-brand-100' => $plan->is_popular, 'text-slate-600' => ! $plan->is_popular])>
        <li class="flex items-center gap-2">
            <svg class="h-4 w-4 shrink-0 {{ $plan->is_popular ? 'text-accent-400' : 'text-accent-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
            {{ $plan->storageLabel() }} de armazenamento
        </li>
        <li class="flex items-center gap-2">
            <svg class="h-4 w-4 shrink-0 {{ $plan->is_popular ? 'text-accent-400' : 'text-accent-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
            {{ $plan->device_limit ? 'Até '.$plan->device_limit.' dispositivos/fontes' : 'Dispositivos ilimitados' }}
        </li>
        <li class="flex items-center gap-2">
            <svg class="h-4 w-4 shrink-0 {{ $plan->is_popular ? 'text-accent-400' : 'text-accent-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
            Retenção de {{ $plan->retention_days }} dias
        </li>
    </ul>

    <a
        href="https://wa.me/553134168225?text={{ urlencode('Olá! Tenho interesse no plano DataBackup+ '.$plan->name.'.') }}"
        target="_blank" rel="noopener"
        @class([
            'mt-auto inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-semibold transition',
            'bg-accent-500 text-white hover:bg-accent-600' => $plan->is_popular,
            'bg-brand-700 text-white hover:bg-brand-800' => ! $plan->is_popular,
        ])
    >
        Contratar plano
    </a>
</div>
