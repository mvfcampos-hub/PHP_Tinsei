@extends('layouts.app')

@section('title', $document->title)

@section('content')
    <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('library.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mb-6">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
            Voltar para a Biblioteca Virtual
        </a>

        <h1 class="text-3xl font-bold text-slate-900">{{ $document->title }}</h1>
        @if ($document->published_at)
            <p class="text-slate-500 mt-2 text-sm">Publicado em {{ $document->published_at->format('d/m/Y') }}</p>
        @endif

        @if ($document->description)
            <div class="prose prose-slate max-w-none mt-6">
                <p>{{ $document->description }}</p>
            </div>
        @endif

        @if ($document->files->isNotEmpty())
            <div class="mt-10">
                <h2 class="font-semibold text-slate-900 mb-4">Arquivos</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach ($document->files as $file)
                        <a
                            href="{{ $file->url }}" target="_blank" rel="noopener"
                            class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 hover:border-brand-300 hover:shadow-sm transition"
                        >
                            <svg class="h-5 w-5 shrink-0 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H8a2 2 0 01-2-2V5a2 2 0 012-2h6l6 6v11a2 2 0 01-2 2z" /></svg>
                            <span class="text-sm font-medium text-slate-800">{{ $file->label }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <p class="mt-10 text-sm text-slate-500">Nenhum arquivo publicado para este item até o momento.</p>
        @endif
    </article>
@endsection
