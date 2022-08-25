@extends('layouts.main', [
    'pageTitle' => 'Funcionários'
])

@section('content')
    <div class="page page-employee page-details">

        <div class="page-header">
            <h1>Funcionários <small>Detalhes do Funcionário</small></h1>
        </div>

        <div class="page-body">

            <ul>
                <li><b>Nome: </b>{{ $employee->name }}</li>
                <li><b>E-mail: </b>{{ $employee->email }}</li>
                <li><b>Endereço: </b>{{ $employee->address }}</li>
                <li><b>Telefone: </b>{{ $employee->phone }}</li>
                <li><b>RG: </b>{{ $employee->rg }}</li>
                <li><b>CPFl: </b>{{ $employee->cpf }}</li>
                <li><b>Carteira de trabalho: </b>{{ $employee->work_code }}</li>
            </ul>

            <div class="page-controls">
                <a class="btn btn-outline-primary" href="{{ url('employees') }}">Voltar</a>
            </div>

        </div>

    </div>

@endsection
