@extends('layouts.app')

@section('title', 'Notícias')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Notícias</h1>
            <p class="text-slate-500 mt-2">Acompanhe as novidades e comunicados do CRN-9</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($news as $item)
                <x-news-card :news="$item" />
            @empty
                <p class="text-slate-500 col-span-full">Nenhuma notícia publicada no momento.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $news->links() }}
        </div>
    </section>
@endsection
