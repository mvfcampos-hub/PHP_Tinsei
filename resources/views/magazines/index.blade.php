@extends('layouts.app')

@section('title', 'Revista CRN-9')

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Revista CRN-9</h1>
            <p class="text-slate-500 mt-2">Edições da revista periódica do conselho</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($magazines as $magazine)
                <article class="rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-md transition">
                    <div class="aspect-[3/4] bg-slate-100">
                        @if ($magazine->cover_image)
                            <img src="{{ Storage::url($magazine->cover_image) }}" alt="{{ $magazine->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-brand-100 to-brand-200 text-brand-700 font-semibold text-center p-4">
                                {{ $magazine->title }}
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-slate-900 text-sm leading-snug">{{ $magazine->title }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $magazine->edition }}</p>
                        <div class="flex gap-3 mt-3">
                            @if ($magazine->pdf_file)
                                <a href="{{ Storage::url($magazine->pdf_file) }}" target="_blank" class="text-xs font-medium text-brand-700 hover:underline">Baixar PDF</a>
                            @endif
                            @if ($magazine->external_url)
                                <a href="{{ $magazine->external_url }}" target="_blank" rel="noopener" class="text-xs font-medium text-brand-700 hover:underline">Acessar edição</a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-slate-500 col-span-full">Nenhuma edição publicada no momento.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $magazines->links() }}
        </div>
    </section>
@endsection
