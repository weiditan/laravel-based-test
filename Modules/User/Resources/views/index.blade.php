@extends('layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('user.name') !!}
    </p>
    <button type="button" class="btn btn-primary">Primary</button>
@endsection
