@extends('layouts.admin')
@section('title', ($partner->exists ? 'Edit' : 'New') . ' Partner')
@section('heading', ($partner->exists ? 'EDIT' : 'NEW') . ' PARTNER')

@section('content')
    <form method="POST"
        action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}"
        class="form-box">
        @csrf
        @if ($partner->exists)
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $e)
                    <p>{{ $e }}</p>
                @endforeach
            </div>
        @endif

        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $partner->user->name ?? '') }}" required>

        @unless ($partner->exists)
            <label>Mobile</label>
            <input type="tel" name="mobile" value="{{ old('mobile') }}" required pattern="[0-9]{10}">

            <label>Password</label>
            <input type="password" name="password" required>
        @endunless

        <label>Vehicle Type</label>
        <select name="vehicle_type" required>
            @foreach (['bike', 'scooter', 'bicycle', 'car'] as $v)
                <option value="{{ $v }}" @selected(old('vehicle_type', $partner->vehicle_type ?? 'bike') === $v)>{{ ucfirst($v) }}</option>
            @endforeach
        </select>

        <label>Vehicle Number</label>
        <input type="text" name="vehicle_number" value="{{ old('vehicle_number', $partner->vehicle_number) }}">

        <label class="check-row"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $partner->is_active ?? true))>
            Active</label>

        <button class="btn btn-yellow btn-lg">SAVE</button>
    </form>
@endsection
