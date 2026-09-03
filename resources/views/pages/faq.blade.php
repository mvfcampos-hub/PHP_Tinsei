@extends('layouts.app')

@section('title', $page->title)
@section('description', 'Perguntas frequentes sobre a Databit: sistemas, DataCloud, o modelo de Serviços Gerenciados (MSP) e suporte.')
@section('canonical', route('pages.show', 'perguntas-frequentes'))

@push('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqGroups)->flatMap(fn ($group) => $group['items'])->map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ])->values()->all(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">{{ $page->title }}</h1>
            <div class="prose prose-slate max-w-none prose-a:text-brand-700 mt-4">
                {!! $page->content !!}
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12 space-y-12">
        @foreach ($faqGroups as $group)
            <div>
                <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wide mb-4">{{ $group['title'] }}</h2>
                <div class="space-y-3" x-data="{ open: null }">
                    @foreach ($group['items'] as $index => $item)
                        @php $itemId = \Illuminate\Support\Str::slug($group['title']).'-'.$index; @endphp
                        <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
                            <button
                                type="button"
                                @click="open = open === '{{ $itemId }}' ? null : '{{ $itemId }}'"
                                class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left"
                                :aria-expanded="open === '{{ $itemId }}'"
                            >
                                <span class="font-semibold text-slate-900">{{ $item['q'] }}</span>
                                <svg
                                    class="h-4 w-4 shrink-0 text-slate-400 transition"
                                    :class="{ 'rotate-180': open === '{{ $itemId }}' }"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                ><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="open === '{{ $itemId }}'" x-cloak x-transition class="px-5 pb-4 text-sm text-slate-600">
                                {{ $item['a'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Não encontrou sua resposta?</h2>
                <p class="text-brand-100 mt-2">Fale com a gente ou consulte a nossa Base de Conhecimento.</p>
            </div>
            <div class="shrink-0 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('kb.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/20 transition">
                    Base de Conhecimento
                </a>
                <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Tenho uma dúvida sobre a Databit.') }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                    Falar com a gente
                </a>
            </div>
        </div>
    </section>
@endsection
