@extends('layouts.main', [
    'pageTitle' => 'Cargos'
])

@section('content')

    <div class="page page-roles page-index">

        <div class="page-header">
            <h1><a href="{{ url('employees/roles') }}">Cargos</a> <small>Listagem de cargos</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls mb-3">

                <a href="{{ url('employees/role/create') }}" class="btn btn-primary">Criar novo cargo</a>

            </div>

            <div class="row g-3">

                <div class="col-md-6">

                    <form action="/employees/roles" method="get">

                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                            <div class="input-group-append">

                                <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>

                            </div>
                        </div>

                    </form>

                </div>

                <div class="col-md-6">

                    <form action="/employees" method="get">
                        @csrf


                        <div class="input-group">

                            <select name="qtyPaginate" id="qtyPaginate" class="form-control select-qty" data-url="/employees">

                                <option {{ $qtyPaginate == 10 ? 'selected' : '' }}>Quantos itens deseja aparecer</option>
                                <option data-value="10">10</option>
                                <option data-value="25" {{ $qtyPaginate == 25 ? 'selected' : '' }}>25</option>
                                <option data-value="50" {{ $qtyPaginate == 50 ? 'selected' : '' }}>50</option>

                            </select>

                        </div>


                    </form>

                </div>

            </div>

            @if ($search)

                <h4>Pesquisando por <small>{{ $search }}</small></h4>

            @endif

            @if (count($roles) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th class="order" data-url="/employees/roles" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc'}}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/employees/roles" data-field="name" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Name <span><small><i class="bi bi-caret-down d-none name"></i><i class="bi bi-caret-up d-none name"></small></span></th>
                            <th class="order" data-url="/employees/roles" data-field="qty_employees" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Quantidade de funcionário <span><small><i class="bi bi-caret-down d-none qty_employees"></i><i class="bi bi-caret-up d-none qty_employees"></small></span></th>
                            <th>Data de criação</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($roles as $role)

                        <tbody>

                            <tr>

                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->qty_employees }}</td>
                                <td>{{ $role->created_at->format('d/m/Y') }}</td>
                                <td>

                                    <div class="table-options">

                                        <a href="{{ url('employees/role/'.$role->id.'/show') }}" class="btn btn-secondary buttons"><i class="bi bi-list-nested"></i></a>
                                        <a href="{{ url('employees/role/'.$role->id.'/edit') }}" class="btn btn-primary buttons"><i class="bi bi-pencil-square"></i></a>
                                        <a href="{{ url('employees/role/'.$role->id.'/delete') }}" class="btn btn-danger buttons"><i class="bi bi-trash"></i></a>
                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $roles->appends(Request::except('page'))->links() }}

            @else

                <div class="page-message">

                    <h3>Nenhum cargo criado</h3>

                </div>

            @endif

        </div>

    </div>

@endsection
