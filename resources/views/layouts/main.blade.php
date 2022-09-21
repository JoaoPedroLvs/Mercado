<!DOCTYPE html>
<html lang="pt-br">

    @include('components.head')

    <body class="{{ $backgorund ?? '' }}">

        @php
            $route = Route::current()->getName();
        @endphp

        @if ($route != "login" && $route != "register" && $route != "password.reset" && $route != "password.request")

            @include('components.header')

        @endif

        <div class="container pt-4 pb-4">
            @yield('content')
        </div>

        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.min.js') }}"></script>

    </body>


</html>
