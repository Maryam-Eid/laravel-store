@extends('layouts.app', ['pageTitle' => 'Edit Profile'])

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')
    <x-alert/>
    <form action="{{ route('dashboard.profile.update',) }}" method="post"
          enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                           id="first_name" required value="{{ old('first_name', $user->profile->first_name) }}">
                    @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                           id="last_name" required value="{{ old('last_name', $user->profile->last_name) }}">
                    @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control @error('birthdate') is-invalid @enderror"
                           id="birthdate" value="{{ old('birthdate', $user->profile->birthdate) }}">
                    @error('birthdate')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" id="gender"
                            required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender', $user->profile->gender) === 'Male' ? 'selected' : '' }}>
                            Male
                        </option>
                        <option
                            value="Female" {{ old('gender', $user->profile->gender) === 'Female' ? 'selected' : '' }}>
                            Female
                        </option>
                    </select>
                    @error('gender')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="street_address">Street Address</label>
                    <input type="text" name="street_address"
                           class="form-control @error('street_address') is-invalid @enderror"
                           id="street_address" value="{{ old('street_address', $user->profile->street_address) }}">
                    @error('street_address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                           id="city" value="{{ old('city', $user->profile->city) }}">
                    @error('city')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                           id="state" value="{{ old('state', $user->profile->state) }}">
                    @error('state')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" name="postal_code"
                           class="form-control @error('postal_code') is-invalid @enderror"
                           id="street_address" value="{{ old('postal_code', $user->profile->postal_code) }}">
                    @error('postal_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="country">Country</label>
                    <select name="country" class="form-control @error('country') is-invalid @enderror" id="country"
                            required>
                        <option value="">Select Country</option>
                        @foreach($countries as $code => $name)
                            <option
                                value="{{ $code }}" {{ old('country', $user->profile->country) == $code ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('country')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="locale">Locale</label>
                    <select name="locale" class="form-control @error('locale') is-invalid @enderror" id="locale">
                        <option value="">Select Locale</option>
                        @foreach($locales as $code => $name)
                            <option
                                value="{{ $code }}" {{ old('locale', $user->profile->locale) == $code ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('locale')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
