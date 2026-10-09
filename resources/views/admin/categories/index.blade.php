@extends('layouts.admin')
@section('title', 'Categories — Admin')
@section('heading', 'CATEGORIES')

@section('content')
    <div class="toolbar">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-yellow">+ NEW CATEGORY</a>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Order</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $c)
                    <tr>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->slug }}</td>
                        <td>{{ $c->sort_order }}</td>
                        <td>{{ $c->is_active ? '✅' : '❌' }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.categories.edit', $c) }}" class="btn btn-outline btn-sm">EDIT</a>
                            <form action="{{ route('admin.categories.destroy', $c) }}" method="POST"
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
    {{ $categories->links() }}
@endsection
