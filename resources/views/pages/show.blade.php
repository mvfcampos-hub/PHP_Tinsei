@extends('layouts.app')

@section('title', $page->title)
@section('description', \Illuminate\Support\Str::limit(strip_tags($page->content), 155))
@section('canonical', route('pages.show', $page->slug))

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

        @if ($page->slug === 'fale-conosco')
            <div class="not-prose mt-10">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Siga a Databit nas redes sociais</h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach ([
                        ['name' => 'WhatsApp', 'handle' => '(31) 3416-8225', 'url' => 'https://wa.me/553134168225', 'icon' => 'M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z'],
                        ['name' => 'Facebook', 'handle' => 'web.facebook.com/databitbh', 'url' => 'https://web.facebook.com/databitbh', 'icon' => 'M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94z'],
                        ['name' => 'Instagram', 'handle' => '@databit.oficial', 'url' => 'https://www.instagram.com/databit.oficial/', 'icon' => 'M12 2c2.72 0 3.06.01 4.12.06 1.06.05 1.79.22 2.43.47.66.26 1.21.6 1.76 1.15.5.5.9 1.1 1.15 1.76.25.64.42 1.37.47 2.43C21.99 8.94 22 9.28 22 12s-.01 3.06-.06 4.12c-.05 1.06-.22 1.79-.47 2.43a4.9 4.9 0 01-1.15 1.76c-.5.5-1.1.9-1.76 1.15-.64.25-1.37.42-2.43.47C15.06 21.99 14.72 22 12 22s-3.06-.01-4.12-.06c-1.06-.05-1.79-.22-2.43-.47a4.9 4.9 0 01-1.76-1.15 4.9 4.9 0 01-1.15-1.76c-.25-.64-.42-1.37-.47-2.43C2.01 15.06 2 14.72 2 12s.01-3.06.06-4.12c.05-1.06.22-1.79.47-2.43.26-.66.6-1.21 1.15-1.76A4.9 4.9 0 015.45.54c.64-.25 1.37-.42 2.43-.47C8.94.01 9.28 0 12 0zm0 5a5 5 0 100 10 5 5 0 000-10zm0 8.2a3.2 3.2 0 110-6.4 3.2 3.2 0 010 6.4zm5.2-8.4a1.17 1.17 0 100-2.34 1.17 1.17 0 000 2.34z'],
                        ['name' => 'LinkedIn', 'handle' => 'linkedin.com/company/databit-tecnologia-da-informação', 'url' => 'https://www.linkedin.com/company/databit-tecnologia-da-informa%C3%A7%C3%A3o/', 'icon' => 'M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.62 0 4.29 2.38 4.29 5.48v6.26zM5.34 7.43a2.07 2.07 0 110-4.13 2.07 2.07 0 010 4.13zM7.12 20.45H3.56V9h3.56v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z'],
                        ['name' => 'YouTube', 'handle' => 'youtube.com/channel/UC1U62hUG7LxuCn7w80AsqEw', 'url' => 'https://www.youtube.com/channel/UC1U62hUG7LxuCn7w80AsqEw', 'icon' => 'M23.5 6.2a3.02 3.02 0 00-2.12-2.14C19.51 3.5 12 3.5 12 3.5s-7.51 0-9.38.56A3.02 3.02 0 00.5 6.2 31.6 31.6 0 000 12a31.6 31.6 0 00.5 5.8 3.02 3.02 0 002.12 2.14c1.87.56 9.38.56 9.38.56s7.51 0 9.38-.56a3.02 3.02 0 002.12-2.14A31.6 31.6 0 0024 12a31.6 31.6 0 00-.5-5.8zM9.6 15.6V8.4l6.4 3.6-6.4 3.6z'],
                        ['name' => 'E-mail', 'handle' => 'atendimento@databit.com.br', 'url' => 'mailto:atendimento@databit.com.br', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ] as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener" class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 hover:border-brand-300 hover:shadow-md transition">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="{{ $social['icon'] }}" /></svg>
                            </span>
                            <span class="min-w-0">
                                <span class="block font-semibold text-slate-900">{{ $social['name'] }}</span>
                                <span class="block text-sm text-slate-500 truncate">{{ $social['handle'] }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="mt-10 rounded-2xl overflow-hidden border border-slate-200 shadow-sm not-prose">
                <iframe
                    src="https://www.google.com/maps?q={{ urlencode('R. Mário Campos, 197 - Inconfidência, Belo Horizonte - MG, 30820-280') }}&output=embed"
                    class="w-full h-80 sm:h-96"
                    style="border:0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Localização da Databit"
                ></iframe>
            </div>
            <a
                href="https://maps.app.goo.gl/Y4YGdrJBr5TxJvMk6"
                target="_blank" rel="noopener"
                class="not-prose inline-flex items-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-800 mt-4"
            >
                Abrir no Google Maps
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
            </a>
        @endif
    </article>
@endsection
