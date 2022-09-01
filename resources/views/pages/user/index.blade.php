@extends('layouts.main', [
    'pageTitle' => 'Usuários'
])

@section('content')

    <div class="page page-users page-index">

        <div class="page-header">
            <h1>Usuários <small>Listagem de usuários</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls">
                <a href="{{ url('user/create') }}" class="btn btn-primary">Criar novo usuário</a>
            </div>

            @if (count($users) > 0)

                <table class="table table-striped">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Ações</th>

                        </tr>
                    </thead>

                    @foreach ($users as $user)

                        <tbody>

                            <tr>

                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="table-options">

                                        <a href="{{ url('/employee/'.$user->employee->id.'/show') }}" class="btn btn-secondary"><i class="fas fa-list"></i></a>
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
