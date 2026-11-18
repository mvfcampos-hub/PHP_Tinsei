@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($page->content), 155))

@section('content')
<x-page-hero :title="$page->title" :subtitle="$page->excerpt" />
<section class="bg-white py-16">
    <div class="container-site max-w-4xl">
        <div class="prose prose-slate max-w-none prose-headings:font-display prose-headings:text-brand-900 prose-a:text-brand-700">
            {!! $page->content !!}
        </div>
        <p class="mt-12 text-xs text-slate-400">Última atualização: {{ $page->updated_at->format('d/m/Y') }}</p>
    </div>
</section>
@endsection
