<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Início') · Databit · Tecnologia para Gestão Empresarial</title>
    <meta name="description" content="@yield('description', 'Databit: sistemas de gestão empresarial (ERP), Cloud, mobilidade, atendimento ao cliente e serviços de TI. Mais de 30 anos transformando a gestão de empresas em todo o Brasil.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="icon" href="data:,">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Databit">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:title" content="@yield('title', 'Início') · Databit">
    <meta property="og:description" content="@yield('description', 'Databit: sistemas de gestão empresarial (ERP), Cloud, mobilidade, atendimento ao cliente e serviços de TI. Mais de 30 anos transformando a gestão de empresas em todo o Brasil.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/brand/logo-color.png'))">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Início') · Databit">
    <meta name="twitter:description" content="@yield('description', 'Databit: sistemas de gestão empresarial (ERP), Cloud, mobilidade, atendimento ao cliente e serviços de TI. Mais de 30 anos transformando a gestão de empresas em todo o Brasil.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/brand/logo-color.png'))">

    @if (config('services.google.site_verification'))
        <meta name="google-site-verification" content="{{ config('services.google.site_verification') }}">
    @endif

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Databit Tecnologia da Informação',
            'url' => url('/'),
            'logo' => asset('images/brand/logo-color.png'),
            'sameAs' => [
                'https://www.facebook.com',
                'https://www.instagram.com',
                'https://www.linkedin.com',
                'https://www.youtube.com',
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'R. Mário Campos, 197 - Inconfidência',
                'addressLocality' => 'Belo Horizonte',
                'addressRegion' => 'MG',
                'postalCode' => '30820-280',
                'addressCountry' => 'BR',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+55-31-3416-8225',
                'contactType' => 'customer service',
                'email' => 'atendimento@databit.com.br',
                'areaServed' => 'BR',
                'availableLanguage' => 'Portuguese',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'Databit',
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/busca').'?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @stack('schema')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if (config('services.google.analytics_id'))
        <script>
            window.databitAnalyticsId = @js(config('services.google.analytics_id'));
            window.dataLayer = window.dataLayer || [];
            function gtag(){ dataLayer.push(arguments); }
            window.gtag = gtag;

            // Só carrega o gtag.js (e só então começa a gravar cookies de
            // análise de audiência) depois que o visitante aceita o aviso
            // de cookies — antes disso, nada de Google Analytics é
            // carregado nesta página.
            window.loadGoogleAnalytics = function () {
                if (window.googleAnalyticsLoaded) return;
                window.googleAnalyticsLoaded = true;
                gtag('js', new Date());
                gtag('config', window.databitAnalyticsId, { anonymize_ip: true });
                var script = document.createElement('script');
                script.async = true;
                script.src = 'https://www.googletagmanager.com/gtag/js?id=' + window.databitAnalyticsId;
                document.head.appendChild(script);
            };

            try {
                if (localStorage.getItem('databit-cookie-consent') === 'accepted') {
                    window.loadGoogleAnalytics();
                }
            } catch (e) {}
        </script>
    @endif
</head>
<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800 antialiased">

    <a href="#conteudo" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:m-2 focus:rounded focus:bg-brand-700 focus:px-4 focus:py-2 focus:text-white">
        Pular para o conteúdo
    </a>

    @include('partials.topbar')
    @include('partials.header')
    @include('partials.notice-banner')

    <main id="conteudo" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    <x-whatsapp-float />
    <x-cookie-consent />
</body>
</html>
