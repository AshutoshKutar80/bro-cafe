<header class="navbar">
    <div class="nav-wrap">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="logo">
            <span class="logo-badge">BRO</span>
            <span class="logo-text">CAFE</span>
        </a>

        {{-- Nav Links --}}
        <nav class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'active' : '' }}">Menu</a>
            <a href="#">Offers</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </nav>

        {{-- Search --}}
        <div class="nav-search">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Search your favorite coffee..." id="nav-search">
        </div>

        {{-- Actions --}}
        <div class="nav-actions">
            {{-- Theme Toggle --}}
            <button class="icon-btn" onclick="BRO.toggleTheme()" title="Toggle theme" id="theme-btn">
                <span class="theme-icon">☀</span>
            </button>

            {{-- User --}}
            @auth
                <a href="{{ route('account') }}" class="icon-btn" title="Account">👤</a>
            @else
                <a href="{{ route('login') }}" class="icon-btn" title="Login">👤</a>
            @endauth

            {{-- Cart --}}
            <a href="{{ route('cart') }}" class="icon-btn" title="Cart">
                🛒
                @auth
                    <span class="cart-badge" id="cart-count">{{ auth()->user()->cart?->count ?? 0 }}</span>
                @else
                    <span class="cart-badge" id="cart-count">0</span>
                @endauth
            </a>
        </div>
    </div>
</header>

<script>
    // Update theme icon on load
    document.addEventListener('DOMContentLoaded', function() {
        const updateIcon = () => {
            const theme = document.documentElement.getAttribute('data-theme');
            document.querySelector('.theme-icon').textContent = theme === 'dark' ? '☾' : '☀';
        };
        updateIcon();
        window.addEventListener('theme-changed', updateIcon);
    });
</script>
