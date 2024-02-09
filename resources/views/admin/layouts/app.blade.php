<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">

        <title>@yield('title') | {{ config('app.name', 'Herotchi_CMS') }}</title>

        <!-- favicon -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('img/Herotchi_CMS.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('img/Herotchi_CMS.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>

    </head>
    <body>
        @if (Auth::check())
        @include('admin.layouts.navbar')
        @endif
        <div class="container @if (Auth::check())my-3 @endif">
            <main>
                @yield('content')
            </main>
        </div>
        @include('admin.layouts.flash')
    </body>
</html>