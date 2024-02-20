@extends('layouts.app', ['pageTitle' => 'Edit Category'])

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Edit Category</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.categories.update', [$category->id]) }}" method="post"
          enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="container my-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" class="form-control" id="name" required
                               value="{{ $category->name }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="parent_id">Category Parent</label>
                        <select name="parent_id" class="form-control">
                            <option value="">Primary Category</option>
                            @foreach($parents as $parent)
                                <option
                                    value="{{ $parent->id }}" @selected($category->parent_id == $parent->id) >{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description"
                          rows="3">{{ $category->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control-file" id="image" accept="image/*
            </div>
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="category_image" height="50" >
            @endif

            <div class="form-group">
                <label>Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="active"
                           id="statusActive" @checked($category->status == 'active')>
                    <label class="form-check-label" for="statusActive">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="archived"
                           id="statusArchived" @checked($category->status == 'archived')>
                    <label class="form-check-label" for="statusArchived">Archived</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
@endsection
