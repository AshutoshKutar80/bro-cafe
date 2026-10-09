@extends('layouts.admin')
@section('title', 'Delivery Partners — Admin')
@section('heading', 'DELIVERY PARTNERS')

@section('content')
    <div class="toolbar">
        <a href="{{ route('admin.partners.create') }}" class="btn btn-yellow">+ NEW PARTNER</a>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Vehicle</th>
                    <th>Online</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $p)
                    <tr>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->user->mobile }}</td>
                        <td>{{ $p->vehicle_type }} — {{ $p->vehicle_number }}</td>
                        <td>{{ $p->is_online ? '🟢' : '⚪' }}</td>
                        <td>{{ $p->is_active ? '✅' : '❌' }}</td>
                        <td>
                            <a href="{{ route('admin.partners.edit', $p) }}" class="btn btn-outline btn-sm">EDIT</a>
                            <form action="{{ route('admin.partners.destroy', $p) }}" method="POST"
                                onsubmit="return confirm('Remove?')" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">DEL</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $partners->links() }}
@endsection
