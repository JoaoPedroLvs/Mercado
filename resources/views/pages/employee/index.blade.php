@extends('layouts.main', [
    'pageTitle' => 'Funcionários'
])

@section('content')

    <div class="page page-employee page-index">

        <div class="page-header">
            <h1>Funcionários <small>Listagem de funcionários</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls">
                <a href="{{ url('employee/create') }}" class="btn btn-primary">Novo funcionário</a>
            </div>

            @if (count($employees))

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

                    @foreach ($employees as $employee)

                        <tbody>

                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->user->name }}</td>
                                <td>{{ $employee->user->email }}</td>
                                <td>{{ $employee->created_at->format('d/m/Y') }}</td>
                                <td>

                                    <div class="table-options">

                                        <a href="{{ url('employee/'.$employee->id.'/show') }}" class="btn btn-secondary buttons" ><i class="fas fa-list"></i></a><br>
                                        <a href="{{ url('employee/'.$employee->id.'/edit') }}" class="btn btn-primary buttons" ><i class="far fa-edit"></i></a><br>
                                        <a href="{{ url('employee/'.$employee->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $employees->appends(Request::except('page'))->links() }}

            @else

                <div class="page-message">

                    <h3>Nenhum funcionário criado</h3>

                </div>

            @endif

        </div>

    </div>

@endsection
