<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('partials._head')

<body>
    @include('partials._nav')
    @yield('content')

    @include('partials._footer')

    @include('partials._loader')

    @include('partials._scripts')
</body>

</html>