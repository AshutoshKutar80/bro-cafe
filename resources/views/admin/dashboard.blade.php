@extends('layouts.admin')
@section('title', 'Dashboard — Admin')
@section('heading', 'DASHBOARD')

@section('content')
    <div class="grid grid-stats">
        <div class="stat-card reveal">
            <p class="stat-label">TODAY'S ORDERS</p>
            <h3 class="stat-value" data-count="{{ $stats['today_orders'] }}">0</h3>
        </div>
        <div class="stat-card reveal">
            <p class="stat-label">TODAY'S SALES</p>
            <h3 class="stat-value" data-count="{{ $stats['today_sales'] }}">₹0</h3>
        </div>
        <div class="stat-card reveal">
            <p class="stat-label">PENDING ORDERS</p>
            <h3 class="stat-value" data-count="{{ $stats['pending_orders'] }}">0</h3>
        </div>
        <div class="stat-card reveal">
            <p class="stat-label">CUSTOMERS</p>
            <h3 class="stat-value" data-count="{{ $stats['total_customers'] }}">0</h3>
        </div>
        <div class="stat-card reveal">
            <p class="stat-label">ACTIVE RIDERS</p>
            <h3 class="stat-value" data-count="{{ $stats['active_riders'] }}">0</h3>
        </div>
        <div class="stat-card reveal">
            <p class="stat-label">PRODUCTS</p>
            <h3 class="stat-value" data-count="{{ $stats['total_products'] }}">0</h3>
        </div>
    </div>

    <h2 class="section-title" style="margin-top:40px">RECENT ORDERS</h2>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentOrders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>₹{{ number_format($order->total, 0) }}</td>
                        <td><span class="status-badge status-{{ $order->order_status }}">{{ $order->statusLabel() }}</span>
                        </td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">VIEW</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
