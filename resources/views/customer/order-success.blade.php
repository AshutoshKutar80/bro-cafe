@extends('layouts.customer')
@section('title', 'Order Placed — BRO CAFE')

@section('content')
    <section class="section success-section">
        <div class="container">
            <div class="success-box">
                <svg class="checkmark" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="46" fill="none" stroke="currentColor" stroke-width="4" />
                    <path d="M28 52 L44 68 L74 36" fill="none" stroke="currentColor" stroke-width="6"
                        stroke-linecap="round" />
                </svg>
                <h1>ORDER PLACED!</h1>
                <p>Your order <strong>#{{ $order->order_number }}</strong> is confirmed.</p>
                <p class="total">Total: ₹{{ number_format($order->total, 0) }}</p>
                <div class="hero-actions">
                    <a href="{{ route('order.track', $order->order_number) }}" class="btn btn-yellow btn-lg">TRACK ORDER
                        →</a>
                    <a href="{{ route('menu') }}" class="btn btn-outline btn-lg">BACK TO MENU</a>
                </div>
            </div>
            <div class="confetti">
                @for ($i = 0; $i < 20; $i++)
                    <span class="conf-piece" style="--i:{{ $i }}"></span>
                @endfor
            </div>
        </div>
    </section>
@endsection
