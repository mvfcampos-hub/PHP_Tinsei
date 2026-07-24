@extends('layouts.app')

@section('title', $job->title)

@section('content')
    <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 mb-6">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
            Voltar para o banco de oportunidades
        </a>

        <h1 class="text-3xl font-bold text-slate-900">{{ $job->title }}</h1>
        <p class="text-slate-500 mt-2">
            @if ($job->company) {{ $job->company }} &middot; @endif
            {{ $job->location }}
            @if ($job->contract_type) &middot; {{ $job->contract_type }} @endif
        </p>

        <div class="prose prose-slate max-w-none mt-8">
            <p>{{ $job->description }}</p>
        </div>

        <div class="mt-10 rounded-2xl bg-brand-50 p-6">
            <h2 class="font-semibold text-slate-900 mb-3">Como se candidatar</h2>
            <ul class="text-sm text-slate-700 space-y-1">
                @if ($job->contact_email)
                    <li>E-mail: <a href="mailto:{{ $job->contact_email }}" class="text-brand-700 hover:underline">{{ $job->contact_email }}</a></li>
                @endif
                @if ($job->contact_phone)
                    <li>Telefone: {{ $job->contact_phone }}</li>
                @endif
                @if ($job->external_url)
                    <li><a href="{{ $job->external_url }}" target="_blank" rel="noopener" class="text-brand-700 hover:underline">Candidatar-se pelo link externo</a></li>
                @endif
            </ul>
        </div>
    </article>
@endsection
