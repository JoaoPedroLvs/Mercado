@extends('layouts.main', [
    'pageTitle' => 'Admistração'
])

@section('content')

    <page class="page page-admin page-index">

        <div class="page-header">

            <h1>Administração <small>Listagem de administradores</small></h1>

        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls">

                <a href="/admin/create" class="btn btn-primary">Criar novo administrador</a>

            </div>

            @if (count($users) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data de criação</th>
                            <th>Ações</th>

                        </tr>

                    </thead>

                    @foreach ($users as $user)

                        <tbody>

                            <tr>

                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at ? $user->created_at->format("d/m/Y") : "-" }}</td>
                                <td>
                                    <div class="page-controls">

                                        <a href="{{ url('admin/'.$user->id.'/show') }}" class="btn btn-secondary"><i class="fas fa-list"></i></a>
                                        <a href="{{ url('admin/'.$user->id.'/edit') }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                        <a href="{{ url('admin/'.$user->id.'/delete') }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>

                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $users->appends(Request::except('page'))->links() }}
            @else

                <div class="page-message">

                    <h3>Nenhum administrador criado</h3>

                </div>

            @endif

        </div>

    </page>
@endsection
