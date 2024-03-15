@extends('layouts.app', ['pageTitle' => 'products'])

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">products</li>
@endsection

@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-primary mr-2">
            <i class="fas fa-plus-circle mr-1"></i> Create
        </a>
    </div>

    <x-alert/>

    <form action="{{ \Illuminate\Support\Facades\URL::current() }}" method="get"
          class="d-flex justify-content-between mb-4">
        <input name="name" placeholder="Name" class="form-control mx-2" value="{{ request('name') }}">
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>
        <button class="btn btn-dark mx-2">Filter</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th colspan="3">Created At</th>
        </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category_name }}</td>
                <td>{{ $product->store_name }}</td>
                <td>
                    @if($product->status == 'active')
                        <span class="badge badge-success">{{ $product->status }}</span>
                    @else
                        <span class="badge badge-info">{{ $product->status }}</span>
                    @endif
                </td>
                <td>{{ $product->created_at->format('Y-m-d | h:i a') }}</td>
                <td class="d-flex">
                    <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn text-secondary">
                        <i class="fas fa-edit" title="Edit"></i>
                    </a>
                    <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn text-danger">
                            <i class="fas fa-trash-alt" title="Delete"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr class="text-center bg-cyan">
                <td colspan="9" class="py-4">No products defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="m-4">
        {{ $products->withQueryString()->links() }}
    </div>
@endsection
