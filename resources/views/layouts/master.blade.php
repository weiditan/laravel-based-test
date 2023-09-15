<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/seiko-logo.png') }}">
    <title>@yield('title')</title>

    {{-- Laravel Vite - CSS File --}}
    @vite(['resources/sass/app.scss', 'resources/sass/custom.scss'])
</head>
<body class="m-0">
<div class="d-flex flex-row vh-100">
    <div class="side-menu p-3">
        <a class="d-flex align-items-center nav-link link-dark" href="{{ route('home') }}">
            <span class="mdi mdi-laravel mdi-36px me-2"></span>
            <h1>Laravel</h1>
        </a>
        <hr>
        <div class="flex-grow-1 overflow-auto">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route("user.listing") }}" class="nav-link {{ true ? "active" : "link-dark" }}"
                       aria-current="page">
                        <span class="mdi mdi-account me-2"></span>
                        User
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="side-content flex-grow-1 overflow-auto">
        <header class="top-header top-header-box d-flex justify-content-between align-items-center px-4">
            <div>
                <div class="d-block d-md-none dropdown">
                    <a class="btn" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <span class="mdi mdi-menu mdi-24px"></span>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ route("user.listing") }}">
                                <span class="mdi mdi-account me-2"></span>
                                User
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="dropdown">
                <a class="btn" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    @if($profile_image = auth()->user()->getFirstDocument("profile_image"))
                        <img class="profile-image-round-45"
                             src="{{ $profile_image->url }}"
                             alt="{{ $profile_image->file_name }}"/>
                    @else
                        <img class="profile-image-round-45"
                             src="{{ asset('assets/images/profile-placeholder.jpg') }}"
                             alt="profile-placeholder"/>
                    @endif
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li>
                        <a class="dropdown-item" href="{{ route("user.detail", ["user_id" => auth()->user()->id]) }}">
                            {{ auth()->user()->full_name }}
                        </a>
                    </li>
                    <li>
                        <hr/>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route("logout") }}">
                            <span class="mdi mdi-logout me-2"></span>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </header>
        <div class="top-header-box"></div>
        <div class="p-4">
            <h3 class="mb-4">@yield('title')</h3>
            @if(Session::has('success_msg'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! Session::get('success_msg') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-warning px-4 py-2 mb-2">{{ $error }}</div>
                @endforeach
            @endif
            @yield('content')
        </div>
    </div>
</div>

{{-- Laravel Vite - JS File --}}
@vite(['resources/js/app.js'])

@yield('script')
</body>
</html>
