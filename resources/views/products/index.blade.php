@extends('layouts.app')

@section('title', 'Sistemas')
@section('description', 'Conheça os sistemas Databit: ERP DataClassic, mobilidade, atendimento ao cliente, documentos fiscais, CRM, comunicação e integrações.')

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                Ecossistema Databit
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white">Aprimore sua gestão empresarial</h1>
            <p class="text-brand-200 mt-4 max-w-2xl mx-auto">
                Soluções modulares de fácil usabilidade, integradas ao redor do DataClassic — o núcleo do
                ecossistema Databit.
            </p>
        </div>

        @if ($ecosystemHub)
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-16">
                <p class="hidden lg:block text-center text-sm text-brand-200 mb-8">
                    Clique em qualquer módulo para conhecer os detalhes
                </p>
                <x-ecosystem-diagram :hub="$ecosystemHub" :satellites="$ecosystemSatellites" />
            </div>
        @endif
    </section>

    {{-- Soluções de sistemas --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-10">
            <span class="text-xs font-semibold text-accent-600 uppercase tracking-wide">Soluções de sistemas</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">ERP, mobilidade, atendimento, fiscal, CRM, comunicação e integrações</h2>
            <p class="text-slate-500 mt-2 max-w-2xl">Módulos integrados ao redor do DataClassic, o núcleo do ecossistema Databit.</p>
        </div>

        <div class="space-y-14">
            @forelse ($systemProducts as $category => $items)
                <div>
                    <h3 class="text-lg font-bold text-slate-900 mb-6">
                        {{ \App\Models\Product::CATEGORIES[$category] ?? $category }}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($items as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-slate-500 text-center">Nenhuma solução de sistema cadastrada no momento.</p>
            @endforelse
        </div>
    </section>

    {{-- Cloud & Infraestrutura --}}
    @if ($cloudProducts->isNotEmpty())
        <section class="bg-brand-950 bg-grid-pattern">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                    <div>
                        <span class="text-xs font-semibold text-accent-400 uppercase tracking-wide">Infraestrutura, não sistema</span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white mt-1">Cloud & Infraestrutura</h2>
                        <p class="text-brand-200 mt-2 max-w-2xl">Máquinas virtuais e infraestrutura sob demanda para hospedar os seus sistemas — tratado à parte das soluções de sistemas.</p>
                    </div>
                    <a href="{{ route('cloud.show') }}" class="inline-flex items-center gap-1 text-accent-300 font-medium hover:text-accent-200 shrink-0">
                        Ver planos DataCloud
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($cloudProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Serviços de TI e Produtos de informática têm páginas próprias --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-10">
            <span class="text-xs font-semibold text-accent-600 uppercase tracking-wide">Além dos sistemas e do DataCloud</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Serviços de TI e Produtos de informática</h2>
            <p class="text-slate-500 mt-2 max-w-2xl">Ofertas de serviço e de hardware, tratadas à parte das soluções de sistemas — cada uma com o seu próprio espaço.</p>
        </div>
        <div class="grid sm:grid-cols-2 gap-6">
            <a href="{{ route('it-services.show') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-0.5 transition">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" /></svg>
                </span>
                <div>
                    <p class="font-semibold text-slate-900">Serviços de TI</p>
                    <p class="text-sm text-slate-500 mt-1">Suporte, outsourcing, monitoramento e consultoria de tecnologia.</p>
                </div>
            </a>
            <a href="{{ route('hardware.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-lg hover:-translate-y-0.5 transition">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                </span>
                <div>
                    <p class="font-semibold text-slate-900">Produtos de informática</p>
                    <p class="text-sm text-slate-500 mt-1">Notebooks, servidores, periféricos e demais equipamentos.</p>
                </div>
            </a>
        </div>
    </section>
@endsection
