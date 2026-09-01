@extends('layouts.app')

@section('title', 'Biblioteca Virtual do CRN-9')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Biblioteca Virtual do CRN-9</h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Acervo de publicações técnicas, cartilhas, livros e artigos produzidos ou selecionados pelo CRN-9 e por suas Câmaras Técnicas, à disposição da categoria e da sociedade.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <form method="get" class="mb-8 flex flex-wrap gap-3">
            <input
                type="text" name="q" value="{{ request('q') }}"
                placeholder="Buscar por título ou assunto..."
                class="w-full sm:w-80 rounded-lg border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
            >
            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 transition">
                Buscar
            </button>
            @if (request('q'))
                <a href="{{ route('library.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700">Limpar busca</a>
            @endif
        </form>

        <p class="text-sm text-slate-500 mb-4">{{ $documents->total() }} publicação(ões) encontrada(s)</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($documents as $document)
                <a href="{{ route('library.show', $document) }}" class="rounded-2xl border border-slate-200 bg-white p-5 hover:border-brand-300 hover:shadow-sm transition flex flex-col">
                    <svg class="h-8 w-8 text-brand-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    <h2 class="font-semibold text-slate-900 leading-snug">{{ $document->title }}</h2>
                    @if ($document->description)
                        <p class="text-sm text-slate-500 mt-2 line-clamp-3">{{ $document->description }}</p>
                    @endif
                    <p class="text-xs text-slate-400 mt-4">
                        {{ $document->files_count }} arquivo(s)
                        @if ($document->published_at)
                            &middot; {{ $document->published_at->format('d/m/Y') }}
                        @endif
                    </p>
                </a>
            @empty
                <p class="text-slate-500 col-span-full">Nenhuma publicação encontrada.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $documents->links() }}
        </div>
    </section>
@endsection
