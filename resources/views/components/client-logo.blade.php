@props(['client'])

<a
    href="{{ $client->url ?? '#' }}"
    @if ($client->url) target="_blank" rel="noopener" @endif
    @class([
        'flex items-center justify-center h-20 rounded-xl border border-slate-200 bg-white px-6 grayscale opacity-70 transition',
        'hover:grayscale-0 hover:opacity-100' => $client->url,
        'pointer-events-none' => ! $client->url,
    ])
>
    <img src="{{ Storage::url($client->logo) }}" alt="{{ $client->name }}" class="max-h-10 max-w-full object-contain">
</a>
