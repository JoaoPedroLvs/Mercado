<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

</head>

    <body>
        <header>
            <a href="/">Página inicial</a>
            <a href="/customers">Clientes</a>
            <a href="/products">Produtos</a>
            <a href="/employees">Funcionários</a>
            <a href="/categories">Categorias</a>
            <a href="/sales">Vendas</a>
            <a href="/inventories">Estoque</a>
            <a href="/promotions">Promoções</a>
        </header>

        @yield('content')

    </body>

</html>
