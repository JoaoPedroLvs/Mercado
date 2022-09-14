@extends('layouts.main', [
    'pageTitle' => 'Usuários'
])

@section('content')

    <div class="page page-users page-index">

        <div class="page-header">
            <h1><a href="/users">Usuários</a> <small>Listagem de usuários</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls mb-3">
                <a href="{{ url('user/create') }}" class="btn btn-primary">Novo usuário</a>
            </div>

            <div class="row g-3">

                <div class="col-md-6">

                    <form action="/users" method="get">

                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                            <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                        </div>

                    </form>

                </div>

                <div class="col-md-6">

                    <form action="/users" method="get">
                        @csrf


                        <div class="input-group">

                            <select name="qtyPaginate" id="qtyPaginate" class="form-select select-qty" data-url="/users">

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

                    <h4>Procurando por: <small>{{ $search }}</small></h4>

                </div>
            @endif

            @if (count($users) > 0)

                <table class="table table-striped">

                    <thead>
                        <tr>

                            <th class="order" data-url="/users" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/users" data-field="email" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Email <span><small><i class="bi bi-caret-down d-none email"></i><i class="bi bi-caret-up d-none email"></i></small></span></th>
                            <th>Permissões</th>
                            <th class="order" data-url="/users" data-field="created_at" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Data de criação <span><small><i class="bi bi-caret-down d-none created_at"></i><i class="bi bi-caret-up d-none created_at"></i></small></span></th>
                            <th>Ações</th>

                        </tr>
                    </thead>

                    @foreach ($users as $user)

                        <tbody>

                            <tr>

                                <td>{{ $user->id }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="row g-3 d-flex justify-content-center">

                                        @if (isset($user->customer_id) > 0)

                                            <div class="col-sm-4">

                                                <span class="badge rounded-pill text-bg-secondary">Cliente</span>



                                            </div>

                                        @endif

                                        @if (isset($user->employee_id) > 0)

                                            <div class="col-sm-4">


                                                <span class="badge rounded-pill text-bg-secondary">Funcionário</span>


                                            </div>

                                        @endif

                                        @if (isset($user->manager_id) > 0)

                                            <div class="col-sm-4">


                                                <span class="badge rounded-pill text-bg-secondary">Gerente</span>

                                            </div>

                                        @endif

                                    </div>
                                </td>
                                <td>{{ $user->created_at ? $user->created_at->format("d/m/Y") : "-"  }}</td>
                                <td>
                                    <div class="page-controls">

                                        <a href="{{ url('/user/'.$user->id.'/edit') }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                        <a href="{{ url('/user/'.$user->id.'/delete') }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>

                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $users->appends(Request::except('page'))->links() }}

            @else

                <div class="page-message">
                    <h4>Nenhum usuário criado</h4>
                </div>

            @endif

        </div>

    </div>

@endsection
