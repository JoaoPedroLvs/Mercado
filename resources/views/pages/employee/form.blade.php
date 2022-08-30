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
                    <input type="text" name="name" class="form-control" value="{{ old('name',$employee->user->name) }}" required/>
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email', $employee->user->email) }}" required/>
                </div>

                <div class="form-group">
                    <label>Endereço</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $employee->address) }}" required/>
                </div>

                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="phone" class="form-control phone" value="{{ old('phone', $employee->phone) }}" required/>
                </div>

                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" name="cpf" class="form-control cpf" value="{{ old('cpf', $employee->cpf) }}" required/>
                </div>

                <div class="form-group">
                    <label>RG</label>
                    <input type="number" name="rg" class="form-control" value="{{ old('rg', $employee->rg) }}" required/>
                </div>

                <div class="form-group">
                    <label>Carteira de trabalho</label>
                    <input type="text" name="work_code" class="form-control work-code" value="{{ old('work_code', $employee->work_code) }}" required/>
                </div>

                <div class="page-controls">

                    @if (Auth::user()->role==0)

                        <a href="{{ url('employee/'. $employee->id. '/show') }}" class="btn btn-outline-primary">Voltar</a>

                    @else

                        <a class="btn btn-outline-primary" href="{{ url('employees') }}">Voltar</a>

                    @endif

                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>

            </form>

        </div>

    </div>

@endsection
