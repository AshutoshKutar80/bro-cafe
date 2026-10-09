@extends('layouts.customer')
@section('title', 'Order ' . $order->order_number)

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="page-title">ORDER #{{ $order->order_number }}</h1>

            <div class="card">
                <h3>STATUS</h3>
                <span class="status-badge status-{{ $order->order_status }}">{{ $order->statusLabel() }}</span>
            </div>

            <div class="card">
                <h3>ITEMS</h3>
                @foreach ($order->items as $item)
                    <div class="summary-row">
                        <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                        <span>₹{{ number_format($item->line_total, 0) }}</span>
                    </div>
                @endforeach
                <div class="summary-row total"><span>TOTAL</span><span>₹{{ number_format($order->total, 0) }}</span></div>
            </div>

            <a href="{{ route('order.track', $order->order_number) }}" class="btn btn-yellow btn-lg">TRACK ORDER →</a>
        </div>
    </section>
@endsection
