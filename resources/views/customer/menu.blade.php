@extends('layouts.customer')
@section('title', 'Menu — BRO CAFE')

@section('content')
    <div class="container">
        <div class="menu-layout">

            {{-- LEFT: Categories Sidebar --}}
            <aside class="sidebar">
                <div class="sidebar-title">Categories</div>
                <div class="cat-list">
                    <a href="{{ route('menu') }}" class="cat-item {{ !request('category') ? 'active' : '' }}">
                        <span class="icon">🍽️</span> All items
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('menu', ['category' => $cat->slug]) }}"
                            class="cat-item {{ request('category') === $cat->slug ? 'active' : '' }}">
                            <span class="icon">
                                @switch($cat->name)
                                    @case('Coffee')
                                        ☕
                                    @break

                                    @case('Cold Coffee')
                                        🧊
                                    @break

                                    @case('Tea')
                                        🍵
                                    @break

                                    @case('Shakes')
                                        🥤
                                    @break

                                    @case('Snacks')
                                        🍟
                                    @break

                                    @case('Desserts')
                                        🍰
                                    @break

                                    @default
                                        🍽️
                                @endswitch
                            </span>
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </aside>

            {{-- MIDDLE: Products --}}
            <div class="menu-main">
                <div class="menu-header">
                    <div>
                        <h1>Our Menu</h1>
                        <p>Fresh Ingredients. Great Taste.</p>
                    </div>
                </div>

                @if ($products->count())
                    <div class="product-grid">
                        @foreach ($products as $product)
                            <div class="product-card">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <div class="product-img">
                                        @if ($product->image)
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                        @else
                                            ☕
                                        @endif
                                    </div>
                                </a>
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
                    <div style="margin-top: 20px;">{{ $products->links() }}</div>
                @else
                    <div style="text-align: center; padding: 60px 20px; border: 3px dashed var(--border);">
                        <div style="font-size: 64px; margin-bottom: 16px;">☕</div>
                        <h3>No items found</h3>
                        <a href="{{ route('menu') }}" class="btn" style="margin-top: 16px;">RESET FILTERS</a>
                    </div>
                @endif
            </div>

            {{-- RIGHT: Banner --}}
            <aside class="menu-banner">
                <h2>BETTER<br>COFFEE<br>BIGGER<br>DREAMS</h2>
                <div class="illustration">🥤</div>
                <div class="tag">BRO CAFE</div>
            </aside>

        </div>
    </div>
@endsection
