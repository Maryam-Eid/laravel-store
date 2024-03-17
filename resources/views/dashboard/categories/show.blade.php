@extends('layouts.app', ['pageTitle' => $category->name])

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th colspan="2">Created At</th>
        </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->store->name }}</td>
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
                <td colspan="5" class="py-4">No products defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="m-4">
        {{ $products->links() }}
    </div>
@endsection
