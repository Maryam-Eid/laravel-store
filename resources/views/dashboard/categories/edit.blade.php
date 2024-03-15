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
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               id="name" required value="{{ old('name', $category->name) }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="parent_id">Category Parent</label>
                        <select name="parent_id" class="form-control  @error('parent_id') is-invalid @enderror">
                            <option value="">Primary Category</option>
                            @foreach($parents as $parent)
                                <option
                                    value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description"
                          rows="3">{{ $category->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                          id="description"
                          rows="3">{{ old('description', $category->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror"
                       id="image" accept="image/*">
            </div>
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="category_image" height="50">
            @endif
            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <div class="form-group mt-2">
                <label>Status</label>
                <div class="form-check">
                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status"
                           value="active"
                           id="statusActive" @checked(old('status', $category->status) == 'active')>
                    <label class="form-check-label" for="statusActive">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input @error('status', $category->status) is-invalid @enderror"
                           type="radio" name="status" value="archived"
                           id="statusArchived" @checked(old('status') == 'archived')>
                    <label class="form-check-label" for="statusArchived">Archived</label>
                </div>
                @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
@endsection
