@extends('layouts.app', ['pageTitle' => 'Categories'])

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
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
            <th>Parent</th>
            <th>Status</th>
            <th colspan="3">Created At</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->parentCategory->name ?? '' }}</td>
                <td>
                    @if($category->status == 'active')
                        <span class="badge badge-success">{{ $category->status }}</span>
                    @else
                        <span class="badge badge-info">{{ $category->status }}</span>
                    @endif
                </td>
                <td>{{ $category->created_at->format('Y-m-d | h:i a') }}</td>
                <td>
                    <a href="{{ route('dashboard.categories.edit', [$category->id]) }}"
                       class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{ route('dashboard.categories.destroy', [$category->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr class="text-center bg-cyan">
                <td colspan="7" class="py-4">No categories defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="m-4">
        {{ $categories->withQueryString()->links() }}
    </div>
@endsection
