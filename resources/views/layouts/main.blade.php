<!DOCTYPE html>
<html lang="pt-br">

    @include('components.head')

    <body>

        @if (Route::current()->getName() != "login" && Route::current()->getName() != "register")

            @include('components.header')

        @endif

        <div class="container pt-4 pb-4">
            @yield('content')
        </div>

        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/sales.js') }}"></script>
        <script src="{{ asset('assets/js/alert.js') }}"></script>
        <script src="{{ asset('assets/js/mask.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.mask.js') }}"></script>

    </body>


</html>
