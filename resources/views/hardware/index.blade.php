@extends('layouts.app')

@section('title', 'Produtos')
@section('description', 'A Databit apoia a escolha e a compra de produtos de informática: notebooks, desktops, servidores, periféricos, celulares, firewall, wi-fi, nobreak e CFTV.')

@section('content')
    <section class="bg-brand-950 bg-grid-pattern">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-4">
                Produtos de informática
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white">Soluções completas, robustas e modernas</h1>
            <p class="text-brand-200 mt-4 max-w-2xl mx-auto text-lg">
                Apoiamos nossos clientes na escolha e na compra de produtos de informática — do notebook da equipe
                ao servidor que roda o seu sistema. Vamos juntos simplificar a sua gestão?
            </p>
            <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Preciso de ajuda para escolher produtos de informática.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition mt-8">
                Falar com um especialista
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 mb-4">
                        <x-dynamic-component :component="$category['icon']" class="h-6 w-6" />
                    </span>
                    <p class="font-semibold text-slate-900">{{ $category['name'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">{{ $category['description'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Não sabe qual equipamento escolher?</h2>
                <p class="text-brand-100 mt-2">Conte com a Databit para indicar a solução certa para o seu orçamento e o seu projeto.</p>
            </div>
            <a href="https://wa.me/5531997278589?text={{ urlencode('Olá! Preciso de ajuda para escolher produtos de informática.') }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition">
                Falar com um especialista
            </a>
        </div>
    </section>
@endsection
