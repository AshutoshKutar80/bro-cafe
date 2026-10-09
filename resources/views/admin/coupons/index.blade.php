@extends('layouts.admin')
@section('title', 'Coupons — Admin')
@section('heading', 'COUPONS')

@section('content')
    <div class="toolbar">
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-yellow">+ NEW COUPON</a>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Min Order</th>
                    <th>Used</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $c)
                    <tr>
                        <td>{{ $c->code }}</td>
                        <td>{{ $c->type }}</td>
                        <td>{{ $c->type === 'flat' ? '₹' : '' }}{{ $c->value }}{{ $c->type === 'percent' ? '%' : '' }}
                        </td>
                        <td>₹{{ $c->min_order }}</td>
                        <td>{{ $c->used_count }}{{ $c->usage_limit ? ' / ' . $c->usage_limit : '' }}</td>
                        <td>{{ $c->is_active ? '✅' : '❌' }}</td>
                        <td>
                            <a href="{{ route('admin.coupons.edit', $c) }}" class="btn btn-outline btn-sm">EDIT</a>
                            <form action="{{ route('admin.coupons.destroy', $c) }}" method="POST"
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
    {{ $coupons->links() }}
@endsection
