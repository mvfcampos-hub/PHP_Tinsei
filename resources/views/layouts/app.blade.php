<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Início') · Databit · Tecnologia para Gestão Empresarial</title>
    <meta name="description" content="@yield('description', 'Databit: sistemas de gestão empresarial (ERP), Cloud, mobilidade, atendimento ao cliente e serviços de TI. Mais de 30 anos transformando a gestão de empresas em todo o Brasil.')">
    <link rel="icon" href="data:,">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
