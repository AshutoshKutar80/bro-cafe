@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)
@section('heading', 'ORDER #' . $order->order_number)

@section('content')
    <div class="order-admin-grid">
        <div class="card">
            <h3>CUSTOMER</h3>
            <p><strong>{{ $order->customer_name }}</strong></p>
            <p>{{ $order->customer_mobile }}</p>
            <p>{{ $order->delivery_address }}</p>
        </div>

        <div class="card">
            <h3>ITEMS</h3>
            @foreach ($order->items as $item)
                <div class="summary-row">
                    <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                    <span>₹{{ number_format($item->line_total, 0) }}</span>
                </div>
            @endforeach
            <div class="summary-row"><span>Subtotal</span><span>₹{{ number_format($order->subtotal, 0) }}</span></div>
            <div class="summary-row"><span>Delivery</span><span>₹{{ number_format($order->delivery_charge, 0) }}</span></div>
            <div class="summary-row"><span>Discount</span><span>-₹{{ number_format($order->discount, 0) }}</span></div>
            <div class="summary-row total"><span>TOTAL</span><span>₹{{ number_format($order->total, 0) }}</span></div>
        </div>

        <div class="card">
            <h3>STATUS UPDATE</h3>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf
                <select name="order_status">
                    @foreach (['pending', 'accepted', 'preparing', 'ready', 'picked_up', 'out_for_delivery', 'delivered', 'cancelled', 'rejected'] as $s)
                        <option value="{{ $s }}" @selected($order->order_status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-yellow">UPDATE</button>
            </form>
        </div>

        <div class="card">
            <h3>ASSIGN PARTNER</h3>
            <form action="{{ route('admin.orders.assign', $order) }}" method="POST">
                @csrf
                <select name="partner_id" required>
                    <option value="">Select partner</option>
                    @foreach ($partners as $p)
                        <option value="{{ $p->id }}" @selected($order->delivery?->partner_id === $p->id)>
                            {{ $p->user->name }} — {{ $p->vehicle_number }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-yellow">ASSIGN</button>
            </form>
        </div>
    </div>
@endsection
