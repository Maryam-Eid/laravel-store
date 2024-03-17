@extends('layouts.app', ['pageTitle' => 'Edit Product'])

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css"/>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
    <li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('content')

    <x-alert/>

    <form action="{{ route('dashboard.products.update', $product->id) }}" method="post"
          enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   id="name" required value="{{ old('name', $product->name) }}">
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                      id="description" rows="3">{{ old('description', $product->description) }}</textarea>
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
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" height="50">
            @endif
            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                       id="price" step="0.5" required value="{{ old('price', $product->price) }}">
                @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="compare_price">Compare Price</label>
                <input type="number" name="compare_price"
                       class="form-control @error('compare_price') is-invalid @enderror" id="compare_price"
                       step="0.5" value="{{ old('compare_price', $product->compare_price) }}">
                @error('compare_price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <input type="text" name="tags" class="form-control @error('tags') is-invalid @enderror" id="tags"
                   value="{{ old('tags', implode(',',$product->tags()->pluck('name')->toArray()) ) }}">
            @error('tags')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="active"
                           id="statusActive"
                           {{ old('status', $product->status) == 'active' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="statusActive">Active</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="draft"
                           id="statusDraft" {{ old('status', $product->status) == 'draft' ? 'checked' : '' }}>
                    <label class="form-check-label" for="statusDraft">Draft</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="archived"
                           id="statusArchived" {{ old('status', $product->status) == 'archived' ? 'checked' : '' }}>
                    <label class="form-check-label" for="statusArchived">Archived</label>
                </div>
            </div>
            @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify(inputElm);
    </script>
@endpush
