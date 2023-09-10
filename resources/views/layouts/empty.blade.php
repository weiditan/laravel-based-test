<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    {{-- Laravel Vite - CSS File --}}
    @vite(['resources/sass/app.scss', 'resources/sass/custom.scss'])
</head>
<body class="m-0">
@yield('content')

{{-- Laravel Vite - JS File --}}
@vite(['resources/js/app.js'])
</body>
</html>
