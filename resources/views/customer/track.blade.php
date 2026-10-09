@extends('layouts.customer')
@section('title', 'Track Order — BRO CAFE')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="page-title">TRACK ORDER</h1>
            <p class="order-num">Order #{{ $order->order_number }}</p>

            <div class="timeline" id="order-timeline" data-status="{{ $order->order_status }}">
                @php
                    $steps = [
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'preparing' => 'Preparing',
                        'ready' => 'Ready',
                        'picked_up' => 'Picked Up',
                        'out_for_delivery' => 'Out for Delivery',
                        'delivered' => 'Delivered',
                    ];
                    $order_flow = array_keys($steps);
                    $currentIdx = array_search($order->order_status, $order_flow);
                    if ($currentIdx === false) {
                        $currentIdx = 0;
                    }
                @endphp
                @foreach ($steps as $key => $label)
                    @php $idx = array_search($key, $order_flow); @endphp
                    <div class="tl-step {{ $idx <= $currentIdx ? 'done' : '' }}">
                        <div class="tl-dot"></div>
                        <div class="tl-label">{{ strtoupper($label) }}</div>
                    </div>
                @endforeach
            </div>

            @if ($order->delivery && $order->delivery->partner)
                <div class="rider-card">
                    <h3>YOUR RIDER</h3>
                    <p><strong>{{ $order->delivery->partner->user->name }}</strong></p>
                    <a href="tel:{{ $order->delivery->partner->user->mobile }}" class="btn btn-yellow">📞 CALL</a>
                </div>
            @endif

            <div id="live-map" class="live-map"></div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = BRO.initLiveMap('live-map');

            setInterval(async () => {
                try {
                    const res = await fetch('/api/order/{{ $order->id }}/rider-location', {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': BRO.csrf()
                        }
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    if (data.success && data.location) {
                        BRO.updateRiderMarker(map, data.location.lat, data.location.lng);
                    }
                } catch (e) {}
            }, 10000);
        });
    </script>
@endpush
