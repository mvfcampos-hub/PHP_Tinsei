@extends('layouts.app')

@section('title', $page->title)

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">{{ $page->title }}</h1>
            <div class="prose prose-slate max-w-3xl prose-a:text-brand-700 mt-4">
                {!! $page->content !!}
            </div>
        </div>
    </section>

    @if ($relatedPages->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-lg font-bold uppercase tracking-wide text-slate-900 border-b border-slate-200 pb-2 mb-6">
                Serviços disponíveis
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($relatedPages as $item)
                    <a
                        href="{{ route('pages.show', $item->slug) }}"
                        class="group flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-5 hover:shadow-lg hover:-translate-y-0.5 hover:border-brand-200 transition-all duration-300"
                    >
                        <span class="text-sm font-semibold text-slate-700 group-hover:text-brand-800">{{ $item->title }}</span>
                        <svg class="h-4 w-4 text-slate-400 group-hover:text-brand-700 shrink-0 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
