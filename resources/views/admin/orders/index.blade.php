@extends('layouts.admin')
@section('title', 'Orders — Admin')
@section('heading', 'ORDERS')

@section('content')
    <form method="GET" class="filter-row">
        <input type="text" name="q" placeholder="Order # or mobile" value="{{ request('q') }}">
        <select name="status">
            <option value="">All Status</option>
            @foreach (['pending', 'accepted', 'preparing', 'ready', 'picked_up', 'out_for_delivery', 'delivered', 'cancelled', 'rejected'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button class="btn btn-yellow">FILTER</button>
    </form>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Mobile</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_mobile }}</td>
                        <td>₹{{ number_format($order->total, 0) }}</td>
                        <td><span
                                class="status-badge status-pay-{{ $order->payment_status }}">{{ $order->payment_status }}</span>
                        </td>
                        <td><span class="status-badge status-{{ $order->order_status }}">{{ $order->statusLabel() }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d M, H:i') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">VIEW</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
@endsection
