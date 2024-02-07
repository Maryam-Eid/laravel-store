@include('layouts.head')
@include('layouts.partials.navbar')
@include('layouts.partials.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $pageTitle }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @section('breadcrumb')
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                        @show
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @yield('content')
        </div>

@include('layouts.partials.control-sidebar')
@include('layouts.footer')
