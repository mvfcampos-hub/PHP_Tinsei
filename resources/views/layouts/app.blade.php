<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Início') · CRN-9 · Conselho Regional de Nutrição da 9ª Região</title>
    <meta name="description" content="@yield('description', 'Portal oficial do Conselho Regional de Nutrição da 9ª Região (CRN-9): notícias, agenda de eventos, banco de oportunidades, revista, fiscalização e serviços ao profissional de nutrição.')">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/brand/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/brand/apple-icon-180x180.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800 antialiased">

    <a href="#conteudo" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:m-2 focus:rounded focus:bg-brand-700 focus:px-4 focus:py-2 focus:text-white">
        Pular para o conteúdo
    </a>

    @include('partials.topbar')
    @include('partials.header')

    <main id="conteudo" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp-button')
</body>
</html>
