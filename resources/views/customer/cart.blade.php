@extends('layouts.customer')
@section('title', 'Cart — BRO CAFE')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="page-title">YOUR CART</h1>

            @if ($cart->items->count())
                <div class="cart-layout">
                    <div class="cart-items">
                        @foreach ($cart->items as $item)
                            <div class="cart-item reveal" data-item-row="{{ $item->id }}">
                                <div class="ci-img">{{ $item->product->name[0] ?? '?' }}</div>
                                <div class="ci-info">
                                    <h3>{{ $item->product->name ?? 'Item' }}</h3>
                                    <p>₹{{ number_format($item->price_snapshot, 0) }} each</p>
                                </div>
                                <div class="ci-qty">
                                    <button class="qty-btn" data-cart-update="{{ $item->id }}"
                                        data-qty="{{ $item->quantity - 1 }}">−</button>
                                    <span class="qty-val">{{ $item->quantity }}</span>
                                    <button class="qty-btn" data-cart-update="{{ $item->id }}"
                                        data-qty="{{ $item->quantity + 1 }}">+</button>
                                </div>
                                <div class="ci-total">₹{{ number_format($item->line_total, 0) }}</div>
                                <button class="btn btn-danger btn-sm" data-cart-remove="{{ $item->id }}">✕</button>
                            </div>
                        @endforeach
                    </div>

                    <aside class="cart-summary">
                        <h3>SUMMARY</h3>
                        <div class="summary-row"><span>Subtotal</span><span>₹{{ number_format($cart->subtotal, 0) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery</span><span>₹{{ number_format(\App\Models\Setting::get('delivery_charge', 40), 0) }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>TOTAL</span><span>₹{{ number_format($cart->subtotal + \App\Models\Setting::get('delivery_charge', 40), 0) }}</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-yellow btn-lg btn-block">PROCEED →</a>
                    </aside>
                </div>
            @else
                <div class="empty-state reveal">
                    <div class="empty-art">🛒</div>
                    <h3>Your cart is empty</h3>
                    <a href="{{ route('menu') }}" class="btn btn-yellow">BROWSE MENU</a>
                </div>
            @endif
        </div>
    </section>
@endsection
