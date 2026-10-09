@extends('layouts.customer')
@section('title', 'My Account — BRO CAFE')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="page-title">MY ACCOUNT</h1>

            <div class="account-grid">
                <div class="account-card reveal">
                    <h3>PROFILE</h3>
                    <p><strong>{{ $user->name }}</strong></p>
                    <p>{{ $user->mobile }}</p>
                    @if ($user->email)
                        <p>{{ $user->email }}</p>
                    @endif
                </div>

                <div class="account-card reveal">
                    <h3>THEME</h3>
                    <div class="theme-picker">
                        <button class="btn btn-outline" data-theme-set="light">☀ LIGHT</button>
                        <button class="btn btn-outline" data-theme-set="dark">☾ DARK</button>
                        <button class="btn btn-outline" data-theme-set="system">⚙ SYSTEM</button>
                    </div>
                </div>

                <div class="account-card reveal">
                    <h3>SAVED ADDRESSES</h3>
                    @forelse($addresses as $addr)
                        <div class="addr-row">
                            <div>
                                <strong>{{ $addr->label }}</strong>
                                <p>{{ $addr->address }}</p>
                            </div>
                            <form action="{{ route('account.address.delete', $addr->id) }}" method="POST"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">✕</button>
                            </form>
                        </div>
                    @empty
                        <p>No addresses saved.</p>
                    @endforelse

                    <form action="{{ route('account.address.store') }}" method="POST" class="addr-form">
                        @csrf
                        <input type="text" name="label" placeholder="Label (Home/Work)" required>
                        <textarea name="address" placeholder="Full address" required rows="2"></textarea>
                        <input type="text" name="landmark" placeholder="Landmark">
                        <button class="btn btn-yellow">ADD ADDRESS</button>
                    </form>
                </div>

                <div class="account-card reveal account-orders">
                    <h3>RECENT ORDERS</h3>
                    @forelse($orders as $order)
                        <div class="order-row">
                            <div>
                                <strong>#{{ $order->order_number }}</strong>
                                <p class="status-badge status-{{ $order->order_status }}">{{ $order->statusLabel() }}</p>
                            </div>
                            <div>₹{{ number_format($order->total, 0) }}</div>
                            <a href="{{ route('order.show', $order->order_number) }}"
                                class="btn btn-outline btn-sm">VIEW</a>
                        </div>
                    @empty
                        <p>No orders yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
