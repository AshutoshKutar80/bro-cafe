@extends('layouts.admin')
@section('title', 'Settings — Admin')
@section('heading', 'SETTINGS')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="form-box">
        @csrf
        <label>Cafe Name</label>
        <input type="text" name="cafe_name" value="{{ $settings['cafe_name'] }}" required>

        <label>Phone</label>
        <input type="text" name="cafe_phone" value="{{ $settings['cafe_phone'] }}">

        <label>Address</label>
        <textarea name="cafe_address" rows="3">{{ $settings['cafe_address'] }}</textarea>

        <label>Delivery Charge (₹)</label>
        <input type="number" step="0.01" name="delivery_charge" value="{{ $settings['delivery_charge'] }}" required>

        <label>Delivery Radius (km)</label>
        <input type="number" step="0.1" name="delivery_radius_km" value="{{ $settings['delivery_radius_km'] }}"
            required>

        <label>Minimum Order (₹)</label>
        <input type="number" step="0.01" name="min_order" value="{{ $settings['min_order'] }}" required>

        <button class="btn btn-yellow btn-lg">SAVE SETTINGS</button>
    </form>
@endsection
