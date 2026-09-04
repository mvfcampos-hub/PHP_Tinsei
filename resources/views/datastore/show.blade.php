@extends('layouts.app')

@section('title', 'DataStore — Portal de Vendas Web B2B integrado ao DataClassic')
@section('description', 'DataStore: portal de vendas web B2B 100% integrado com o ERP DataClassic. Catálogo gerenciado no ERP, tabela de preços por cliente, consultas financeiras, benefícios comerciais e carrinho inteligente.')
@section('canonical', route('datastore.show'))

@push('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => 'DataStore',
            'description' => 'Portal de vendas web B2B 100% integrado com o ERP DataClassic, com catálogo gerenciado no ERP, tabela de preços por cliente e carrinho inteligente.',
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'brand' => ['@type' => 'Brand', 'name' => 'Databit'],
            'url' => route('datastore.show'),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <x-brand-mark class="hidden lg:block absolute -right-8 -top-10 h-36 w-auto opacity-[0.08] pointer-events-none select-none" aria-hidden="true" />
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24 text-center relative">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-orange-500/15 text-orange-300 px-3 py-1 text-xs font-semibold mb-5 tracking-wide uppercase">
                DataStore · Portal de Vendas Web B2B
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
                Transforme seu portal no <span class="text-orange-400">seu melhor vendedor</span>
            </h1>
            <p class="text-brand-200 mt-5 max-w-2xl mx-auto text-lg">
                Portal de vendas web B2B 100% integrado com o DataClassic. Crie um portal totalmente personalizado,
                com catálogo, preços e condições comerciais controlados direto do ERP.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero conhecer o DataStore.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-600 transition">
                    Quero conhecer o DataStore
                </a>
                <a href="#funcionalidades" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                    Ver funcionalidades
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ([
                ['icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21M3 9l9-6 9 6v9.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V9z', 'value' => '100%', 'label' => 'Integrado ao DataClassic'],
                ['icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75', 'value' => 'B2B', 'label' => 'Venda direta para o seu cliente'],
                ['icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z', 'value' => 'Multi Tabela', 'label' => 'Preço e condição por cliente'],
                ['icon' => 'M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75', 'value' => '100%', 'label' => 'Personalizável, com sua cara'],
            ] as $stat)
                <div class="rounded-2xl bg-white border border-slate-200 shadow-lg shadow-slate-900/5 p-5 text-center">
                    <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-600 mb-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" /></svg>
                    </span>
                    <p class="font-bold text-slate-900 text-lg">{{ $stat['value'] }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Catálogo gerenciado no ERP --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                        Catálogo gerenciado no ERP
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">
                        Configure no cadastro de produto. Publique no portal, na hora.
                    </h2>
                    <p class="text-slate-500 mt-4">
                        Gerencie quais produtos irão para o portal definindo todos os parâmetros necessários dentro do
                        próprio DataClassic. Nada de cadastro duplicado ou planilha paralela: configure tudo no ERP e
                        o conteúdo já aparece imediatamente no portal.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ([
                        ['icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'label' => 'Descrição na loja'],
                        ['icon' => 'M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122', 'label' => 'Categorias e subcategorias'],
                        ['icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375', 'label' => 'Marcas'],
                        ['icon' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 19.5h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z', 'label' => 'Fotos e arquivos de apoio'],
                        ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'label' => 'OBS resumida'],
                        ['icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.02-.397-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z', 'label' => 'OBS técnica'],
                    ] as $field)
                        <div class="rounded-2xl border border-slate-200 bg-white p-5">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $field['icon'] }}" /></svg>
                            </span>
                            <p class="text-sm font-semibold text-slate-800">{{ $field['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Preços e condições comerciais --}}
    <section class="bg-slate-50 border-y border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-orange-50 text-orange-600 px-3 py-1 text-xs font-semibold mb-4">
                    Comercial sob medida
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Cada cliente vê o preço e a condição certa.</h2>
                <p class="text-slate-500 mt-3">
                    Gerencie tabelas de preço e defina qual tabela cada cliente terá acesso no portal — e quais
                    condições de pagamento ele pode usar na hora de fechar o pedido.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <div class="rounded-2xl bg-white border border-slate-200 p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-600 mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2">Tabela de preços por cliente</h3>
                    <p class="text-sm text-slate-500">Cada cliente enxerga apenas a tabela de preço configurada para ele no ERP, sem risco de exposição de condições comerciais de terceiros.</p>
                </div>
                <div class="rounded-2xl bg-white border border-slate-200 p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-600 mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2">Condições de pagamento</h3>
                    <p class="text-sm text-slate-500">Defina exatamente quais condições de pagamento cada cliente pode usar no checkout do portal, replicando a régua comercial do DataClassic.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Áreas de consulta integradas --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Autoatendimento integrado ao ERP
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Áreas de consulta que levam facilidade ao cliente.</h2>
                <p class="text-slate-500 mt-3">Tudo consultado em tempo real, direto do DataClassic — sem depender de ligação ou e-mail para o time comercial.</p>
            </div>
            <div class="grid sm:grid-cols-3 gap-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2">Consulta de notas</h3>
                    <p class="text-sm text-slate-500">O cliente busca o XML ou o DANFE de qualquer nota fiscal emitida contra ele, sem precisar solicitar ao time comercial.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2">Consulta financeira</h3>
                    <p class="text-sm text-slate-500">O cliente vê títulos pagos, em aberto e vencidos, com recurso para baixar o boleto ou atualizá-lo na hora.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H4.5a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18.375" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2">Consulta de créditos</h3>
                    <p class="text-sm text-slate-500">O cliente vê com facilidade os créditos disponíveis, sejam eles originados de devoluções ou de adiantamentos.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Benefícios comerciais + carrinho --}}
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="grid lg:grid-cols-2 gap-6">
                <div class="rounded-2xl bg-white/5 border border-white/15 p-8">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500/20 text-orange-300 mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H4.5a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18.375" /></svg>
                    </span>
                    <h3 class="font-bold text-white text-lg mb-2">Gestão de benefícios comerciais</h3>
                    <p class="text-brand-200 text-sm">
                        Recursos de campanhas de cashback, rebate, giftcard e outros — direto no portal, para
                        incentivar a recompra e fidelizar o cliente sem esforço manual da equipe comercial.
                    </p>
                </div>
                <div class="rounded-2xl bg-white/5 border border-white/15 p-8">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500/20 text-orange-300 mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                    </span>
                    <h3 class="font-bold text-white text-lg mb-2">Carrinho de compras inteligente</h3>
                    <p class="text-brand-200 text-sm">
                        Carrinho dinâmico que já integra online com o ERP: preço, condição de pagamento e disponibilidade
                        de estoque sempre atualizados, do início ao fechamento do pedido.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Recursos da loja --}}
    <section id="funcionalidades" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4">
                    Funcionalidades
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Uma loja B2B completa, não só um catálogo.</h2>
                <p class="text-slate-500 mt-3">
                    Recursos pensados para aumentar o ticket médio e a recorrência de compra, com a experiência de um
                    e-commerce moderno.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 21.53a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z', 'title' => 'Avaliação de produtos', 'desc' => 'Clientes avaliam os produtos comprados, gerando prova social para novas vendas dentro do próprio portal.'],
                    ['icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z', 'title' => 'Carrossel de destaque', 'desc' => 'Destaque lançamentos, promoções e produtos estratégicos logo na home do portal.'],
                    ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'title' => 'Produtos relacionados', 'desc' => 'Sugestão automática de itens relacionados para aumentar o ticket médio de cada pedido.'],
                    ['icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'title' => 'Compatibilidade de produtos', 'desc' => 'Indique compatibilidade entre itens (peças, insumos e equipamentos) e ajude o cliente a comprar certo.'],
                    ['icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'title' => 'Permissionamento por usuário', 'desc' => 'Escolha exatamente quais recursos cada cliente ou usuário do portal pode acessar.'],
                    ['icon' => 'M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75', 'title' => 'Personalização completa', 'desc' => 'Cores, layout e identidade visual do portal totalmente personalizáveis — deixando com a cara do seu negócio.'],
                ] as $feature)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 text-white mb-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}" /></svg>
                        </span>
                        <h3 class="font-semibold text-slate-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Ecossistema Databit --}}
    <section class="bg-slate-50 border-y border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 text-brand-700 px-3 py-1 text-xs font-semibold mb-4 tracking-wide uppercase">
                    Ecossistema Databit
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Um portal, um ERP, uma única fonte de verdade.</h2>
                <p class="text-slate-500 mt-3">
                    O DataStore não duplica cadastro nem processo: ele é a vitrine do que já está configurado no
                    DataClassic.
                </p>
            </div>
            <div class="grid sm:grid-cols-[1fr_auto_1fr] gap-6 items-center">
                <a href="{{ route('products.show', 'dataclassic') }}" class="rounded-2xl bg-white border border-slate-200 p-6 text-center hover:border-orange-300 transition">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21M3 9l9-6 9 6v9.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V9z" /></svg>
                    </span>
                    <h3 class="font-semibold text-slate-900">DataClassic ERP</h3>
                    <p class="text-sm text-slate-500 mt-2">
                        Cadastro de produtos, tabelas de preço, condições de pagamento e documentos fiscais — o núcleo
                        de dados de toda a operação.
                    </p>
                </a>
                <div class="hidden sm:flex justify-center text-slate-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </div>
                <div class="rounded-2xl bg-white p-6 text-center shadow-xl ring-4 ring-orange-500/20 relative">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-orange-500 px-3 py-1 text-[10px] font-bold text-white uppercase tracking-wide">Você está aqui</span>
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-orange-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                    </span>
                    <h3 class="font-bold text-slate-900">DataStore</h3>
                    <p class="text-sm text-slate-500 mt-2">
                        O portal de vendas B2B do seu cliente final: catálogo, carrinho, consultas e benefícios
                        comerciais, sempre espelhando o que está no ERP.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Pronto para colocar seu portal B2B para vender?</h2>
            <p class="text-brand-200 mt-3 max-w-2xl mx-auto">
                Fale com um especialista Databit e descubra como o DataStore pode se tornar o seu melhor vendedor.
                Demonstração gratuita e sem compromisso.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
                <a href="https://wa.me/553134168225?text={{ urlencode('Olá! Quero falar sobre o DataStore.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-600 transition">
                    Falar pelo WhatsApp
                </a>
                <a href="mailto:comercial@databit.com.br" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                    Enviar e-mail
                </a>
            </div>
        </div>
    </section>
@endsection
