<!DOCTYPE html>
<html lang="en" class="theme-transition" data-theme="light">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'BRO CAFE — Good Coffee. Good Mood.')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Space+Grotesk:wght@400;500;700;900&family=Inter:wght@400;500;700&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/brutal.css') }}">
        <script>
            (function() {
                var saved = localStorage.getItem('theme') || 'system';
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                var effective = saved === 'system' ? (prefersDark ? 'dark' : 'light') : saved;
                document.documentElement.setAttribute('data-theme', effective);
            })();
        </script>
        @stack('styles')
    </head>

    <body>

        @include('partials.navbar')

        <main class="page-enter">
            @if (session('success'))
                <div class="toast toast-success" data-toast>{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="toast toast-error" data-toast>{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>

        @include('partials.footer')

        <script src="{{ asset('js/brutal.js') }}"></script>
        @stack('scripts')
    </body>

</html>
