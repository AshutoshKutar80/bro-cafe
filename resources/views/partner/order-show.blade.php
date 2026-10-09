@extends('layouts.partner')
@section('title', 'Order — BRO CAFE Partner')

@section('content')
    <div class="partner-order-detail">
        <h2>#{{ $delivery->order->order_number }}</h2>
        <p class="status-badge status-{{ $delivery->status }}">{{ strtoupper(str_replace('_', ' ', $delivery->status)) }}</p>

        <div class="card">
            <h3>DELIVER TO</h3>
            <p><strong>{{ $delivery->order->customer_name }}</strong></p>
            <p>{{ $delivery->order->delivery_address }}</p>
            <a href="tel:{{ $delivery->order->customer_mobile }}" class="btn btn-yellow">📞 CALL CUSTOMER</a>
        </div>

        <div class="card">
            <h3>ITEMS</h3>
            @foreach ($delivery->order->items as $item)
                <div class="summary-row">
                    <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                    <span>₹{{ number_format($item->line_total, 0) }}</span>
                </div>
            @endforeach
            <div class="summary-row total"><span>COLLECT</span><span>₹{{ number_format($delivery->order->total, 0) }}</span>
            </div>
            <p>Payment: {{ strtoupper($delivery->order->payment_method) }}</p>
        </div>

        <div class="status-actions">
            <form action="{{ route('partner.order.status', $delivery) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="picked_up">
                <button class="btn btn-yellow btn-lg btn-block" @disabled($delivery->status !== 'assigned')>PICKED UP</button>
            </form>
            <form action="{{ route('partner.order.status', $delivery) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="out_for_delivery">
                <button class="btn btn-yellow btn-lg btn-block" @disabled($delivery->status !== 'picked_up')>OUT FOR DELIVERY</button>
            </form>
            <form action="{{ route('partner.order.status', $delivery) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="delivered">
                <button class="btn btn-success btn-lg btn-block" @disabled($delivery->status !== 'out_for_delivery')>DELIVERED</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Live location sharing while delivery active
        @if (in_array($delivery->status, ['assigned', 'picked_up', 'out_for_delivery']))
            if (navigator.geolocation) {
                const pushLocation = () => {
                    navigator.geolocation.getCurrentPosition(pos => {
                        BRO.pushRiderLocation(pos.coords.latitude, pos.coords.longitude,
                            {{ $delivery->order_id }});
                    }, () => {}, {
                        enableHighAccuracy: true,
                        maximumAge: 5000
                    });
                };
                pushLocation();
                setInterval(pushLocation, 10000);
            }
        @endif
    </script>
@endpush
