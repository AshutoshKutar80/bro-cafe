<!DOCTYPE html>
<html lang="en" class="theme-transition">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Partner — BRO CAFE')</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Space+Grotesk:wght@400;500;700&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/brutal.css') }}">
        <script>
            (function() {
                const saved = localStorage.getItem('theme') || 'system';
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const effective = saved === 'system' ? (prefersDark ? 'dark' : 'light') : saved;
                document.documentElement.setAttribute('data-theme', effective);
            })();
        </script>
    </head>

    <body class="partner-body">
        <header class="partner-header">
            <div class="partner-logo">🛵 BRO<span>CAFE</span> PARTNER</div>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button class="btn btn-dark btn-sm">LOGOUT</button>
            </form>
        </header>

        <main class="partner-main">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>

        <script src="{{ asset('js/brutal.js') }}"></script>
        @stack('scripts')
    </body>

</html>
