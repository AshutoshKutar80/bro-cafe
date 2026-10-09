@extends('layouts.customer')
@section('title', 'BRO CAFE — Good Coffee. Good Mood.')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="hero-grid">

                {{-- LEFT: GOOD COFFEE GOOD MOOD --}}
                <div class="hero-left">
                    <div>
                        <span class="hero-badge">BRO CAFE</span>
                        <h1 class="hero-title">
                            GOOD COFFEE<br>
                            <span class="block">GOOD MOOD</span>
                        </h1>
                        <p class="hero-sub">Freshly Brewed. Always Better.</p>
                    </div>
                    <a href="{{ route('menu') }}" class="hero-cta">
                        ORDER NOW <span>→</span>
                    </a>
                </div>

                {{-- CENTER: Coffee Cup --}}
                <div class="hero-center">
                    <div class="hero-cup">☕</div>
                </div>

                {{-- RIGHT: REAL COFFEE + EST --}}
                <div class="hero-right">
                    <div class="hero-right-top">
                        <h2>REAL<br>COFFEE<br>REAL<br>PEOPLE</h2>
                    </div>
                    <div class="hero-right-bottom">
                        <div class="est">EST.<br>2025<br>BRO CAFE</div>
                        <div class="emoji">😊</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Categories Section --}}
    <section style="padding: 40px 0;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="font-size: 28px;">EXPLORE CATEGORIES</h2>
                <a href="{{ route('menu') }}" class="btn btn-sm">VIEW ALL</a>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 16px;">
                @forelse(\App\Models\Category::active()->orderBy('sort_order')->take(6)->get() as $cat)
                    <a href="{{ route('menu', ['category' => $cat->slug]) }}"
                        style="background: var(--card-bg); border: 3px solid var(--border); padding: 20px; text-align: center; transition: all 150ms;"
                        onmouseover="this.style.background='var(--yellow)'; this.style.transform='translate(-3px,-3px)'; this.style.boxShadow='6px 6px 0 var(--black)';"
                        onmouseout="this.style.background='var(--card-bg)'; this.style.transform='none'; this.style.boxShadow='none';">
                        <div style="font-size: 40px; margin-bottom: 8px;">☕</div>
                        <div style="font-size: 13px; font-weight: 900; text-transform: uppercase;">{{ $cat->name }}</div>
                    </a>
                @empty
                    <p>No categories yet. Run: php artisan db:seed</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Featured Products --}}
    <section
        style="padding: 40px 0; background: var(--black); color: var(--white); border-top: 3px solid var(--border); border-bottom: 3px solid var(--border);">
        <div class="container">
            <h2 style="font-size: 28px; margin-bottom: 24px; color: var(--yellow);">POPULAR PICKS</h2>
            <div class="product-grid">
                @foreach (\App\Models\Product::available()->where('is_featured', true)->take(6)->get() as $product)
                    <div class="product-card">
                        <div class="product-img">
                            @if ($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            @else
                                ☕
                            @endif
                        </div>
                        <div class="product-info">
                            <h3>{{ $product->name }}</h3>
                            <div class="price">₹{{ number_format($product->price, 0) }}</div>
                            @auth
                                <button class="add-btn" data-add-to-cart="{{ $product->id }}">Add +</button>
                            @else
                                <a href="{{ route('login') }}" class="add-btn">Add +</a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
