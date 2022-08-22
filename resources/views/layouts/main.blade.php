<!DOCTYPE html>
<html lang="pt-br">

    @include('components.head')

    <body>
        @include('components.header')

        <div class="container pt-4 pb-4">
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        <script src="/js/sales.js"></script>
    </body>


</html>
