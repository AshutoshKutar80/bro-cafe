@extends('layouts.admin')
@section('title', ($category->exists ? 'Edit' : 'New') . ' Category')
@section('heading', ($category->exists ? 'EDIT' : 'NEW') . ' CATEGORY')

@section('content')
    <form method="POST"
        action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        class="form-box">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required>

        <label>Image URL</label>
        <input type="text" name="image" value="{{ old('image', $category->image) }}">

        <label>Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}">

        <label class="check-row"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))>
            Active</label>

        <button class="btn btn-yellow btn-lg">SAVE</button>
    </form>
@endsection
