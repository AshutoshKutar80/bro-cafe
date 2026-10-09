<!DOCTYPE html>
<html lang="en" class="theme-transition">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Admin — BRO CAFE')</title>
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

    <body class="admin-body">
        <aside class="admin-sidebar">
            <div class="admin-logo">☕ BRO<span>CAFE</span></div>
            <nav>
                <a href="{{ route('admin.dashboard') }}">DASHBOARD</a>
                <a href="{{ route('admin.products.index') }}">PRODUCTS</a>
                <a href="{{ route('admin.categories.index') }}">CATEGORIES</a>
                <a href="{{ route('admin.orders.index') }}">ORDERS</a>
                <a href="{{ route('admin.partners.index') }}">PARTNERS</a>
                <a href="{{ route('admin.coupons.index') }}">COUPONS</a>
                <a href="{{ route('admin.settings') }}">SETTINGS</a>
            </nav>
            <form action="{{ route('logout') }}" method="POST" style="padding:16px">
                @csrf
                <button class="btn btn-dark btn-block">LOGOUT</button>
            </form>
        </aside>
        <main class="admin-main">
            <header class="admin-header">
                <h1>@yield('heading', 'Admin')</h1>
                <button class="theme-toggle" onclick="BRO.toggleTheme()">☀/☾</button>
            </header>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </main>
        <script src="{{ asset('js/brutal.js') }}"></script>
        @stack('scripts')
    </body>

</html>
