@extends('layouts.app', ['pageTitle' => 'Trashed Categories'])

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Categories</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection

@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left mr-1"></i> Back
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
            <th>Status</th>
            <th colspan="3">Deleted At</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    @if($category->status == 'active')
                        <span class="badge badge-success">{{ $category->status }}</span>
                    @else
                        <span class="badge badge-info">{{ $category->status }}</span>
                    @endif
                </td>
                <td>{{ $category->deleted_at->format('Y-m-d | h:i a') }}</td>
                <td class="d-flex">
                    <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="post">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn text-info">
                            <i class="fas fa-undo-alt" title="Restore"></i>
                        </button>
                    </form>
                    <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="post">
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
                <td colspan="7" class="py-4">No categories defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="m-4">
        {{ $categories->withQueryString()->links() }}
    </div>
@endsection
