@php

    $pages =[
        ['Clientes', 'customers'],
        ['Funcionários', 'employees'],
        ['Produtos', 'products'],
        ['Categorias','categories'],
        ['Vendas','sales'],
        ['Estoque','inventories'],
        ['Promoção','promotions']
    ];

@endphp

{{-- {{Session::flush()}} --}}

<nav class="navbar navbar-expand-lg bg-light">

    <div class="container-fluid">

        <a class="navbar-brand" href="{{ url('') }}">{{ config('app.app_name') }}</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav">

                @if (Session::get('manager'))

                    <li class="nav-item dropdown">

                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Usuários
                        </a>

                        <div class="nav-item dropdown-menu">

                            <a href="{{ url('admins') }}" class="dropdown-item"><i class="fas fa-users"></i> Administração</a>

                            <a href="{{ url('users') }}" class="dropdown-item"><i class="bi bi-people-fill"></i> Usuários</a>

                            <a href="{{ url('people') }}" class="dropdown-item"><i class="bi bi-person-badge"></i> Pessoas</a>

                        </div>

                    </li>

                @endif

                @foreach ($pages as $page)

                    @if (Session::get('employee'))

                        @if ($page[0] != 'Funcionários')

                            <li class="nav-item">
                                <a href="{{ url($page[1]) }}" aria-current="page" class="nav-link">{{ $page[0] }}</a>
                            </li>

                        @endif

                    @else

                        @if (Session::get('customer'))

                            @if ($page[0] == 'Produtos' || $page[0] == 'Categorias' || $page[0] == 'Promoção')

                                <li class="nav-item">
                                    <a href="{{ url($page[1]) }}" aria-current="page" class="nav-link">{{ $page[0] }}</a>
                                </li>

                            @endif

                        @else

                            @if ($page[0] == 'Funcionários')


                                <li class="nav-item dropdown">

                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ $page[0] }}
                                    </a>

                                    <div class="nav-item dropdown-menu" aria-labelledby="navbarDropdown">

                                        <a href="{{ url($page[1]) }}" class="dropdown-item"><i class="fas fa-user-tie"></i> Funcionários</a>

                                        <a href="{{ url('/employees/roles') }}" class="dropdown-item">Cargos</a>
                                    </div>

                                </li>

                            @else

                                <li class="nav-item">
                                    <a href="{{ url($page[1]) }}" aria-current="page" class="nav-link">{{ $page[0] }}</a>
                                </li>

                            @endif


                        @endif

                    @endif

                @endforeach


            </ul>

            @if (Session::get('customer'))

                <ul class="navbar-nav ms-auto">
                    <div class="position-relative">

                        <button type="button" class="btn btn-light"><i class="bi bi-basket"></i>

                            @if(Session::has('itens'))

                                <span class="position-absolute badge rounded-pill bg-danger">{{ count(Session::get('itens')) }}</span>

                            @endif

                        </button>


                    </div>

                </ul>

                <ul class="navbar-nav ms-end">

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->customer->person->name }}
                        </a>

                        <div class="nav-item dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                            @if (Session::get('customer'))

                                <a href="{{ url('/customer/'.Auth::user()->customer_id.'/show') }}" class="dropdown-item"><i class="bi bi-person-fill"></i> Perfil</a>

                            @endif

                            <a class="dropdown-item" class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                Sair
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>

                    </li>

                </ul>

            @else

                @if (Session::get('employee'))

                <ul class="navbar-nav ms-auto ms-end">

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->employee->person->name }}
                        </a>

                        <div class="nav-item dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                            @if (Session::get('employee'))

                                <a href="{{ url('/employee/'.Auth::user()->employee_id.'/show') }}" class="dropdown-item"><i class="bi bi-person-fill"></i> Perfil</a>

                            @endif

                            <a class="dropdown-item" class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                Sair
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>

                    </li>

                </ul>

                @else

                    <ul class="navbar-nav ms-auto ms-end">

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->manager->person->name ?? '' }}
                            </a>

                            <div class="nav-item dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Sair
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>

                        </li>

                    </ul>

                @endif

            @endif

        </div>


    </div>

</nav>
