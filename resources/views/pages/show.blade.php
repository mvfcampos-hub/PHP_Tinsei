@extends('layouts.app')

@section('title', $page->title)

@section('content')
    <section class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">{{ $page->title }}</h1>
        </div>
    </section>

    <article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="prose prose-slate max-w-none prose-a:text-brand-700">
            {!! $page->content !!}
        </div>
    </article>
@endsection
