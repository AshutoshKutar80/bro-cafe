@extends('layouts.customer')
@section('title', $product->name . ' — BRO CAFE')

@section('content')
    <section class="section">
        <div class="container product-detail">
            <div class="pd-image reveal">
                <div class="pd-img-box">
                    <span>{{ $product->name[0] }}</span>
                    <div class="yellow-frame"></div>
                </div>
            </div>
            <div class="pd-info reveal">
                <p class="pd-cat">{{ strtoupper($product->category->name) }}</p>
                <h1 class="pd-name">{{ $product->name }}</h1>
                <p class="pd-desc">{{ $product->description }}</p>
                <p class="pd-price">₹{{ number_format($product->price, 0) }}</p>

                @auth
                    <div class="pd-actions">
                        <input type="number" id="qty" value="1" min="1" max="20" class="qty-input">
                        <button class="btn btn-yellow btn-lg" data-add-to-cart="{{ $product->id }}" data-qty-input="qty">
                            ADD TO CART
                        </button>
                        <a href="{{ route('cart') }}" class="btn btn-dark btn-lg">GO TO CART</a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-yellow btn-lg">LOGIN TO ORDER</a>
                @endauth
            </div>
        </div>
    </section>

    @if ($related->count())
        <section class="section section-dark">
            <div class="container">
                <h2 class="section-title">YOU MAY ALSO LIKE</h2>
                <div class="grid grid-products">
                    @foreach ($related as $r)
                        <a href="{{ route('product.show', $r->slug) }}" class="product-card reveal">
                            <div class="product-img"><span>{{ $r->name[0] }}</span></div>
                            <div class="product-body">
                                <h3>{{ $r->name }}</h3>
                                <span class="price">₹{{ number_format($r->price, 0) }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
