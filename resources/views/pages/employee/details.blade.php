@extends('layouts.main', [
    'pageTitle' => 'Funcionários'
])

@section('content')
    <div class="page page-employee page-details">

        <div class="page-header">
            <h1>Funcionários <small>Detalhes do Funcionário {{$employee->name}}</small></h1>
        </div>

        <div class="page-body">

            <ul>
                <li><b>Nome: </b>{{ $employee->name }}</li>
                <li><b>Gênero: </b>{{ $employee->gender == 'm' ? 'Masculino' : ($employee->gender == 'f' ? 'Feminino' : ($employee->gender == 'L' ? 'LGBTQIA+PLUS' : '-')) }}</li>
                <li><b>Endereço: </b>{{ $employee->address }}</li>
                <li><b>Telefone: </b>{{ $employee->phone }}</li>
                <li><b>RG: </b>{{ $employee->rg }}</li>
                <li><b>CPF: </b>{{ $employee->cpf }}</li>
                <li><b>Carteira de trabalho: </b>{{ $employee->work_code }}</li>
            </ul>

            <div class="page-controls">

                @if (Session::get('employee'))

                    <a href="{{ url('/') }}" class="btn btn-outline-primary">Voltar</a>
                    <a class="btn btn-primary" href="{{ url('/employee/'. $employee->id .'/edit') }}">Editar</a>

                @else

                    <a class="btn btn-outline-primary" href="{{ url('employees') }}">Voltar</a>
                    <a class="btn btn-primary" href="{{ url('/employee/'. $employee->id .'/edit') }}">Editar</a>

                @endif

            </div>

        </div>

    </div>

@endsection
