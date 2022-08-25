@extends('layouts.main', [
    'pageTitle' => 'Clientes'
])

@section('content')

    @php
        $isEdit = !empty($customer->id);
    @endphp

    <div class="page page-customer page-form">

        <div class="page-header">
            <h1>Clientes <small>{{ $isEdit ? 'Editar cliente' : 'Novo cliente' }}</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('customer') }}" method="POST">
                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                <input type="hidden" name="id" value="{{ $customer->id }}">

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="name" value="{{ $customer->name }}" maxlength="100" required />
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input class="form-control" type="email" name="email" value="{{ $customer->email }}" required />
                </div>

                <div class="form-group">
                    <label>Endereço</label>
                    <input class="form-control" type="text" name="address" value="{{ $customer->address }}" maxlength="250" required />
                </div>

                <div class="form-group">
                    <label>RG</label>
                    <input class="form-control" type="number" name="rg" value="{{ $customer->rg }}" required />
                </div>

                <div class="form-group">
                    <label>CPF</label>
                    <input class="form-control" type="number" name="cpf" value="{{ $customer->cpf }}" required />
                </div>

                <div class="page-controls">

                    <a href="{{ url('customers') }}" class="btn btn-outline-primary">Voltar</a>

                    <button type="submit" class="btn btn-success">Enviar</button>

                </div>

            </form>

        </div>

    </div>

@endsection
