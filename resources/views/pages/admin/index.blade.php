@extends('layouts.main', [
    'pageTitle' => 'Admistração'
])

@section('content')

    <page class="page page-admin page-index">

        <div class="page-header">

            <h1><a href="/admins">Administração</a> <small>Listagem de administradores</small></h1>

        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls mb-3">

                <a href="/admin/create" class="btn btn-primary">Novo administrador</a>

            </div>

            <div class="row g-3">

                <div class="col-md-6">

                    <form action="/admins" method="get">

                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                            <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                        </div>

                    </form>

                </div>

                <div class="col-md-6">

                    <form action="/admins" method="get">
                        @csrf


                        <div class="input-group">

                            <select name="qtyPaginate" id="qtyPaginate" class="form-select select-qty" data-url="/admins">

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

                <div class="page-message">
                    <h4>Procurando por: <small>{{ $search}}</small></h4>
                </div>

            @endif
            @if (count($managers) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>

                            <th class="order" data-url="/admins" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/admins" data-field="name" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Nome <span><small><i class="bi bi-caret-down d-none name"></i><i class="bi bi-caret-up d-none name"></i></small></span></th>
                            <th>CPF</th>
                            <th class="order" data-url="/admins" data-field="created_at" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Data de criação <span><small><i class="bi bi-caret-down d-none created_at"></i><i class="bi bi-caret-up d-none created_at"></i></small></span></th>
                            <th>Ações</th>

                        </tr>

                    </thead>

                    @foreach ($managers as $manager)

                        <tbody>

                            <tr>

                                <td>{{ $manager->id }}</td>
                                <td>{{ $manager->name }}</td>
                                <td>{{ $manager->cpf ?? '-' }}</td>
                                <td>{{ $manager->created_at ? $manager->created_at->format("d/m/Y") : "-" }}</td>
                                <td>
                                    <div class="page-controls">

                                        <a href="{{ url('admin/'.$manager->id.'/show') }}" class="btn btn-secondary"><i class="fas fa-list"></i></a>
                                        <a href="{{ url('admin/'.$manager->id.'/edit') }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                        <a href="{{ url('admin/'.$manager->id.'/delete') }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>

                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $managers->appends(Request::except('page'))->links() }}
            @else

                <div class="page-message">

                    <h3>Nenhum administrador criado</h3>

                </div>

            @endif

        </div>

    </page>
@endsection
