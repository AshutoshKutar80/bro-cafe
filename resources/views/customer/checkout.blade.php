@extends('layouts.customer')
@section('title', 'Checkout — BRO CAFE')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="page-title">CHECKOUT</h1>
            <div class="checkout-layout">
                <form action="{{ route('checkout.place') }}" method="POST" class="checkout-form">
                    @csrf
                    <h3>DELIVERY DETAILS</h3>
                    <label>Full Name</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}"
                        required>

                    <label>Mobile</label>
                    <input type="text" name="customer_mobile"
                        value="{{ old('customer_mobile', auth()->user()->mobile) }}" required pattern="[0-9]{10}">

                    <label>Address</label>
                    <textarea name="delivery_address" required rows="3">{{ old('delivery_address') }}</textarea>

                    <div class="map-wrap">
                        <div id="map-picker" class="map-picker"></div>
                        <input type="hidden" name="delivery_lat" id="delivery_lat">
                        <input type="hidden" name="delivery_lng" id="delivery_lng">
                    </div>

                    <label>Notes (optional)</label>
                    <textarea name="notes" rows="2">{{ old('notes') }}</textarea>

                    <h3>PAYMENT</h3>
                    <div class="payment-options">
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span>💵 Cash on Delivery</span>
                        </label>
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="advance_qr">
                            <span>📱 50% Advance via UPI QR</span>
                        </label>
                    </div>

                    <div id="qr-box" style="display:none" class="qr-box">
                        <p>Scan &amp; pay 50% advance. Upload screenshot after payment.</p>
                        <div class="qr-placeholder">UPI QR</div>
                    </div>

                    <label>Coupon Code</label>
                    <input type="text" name="coupon_code" id="coupon-code" placeholder="Enter coupon">

                    <button type="submit" class="btn btn-yellow btn-lg btn-block">PLACE ORDER →</button>
                </form>

                <aside class="checkout-summary">
                    <h3>ORDER SUMMARY</h3>
                    @foreach ($cart->items as $item)
                        <div class="summary-row">
                            <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                            <span>₹{{ number_format($item->line_total, 0) }}</span>
                        </div>
                    @endforeach
                    <div class="summary-row"><span>Subtotal</span><span>₹{{ number_format($cart->subtotal, 0) }}</span>
                    </div>
                    <div class="summary-row"><span>Delivery</span><span>₹{{ number_format($deliveryCharge, 0) }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>TOTAL</span><span>₹{{ number_format($cart->subtotal + $deliveryCharge, 0) }}</span></div>
                </aside>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            BRO.initMapPicker('map-picker', 'delivery_lat', 'delivery_lng');
            document.querySelectorAll('input[name="payment_method"]').forEach(r => {
                r.addEventListener('change', e => {
                    document.getElementById('qr-box').style.display = e.target.value ===
                        'advance_qr' ? 'block' : 'none';
                });
            });
        });
    </script>
@endpush
