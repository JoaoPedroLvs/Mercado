@extends('layouts.main', [
    'pageTitle' => 'Usuários'
])

@section('content')

    @php
        $isEdit = !empty($user->id);
    @endphp

    <div class="page page-users page-form">

        <div class="page-header">
            <h1>Usuário <small>{{ $isEdit ? 'Editando ' : 'Criando ' }}um usuário</small></h1>
        </div>

        <div class="page-body">
            @include('components.alert')

            <form action="{{ url('user') }}" method="POST">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                @if (!$isEdit)

                    <div class="form-group">

                        <label>Permissões:</label>

                        <div class="selects-form">

                            <div class="row">

                                <div class="form-check col-md-2 checkbox-user">
                                    <input class="form-check-input checkbox" type="checkbox" id="admin" data-type="manager" name="checkboxManager">
                                    <label class="form-check-label" for="admin">Administrador</label>
                                </div>

                                <div class="form-check col-md-6 select manager d-none">

                                    <select name="manager_id" class="form-control col-md-6">

                                        <option value="">Selecione um administrador</option>

                                        @foreach ($managers as $manager)

                                            <option value="{{ $manager->id }}">{{ $manager->person->name }}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div class="row">

                                <div class="form-check col-md-2 checkbox-user">
                                    <input class="form-check-input checkbox" type="checkbox" id="employee" data-type="employee" name="checkboxEmployee">
                                    <label class="form-check-label" for="employee">Funcionário</label>
                                </div>

                                <div class="form-check col-md-6 select d-none employee">
                                    <select name="employee_id" class="form-control col-md-6">

                                        <option value="">Selecione um funcionário</option>

                                        @foreach ($employees as $employee)

                                            <option value="{{ $employee->id }}">{{ $employee->person->name }}</option>

                                        @endforeach

                                    </select>
                                </div>

                            </div>

                            <div class="row">

                                <div class="form-check col-md-2 checkbox-user">
                                    <input class="form-check-input checkbox" type="checkbox" id="customer" data-type="customer" name="checkboxCustomer">
                                    <label class="form-check-label" for="customer">Cliente</label>
                                </div>

                                <div class="form-check col-md-6 select customer d-none">
                                    <select name="customer_id" class="form-control col-md-6">
                                        <option value="">Selecione um cliente</option>

                                        @foreach ($customers as $customer)

                                            <option value="{{ $customer->id }}">{{ $customer->person->name }}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" {{ $isEdit ? "readonly" : "required" }}>
                    </div>


                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="form-group password">
                                <label for="password">Senha</label>
                                <input type="password" name="password" class="form-control" >
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group password">
                                <label for="password-confirm">Confirmar senha</label>
                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" >
                            </div>

                        </div>

                    </div>

                @else

                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" {{ $isEdit ? "readonly" : "required" }}>
                    </div>

                    <div class="page-controls mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input switch" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Editar senha</label>
                        </div>

                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="form-group d-none password">
                                <label for="password">Senha</label>
                                <input type="password" name="password" class="form-control" >
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group d-none password">
                                <label for="password-confirm">Confirmar senha</label>
                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" >
                            </div>

                        </div>

                    </div>


                @endif

                <a href="{{ url('users') }}" class="btn btn-outline-primary">Voltar</a>
                <button type="submit" class="btn btn-success">Enviar</button>

            </form>

        </div>

    </div>

@endsection
