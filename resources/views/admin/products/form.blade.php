@extends('layouts.admin')
@section('title', ($product->exists ? 'Edit' : 'New') . ' Product')
@section('heading', ($product->exists ? 'EDIT' : 'NEW') . ' PRODUCT')

@section('content')
    <form method="POST"
        action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
        class="form-box">
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $e)
                    <p>{{ $e }}</p>
                @endforeach
            </div>
        @endif

        <label>Category</label>
        <select name="category_id" required>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>

        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>

        <label>Description</label>
        <textarea name="description" rows="3">{{ old('description', $product->description) }}</textarea>

        <label>Price (₹)</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>

        <label>Image URL</label>
        <input type="text" name="image" value="{{ old('image', $product->image) }}">

        <label>Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}">

        <label class="check-row"><input type="checkbox" name="is_available" value="1" @checked(old('is_available', $product->is_available ?? true))>
            Available</label>
        <label class="check-row"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))>
            Featured</label>
        <label class="check-row"><input type="checkbox" name="is_veg" value="1" @checked(old('is_veg', $product->is_veg ?? true))>
            Vegetarian</label>

        <button class="btn btn-yellow btn-lg">SAVE</button>
    </form>
@endsection
