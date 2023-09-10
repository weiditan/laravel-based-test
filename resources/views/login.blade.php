@extends('layouts.empty')

@section('title')
    Login
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="bg-white p-5 rounded-4 shadow" style="max-width: 500px; width: 95%">
            <form id="form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="d-flex align-items-center justify-content-center mb-3">
                    <span class="mdi mdi-laravel mdi-48px me-2"></span>
                    <h1>Laravel</h1>
                </div>

                @if ($errors->any())
                    <div class="py-3">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-warning px-4 py-2 mb-2">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="row row-gap-3">
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old("email") }}">
                    </div>
                    <div class="col-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>

                <div class="mt-5">
                    <button class="btn btn-primary w-100" type="submit">Log In</button>
                </div>
            </form>
        </div>
    </div>

@endsection
