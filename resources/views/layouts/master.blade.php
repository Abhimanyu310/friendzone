<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        {{--<link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">--}}
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
        <link rel="stylesheet" href="{{ URL::to('src/css/user-profile.css') }}">
        @yield('styles-head')

    </head>
    <body>

    @include('includes.header')

    <div class="container">
        @yield('content')
    </div>

    {{--@include('includes.footer')--}}
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"   integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="   crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="{{ URL::to('src/js/app.js') }}"></script>
    @yield('styles')

    </body>
</html>