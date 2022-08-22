@extends('layouts.main', [
    'pageTitle' => 'Funcionários'
])

@section('content')

    @php
        $isEdit = !empty($employee->id);
    @endphp

    <div class="page page-employee page-form">

        <div class="page-header">
            <h1>Funcionários <small>{{ $isEdit ? 'Editar funcionário' : 'Novo funcionário' }}</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('employee') }}" method="POST">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                <input type="hidden" name="id" value="{{ $employee->id }}">

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required/>
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" name="email" class="form-control" value="{{ $employee->email }}" required/>
                </div>

                <div class="form-group">
                    <label>Endereço</label>
                    <input type="text" name="address" class="form-control" value="{{ $employee->address }}" required/>
                </div>

                <div class="form-group">
                    <label>Telefone</label>
                    <input type="number" name="phone" class="form-control" value="{{ $employee->phone }}" required/>
                </div>

                <div class="form-group">
                    <label>CPF</label>
                    <input type="number" name="cpf" class="form-control" value="{{ $employee->cpf }}" required/>
                </div>

                <div class="form-group">
                    <label>RG</label>
                    <input type="number" name="rg" class="form-control" value="{{ $employee->rg }}" required/>
                </div>

                <div class="form-group">
                    <label>Carteira de trabalho</label>
                    <input type="number" name="work_code" class="form-control" value="{{ $employee->work_code }}" required/>
                </div>

                <div class="page-controls">

                    <a href="{{ url('employees') }}" class="btn btn-outline-primary">Voltar</a>

                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>

            </form>

        </div>

    </div>

@endsection
