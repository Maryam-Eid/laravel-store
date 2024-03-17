@php
    $user = \Illuminate\Support\Facades\Auth::user()
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" class="brand-link">
        <img src="{{ asset('dist/img/FastBagLogo.jpg') }}" alt="Code Box Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Fast Bag</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-wrap align-items-center">
            <div class="image">
                <img
                    src="{{ asset('dist/img/' . ($user->profile->gender === 'Male' ? 'MaleUser.jpg' : ($user->profile->gender === 'Female' ? 'FemaleUser.jpg' : 'User.jpg'))) }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('dashboard.profile.edit') }}">{{ $user->profile->first_name . ' ' . $user->profile->last_name }}</a>
            </div>
            <div class="info ml-auto">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn"><i class="fa-solid fa-power-off text-danger" title="Logout"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                       aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <x-nav/>
    </div>
</aside>

