@php

    $pages =[
        ['Clientes', 'customers'],
        ['Produtos', 'products'],
        ['Funcionários', 'employees'],
        ['Categorias','categories'],
        ['Vendas','sales'],
        ['Estoque','inventories'],
        ['Promoção','promotion']
    ];

@endphp

<nav class="navbar navbar-expand-lg bg-light">

    <div class="container-fluid">

        <a class="navbar-brand" href="{{ url('') }}">{{ config('app.app_name') }}</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav">

                @foreach ($pages as $page)

                    <li class="nav-item">
                        <a href="{{ url($page[1]) }}" aria-current="page" class="nav-link">{{ $page[0] }}</a>
                    </li>

                @endforeach

            </ul>

        </div>

    </div>

</nav>
