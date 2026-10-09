@extends('layouts.admin')
@section('title', ($coupon->exists ? 'Edit' : 'New') . ' Coupon')
@section('heading', ($coupon->exists ? 'EDIT' : 'NEW') . ' COUPON')

@section('content')
    <form method="POST"
        action="{{ $coupon->exists ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}"
        class="form-box">
        @csrf
        @if ($coupon->exists)
            @method('PUT')
        @endif

        <label>Code</label>
        <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required>

        <label>Type</label>
        <select name="type">
            <option value="flat" @selected(old('type', $coupon->type) === 'flat')>Flat</option>
            <option value="percent" @selected(old('type', $coupon->type) === 'percent')>Percent</option>
        </select>

        <label>Value</label>
        <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value) }}" required>

        <label>Min Order</label>
        <input type="number" step="0.01" name="min_order" value="{{ old('min_order', $coupon->min_order) }}">

        <label>Max Discount</label>
        <input type="number" step="0.01" name="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}">

        <label>Valid From</label>
        <input type="date" name="valid_from"
            value="{{ old('valid_from', optional($coupon->valid_from)->format('Y-m-d')) }}">

        <label>Valid To</label>
        <input type="date" name="valid_to" value="{{ old('valid_to', optional($coupon->valid_to)->format('Y-m-d')) }}">

        <label>Usage Limit</label>
        <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}">

        <label class="check-row"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $coupon->is_active ?? true))>
            Active</label>

        <button class="btn btn-yellow btn-lg">SAVE</button>
    </form>
@endsection
