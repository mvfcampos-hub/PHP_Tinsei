@php
    $siteName = setting('company_name', 'Tinsei');
    $defaultDescription = 'Tinsei: importação, recondicionamento e distribuição de equipamentos de impressão, suprimentos e peças. Maior importadora de equipamentos A3 a laser do Brasil, com sede em Belo Horizonte e clientes em todo o país.';
    $gaId = setting('google_analytics_id');
@endphp
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>document.documentElement.classList.add('js')</script>
    <title>@hasSection('title')@yield('title') · {{ $siteName }}@else{{ $siteName }} · {{ setting('tagline') }}@endif</title>
    <meta name="description" content="@yield('description', $defaultDescription)">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    @if (config('app.noindex'))
        <meta name="robots" content="noindex, nofollow">
    @else
        <meta name="robots" content="@yield('robots', 'index, follow')">
    @endif
    <meta name="theme-color" content="#003b5a">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:title" content="@yield('title', $siteName)">
    <meta property="og:description" content="@yield('description', $defaultDescription)">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/site/sede-tinsei.jpg'))">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|sora:500,600,700,800&display=swap" rel="stylesheet">

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName,
            'legalName' => setting('legal_name'),
            'url' => url('/'),
            'logo' => asset('images/brand/logo-tinsei-color.png'),
            'foundingDate' => setting('founded_year'),
            'sameAs' => array_values(array_filter([setting('instagram_url'), setting('youtube_url'), setting('linkedin_url'), setting('facebook_url')])),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Anel Rodoviário Celso Mello Azevedo, 1206 - Olhos D\'Água',
                'addressLocality' => 'Belo Horizonte',
                'addressRegion' => 'MG',
                'postalCode' => '30390-085',
                'addressCountry' => 'BR',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+55 '.setting('phone'),
                'email' => setting('email'),
                'contactType' => 'customer service',
                'areaServed' => 'BR',
                'availableLanguage' => 'Portuguese',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @stack('schema')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if ($gaId)
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){ dataLayer.push(arguments); }
            window.gtag = gtag;
            // O Google Analytics só é carregado depois que o visitante aceita os cookies.
            window.loadGoogleAnalytics = function () {
                if (window.googleAnalyticsLoaded) return;
                window.googleAnalyticsLoaded = true;
                gtag('js', new Date());
                gtag('config', @js($gaId), { anonymize_ip: true });
                var s = document.createElement('script');
                s.async = true;
                s.src = 'https://www.googletagmanager.com/gtag/js?id=' + @js($gaId);
                document.head.appendChild(s);
            };
            try { if (localStorage.getItem('tinsei-cookie-consent') === 'accepted') window.loadGoogleAnalytics(); } catch (e) {}
        </script>
    @endif
</head>
<body class="min-h-screen flex flex-col bg-white text-slate-700 antialiased overflow-x-hidden">
    <a href="#conteudo" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:m-2 focus:rounded focus:bg-brand-800 focus:px-4 focus:py-2 focus:text-white">Pular para o conteúdo</a>

    @include('partials.notice-banner')
    @include('partials.topbar')
    @include('partials.header')

    <main id="conteudo" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    <x-whatsapp-float />
    <x-cookie-consent />
</body>
</html>
