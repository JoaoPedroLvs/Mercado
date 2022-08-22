@extends('layouts.main', [
    'pageTitle' => 'Funcionários'
])

@section('content')

    <div class="page page-employee page-index">

        <div class="page-header">
            <h1>Funcionários <small>Listagem de Funcionários</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            @if (count($employees))

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($employees as $employee)

                        <tbody>

                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>
                                    <a href="{{ url('employee/'.$employee->id.'/show') }}">Visualizar</a><br>
                                    <a href="{{ url('employee/'.$employee->id.'/edit') }}">Editar</a><br>
                                    <a href="{{ url('employee/'.$employee->id.'/delete') }}">Remover</a>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

            @else

                <div class="page-message">

                    <h3>Nenhum funcionário criado</h3>

                </div>

            @endif

            <div class="page-controls">
                <a href="{{ url('employee/create') }}" class="btn btn-primary">Novo funcionário</a>
            </div>

        </div>

    </div>

@endsection
