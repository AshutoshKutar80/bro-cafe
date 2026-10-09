@extends('layouts.partner')
@section('title', 'Partner Dashboard — BRO CAFE')

@section('content')
    <div class="partner-online-card">
        <div>
            <h3>{{ auth()->user()->name }}</h3>
            <p>Completed deliveries: <strong>{{ $completed }}</strong></p>
        </div>
        <form action="{{ route('partner.toggle.online') }}" method="POST">
            @csrf
            <button class="btn {{ $partner->is_online ? 'btn-success' : 'btn-outline' }} btn-lg">
                {{ $partner->is_online ? '🟢 GO OFFLINE' : '⚪ GO ONLINE' }}
            </button>
        </form>
    </div>

    <h2 class="section-title">ASSIGNED ORDERS</h2>
    @forelse($assigned as $d)
        <div class="partner-order-card">
            <div class="po-head">
                <strong>#{{ $d->order->order_number }}</strong>
                <span class="status-badge status-{{ $d->order->order_status }}">{{ $d->order->statusLabel() }}</span>
            </div>
            <p>📍 {{ $d->order->delivery_address }}</p>
            <p>📞 {{ $d->order->customer_mobile }}</p>
            <p>₹{{ number_format($d->order->total, 0) }} — {{ strtoupper($d->order->payment_method) }}</p>
            <a href="{{ route('partner.order.show', $d) }}" class="btn btn-yellow">VIEW DETAILS →</a>
        </div>
    @empty
        <div class="empty-state">
            <h3>No active assignments</h3>
            <p>Go online and wait for orders.</p>
        </div>
    @endforelse
@endsection
