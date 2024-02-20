@extends('layouts.app', ['pageTitle' => 'Categories'])

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->parent_id }}</td>
                <td>{{ $category->created_at }}</td>
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
@endsection