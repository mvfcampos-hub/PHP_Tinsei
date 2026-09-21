@extends('layouts.app')

@section('title', 'Banco de Oportunidades')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Banco de Oportunidades</h1>
                    <p class="text-slate-500 mt-2">Vagas de emprego e oportunidades para nutricionistas</p>
                </div>
                <a href="{{ route('jobs.submit') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition">
                    Cadastrar oportunidade
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="space-y-4">
            @forelse ($jobs as $job)
                <article class="rounded-2xl border border-slate-200 bg-white p-6 hover:shadow-md transition">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 class="font-semibold text-lg text-slate-900">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="hover:text-brand-700">{{ $job->title }}</a>
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                @if ($job->company) {{ $job->company }} &middot; @endif
                                {{ $job->location }}
                            </p>
                        </div>
                        @if ($job->contract_type)
                            <span class="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-700">
                                {{ $job->contract_type }}
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-slate-600 mt-3 line-clamp-2">{{ $job->description }}</p>
                    <a href="{{ route('jobs.show', $job->slug) }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mt-4">
                        Ver detalhes
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </article>
            @empty
                <p class="text-slate-500">Nenhuma vaga disponível no momento.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $jobs->links() }}
        </div>
    </section>
@endsection
