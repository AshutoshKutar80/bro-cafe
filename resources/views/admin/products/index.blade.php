@extends('layouts.admin')
@section('title', 'Products — Admin')
@section('heading', 'PRODUCTS')

@section('content')
    <div class="toolbar">
        <a href="{{ route('admin.products.create') }}" class="btn btn-yellow">+ NEW PRODUCT</a>
        <form method="GET" class="inline-form">
            <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}">
            <button class="btn btn-outline">SEARCH</button>
        </form>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th>Featured</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->category->name }}</td>
                        <td>₹{{ number_format($p->price, 0) }}</td>
                        <td>{{ $p->is_available ? '✅' : '❌' }}</td>
                        <td>{{ $p->is_featured ? '⭐' : '—' }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-outline btn-sm">EDIT</a>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="POST"
                                onsubmit="return confirm('Delete?')" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">DEL</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $products->links() }}
@endsection
