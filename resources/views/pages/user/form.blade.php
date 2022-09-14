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

                                <div class="form-check  col-md-2 checkbox-user">
                                    <input class="form-check-input checkbox" type="checkbox" value="" id="admin" data-type="manager">
                                    <label class="form-check-label" for="admin">Administrador</label>
                                </div>

                                <div class="form-check  col-md-4 select manager d-none">
                                    <select name="manager_id" class="form-select col-md-6">
                                        <option value="">a</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row">

                                <div class="form-check  col-md-2 checkbox-user">
                                    <input class="form-check-input checkbox" type="checkbox" value="" id="employee" data-type="employee">
                                    <label class="form-check-label" for="employee">Funcionário</label>
                                </div>

                                <div class="form-check col-md-4 select d-none employee">
                                    <select name="employee" class="form-select col-md-6">
                                        <option value="">a</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row">

                                <div class="form-check col-md-2 checkbox-user">
                                    <input class="form-check-input checkbox" type="checkbox" value="" id="customer" data-type="customer">
                                    <label class="form-check-label" for="customer">Cliente</label>
                                </div>

                                <div class="form-check col-md-4 select customer d-none">
                                    <select name="customer" class="form-select col-md-6">
                                        <option value="">a</option>
                                    </select>
                                </div>

                            </div>

                        </div>

                    </div>

                @else


                @endif
                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" name="name" class="form-control" value="{{$user->name}}" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" {{ $isEdit ? "readonly" : "required" }}>
                </div>

                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" class="form-control cpf" value="{{ $user->employee->cpf ?? "" }}" {{ $isEdit ? "readonly" : "required" }}>
                </div>

                @if ($isEdit)
                    <div class="page-controls mb-3">
                        <div class="form-check form-switch">
 2                          <input class="form-check-input switch" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Editar senha</label>
                        </div>

                    </div>

                    <div class="form-group d-none password">
                        <label for="password">Senha</label>
                        <input type="password" name="password" class="form-control" >
                    </div>

                    <div class="form-group d-none password">
                        <label for="password-confirm">Confirmar senha</label>
                        <input type="password" name="password_confirmation" id="password-confirm" class="form-control" >
                    </div>

                @else

                    <div class="form-group password">
                        <label for="password">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group password">
                        <label for="password-confirm">Confirmar senha</label>
                        <input type="password" name="password_confirmation" id="password-confirm" class="form-control" required>
                    </div>

                @endif

                <a href="{{ url('users') }}" class="btn btn-primary">Voltar</a>
                <button type="submit" class="btn btn-success">Enviar</button>

            </form>

        </div>

    </div>

@endsection
