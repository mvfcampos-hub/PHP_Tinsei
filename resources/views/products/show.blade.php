@extends('layouts.app')

@section('title', $product->slug === 'dataclassic'
    ? 'DataClassic — ERP para Distribuidoras, Atacadistas, Locadoras e Autopeças'
    : $product->name . ($product->tagline ? ' — ' . $product->tagline : ''))
@section('description', $product->summary ?? '')
@section('canonical', route('products.show', $product->slug))
@if ($product->cover_image)
    @section('og_image', Storage::url($product->cover_image))
@endif

@push('schema')
    <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => $product->name,
            'description' => $product->summary,
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'brand' => ['@type' => 'Brand', 'name' => 'Databit'],
            'url' => route('products.show', $product->slug),
            'image' => $product->cover_image ? Storage::url($product->cover_image) : null,
        ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-16">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-200 hover:text-white mb-6">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
                Voltar para sistemas
            </a>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                {{ $product->categoryLabel() }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white max-w-3xl">{{ $product->name }}</h1>
            @if ($product->tagline)
                <p class="text-brand-200 mt-4 max-w-2xl text-lg">{{ $product->tagline }}</p>
            @endif

            <div class="flex flex-wrap gap-3 mt-8">
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Tenho interesse no produto ' . $product->name . '.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-5 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                    Falar com um especialista
                </a>
                @if ($product->external_url)
                    <a href="{{ $product->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg border border-white/20 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                        Acessar site do produto
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    </a>
                @endif
            </div>
        </div>
    </section>

    @if ($product->cover_image)
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
            <img src="{{ Storage::url($product->cover_image) }}" alt="{{ $product->name }}" class="w-full rounded-2xl shadow-xl object-cover max-h-[420px]">
        </div>
    @endif

    <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 pt-16 {{ empty($product->highlights) ? 'pb-16' : '' }}">
        @if ($product->description)
            <div class="prose prose-slate max-w-none prose-headings:font-semibold prose-a:text-brand-700">
                {!! $product->description !!}
            </div>
        @else
            <p class="text-slate-500">Conteúdo detalhado deste produto em atualização.</p>
        @endif
    </article>

    @if ($product->logo_image && !$product->youtubeEmbedUrl())
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-10 text-center">
            <img src="{{ Storage::url($product->logo_image) }}" alt="{{ $product->name }}" class="mx-auto h-16 sm:h-20 w-auto">
        </div>
    @endif

    @if ($ecosystemHub)
        <section class="bg-white border-y border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center max-w-2xl mx-auto mb-4">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">O núcleo do ecossistema Databit</h2>
                    <p class="text-slate-500 mt-2">O DataClassic conversa nativamente com os módulos abaixo — clique em qualquer um para conhecer os detalhes.</p>
                </div>
                <x-ecosystem-diagram :hub="$ecosystemHub" :satellites="$ecosystemSatellites" />
            </div>
        </section>
    @endif

    @if ($product->slug === 'dataclassic')
        <section class="py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Para quem é o DataClassic</h2>
                    <p class="text-slate-500 mt-3">
                        Um sistema de gestão (ERP) pensado para a realidade de quem compra, vende, aluga ou presta
                        serviço em grande volume.
                    </p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-5">
                    @foreach ([
                        ['icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21M3 9l9-6 9 6v9.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V9z', 'title' => 'Distribuidoras', 'desc' => 'Sistema de gestão para distribuidoras com controle de estoque, compras e faturamento em um só lugar.'],
                        ['icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'title' => 'Empresas atacadistas', 'desc' => 'ERP para empresas atacadistas, com gestão de preços, tabelas por cliente e logística de expedição.'],
                        ['icon' => 'M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.017-1.837-2.185a48.554 48.554 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.017 1.837-2.185a48.554 48.554 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z', 'title' => 'Outsourcing de impressão', 'desc' => 'Sistema de gestão para empresas de outsourcing de impressão, com contratos, medição e faturamento por página.'],
                        ['icon' => 'M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75', 'title' => 'Locadoras de equipamentos', 'desc' => 'Sistema de gestão para empresas de locação de equipamentos, com controle de contratos e retiradas de estoque.'],
                        ['icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25h5.379c.621 0 1.129.504 1.09 1.124a17.902 17.902 0 01-3.213 9.193 2.056 2.056 0 01-1.58.86H14.25M9 3v11.25M6 6.75H3.75m5.25 0h5.25M6 15h5.25', 'title' => 'Lojas de autopeças', 'desc' => 'Sistema de gestão para loja de autopeças e ERP para empresas de autopeças, com aplicação veicular e catálogo de produtos.'],
                    ] as $segment)
                        <div class="rounded-2xl border border-slate-200 bg-white p-5">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $segment['icon'] }}" /></svg>
                            </span>
                            <h3 class="font-semibold text-slate-900 text-sm mb-1.5">{{ $segment['title'] }}</h3>
                            <p class="text-xs text-slate-500">{{ $segment['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($product->youtubeEmbedUrl())
        <section class="py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-10 items-center">
                    <div>
                        @if ($product->logo_image)
                            <img src="{{ Storage::url($product->logo_image) }}" alt="{{ $product->name }}" class="h-10 sm:h-12 w-auto mb-6">
                        @endif
                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $product->tagline ?: $product->name }}</h2>
                        <p class="text-slate-600 mt-4 text-base sm:text-lg leading-relaxed">{{ $product->summary }}</p>
                        <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Tenho interesse no produto ' . $product->name . '.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 transition mt-6">
                            Falar com um especialista
                        </a>
                    </div>
                    <div class="relative aspect-video rounded-2xl overflow-hidden shadow-xl bg-slate-950">
                        <iframe
                            src="{{ $product->youtubeEmbedUrl() }}"
                            title="Vídeo demonstrativo — {{ $product->name }}"
                            class="absolute inset-0 h-full w-full"
                            loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        ></iframe>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (!empty($product->highlights))
        <section class="py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($product->highlights as $highlight)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-1 transition">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-500 text-white mb-4">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $highlight['icon'] }}" /></svg>
                            </span>
                            <h3 class="font-semibold text-slate-900 mb-2">{{ $highlight['title'] }}</h3>
                            <p class="text-sm text-slate-500">{{ $highlight['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($product->slug === 'dataclassic')
        <section class="bg-slate-50 border-t border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Confira outros módulos e funcionalidades</h2>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ([
                        ['logo' => 'dataclassic-modules/confere.png', 'name' => 'DataConfere', 'desc' => 'Conferência dos itens por leitor ou coletor de dados. Nos processos de recebimento de mercadoria e separação de mercadorias é fundamental o processo de bipagem para conferência — importante para garantir que os produtos informados no ERP são os produtos que estão sendo movimentados.'],
                        ['logo' => 'dataclassic-modules/doc.png', 'name' => 'DataDoc', 'desc' => 'Extrator de todos os documentos fiscais emitidos no ERP. Ferramenta que traz facilidade para exportar o movimento fiscal de saída, para envio para a contabilidade.'],
                        ['logo' => 'dataclassic-modules/coletor.png', 'name' => 'DataColetor', 'desc' => 'Ferramenta que roda nos coletores de dados, com recursos de gestão de armazenamento (definição de local de guarda) e captura de seriais para produtos que trabalham com gestão de série ou lote. Também usada para conferência de separação dos processos do estoque.'],
                        ['logo' => 'dataclassic-modules/integra.png', 'name' => 'DataIntegra', 'desc' => 'Ferramenta de integração com os parceiros de captura de contadores de impressoras para o ERP, facilitando o processo de faturamento dos contratos por medição. Integrado com DataCount, NDD MPS, NDD Orbix, Doc Service e Printwayy.'],
                        ['logo' => 'dataclassic-modules/label.png', 'name' => 'DataLabel', 'desc' => 'Ferramenta para emissão de etiquetas personalizadas com dados do ERP: etiqueta de produto por nota de entrada, etiqueta de volume e dados de entrega, etiquetas de patrimônio e serial, entre outras.'],
                        ['logo' => 'dataclassic-modules/xml.png', 'name' => 'DataXML', 'desc' => 'Ferramenta de captura de XML de produtos emitidos contra a sua empresa, apoiando o processo de entrada de notas fiscais, com recursos de manifestação e download em massa.'],
                        ['logo' => 'dataclassic-modules/nfs.png', 'name' => 'DataNFSE', 'desc' => 'Sistema integrador do ERP com os WebServices de prefeituras e o ambiente nacional, para emissão de NFS-e pelo sistema DataClassic.'],
                        ['logo' => 'dataclassic-modules/store.svg', 'name' => 'DataStore', 'desc' => 'Portal de vendas web B2B 100% integrado com o DataClassic. Transforme seu portal no seu melhor vendedor, com tabela de preços por cliente e carrinho inteligente e dinâmico para os pedidos online.', 'url' => route('datastore.show')],
                        ['logo' => 'dataclassic-modules/php.svg', 'name' => 'DataPHP', 'desc' => 'Diversos PHPs de apoio para gestão: indicadores financeiros (fluxo de caixa, DRE, acompanhamento de inadimplência), painel de gestão do parque de equipamentos, painel de gestão de OS preventivas, entre outros.'],
                    ] as $index => $module)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6">
                            <img src="{{ Storage::url($module['logo']) }}" alt="{{ $module['name'] }}" class="h-8 w-auto mb-4">
                            @if (isset($module['url']))
                                <a href="{{ $module['url'] }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 hover:text-brand-800">
                                    Conhecer o {{ $module['name'] }}
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </a>
                                <p class="text-sm text-slate-500 mt-3">{{ $module['desc'] }}</p>
                            @else
                                <div x-data="{ open: true }">
                                    <button
                                        type="button"
                                        @click="open = !open"
                                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 hover:text-brand-800"
                                        :aria-expanded="open"
                                    >
                                        Saiba mais
                                        <svg class="h-3.5 w-3.5 transition" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                                    </button>
                                    <p x-show="open" x-transition class="text-sm text-slate-500 mt-3">{{ $module['desc'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($related->isNotEmpty())
        <section class="bg-white border-t border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Outros produtos de {{ $product->categoryLabel() }}</h2>
                <div class="grid sm:grid-cols-3 gap-6">
                    @foreach ($related as $item)
                        <x-product-card :product="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
