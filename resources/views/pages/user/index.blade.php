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
                <a href="{{ url('user/create') }}" class="btn btn-primary">Criar novo usuário</a>
            </div>

            <form action="/users" method="get">

                @csrf

                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                    <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                </div>

            </form>

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
                            <th class="order" data-url="/users" data-field="created_at" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Data de criação <span><small><i class="bi bi-caret-down d-none created_at"></i><i class="bi bi-caret-up d-none created_at"></i></small></span></th>
                            <th>Ações</th>

                        </tr>
                    </thead>

                    @foreach ($users as $user)

                        <tbody>

                            <tr>

                                <td>{{ $user->id }}</td>
                                <td>{{ $user->email }}</td>
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
