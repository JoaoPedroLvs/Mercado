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

                @php
                    $user = $employee->user ?? $employee;
                @endphp

                <input type="hidden" name="id" value="{{ $employee->id }}">

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required autofocus/>
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}" required/>
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

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Carteira de trabalho</label>
                            <input type="text" name="work_code" class="form-control work-code" value="{{ old('work_code', $employee->work_code) }}" required/>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="role">Cargo</label>

                            <select class="form-select" name="role_id">

                                <option value="" selected>Selecione um cargo</option>

                                @foreach ($roles as $role)

                                    <option value="{{ $role->id }} {{ $employee->role_id == $role->id ? 'selected' : '' }}">{{ $role->name }}</option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>

                @if (Auth::user()->role == 0)

                    @if($isEdit)

                        <div class="page-controls">
                            <div class="form-check form-switch">
                                <input class="form-check-input switch" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Editar senha</label>
                            </div>

                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <div class="form-group d-none password">

                                    <label for="password">Senha</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" >

                                        @error('password')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group d-none password">

                                    <label for="password-confirm">Confirmar senha</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >

                                </div>

                            </div>

                        </div>

                    @else
                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="password">Senha</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" >

                                    @error('password')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="password-confirm">Confirmar senha</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >

                            </div>

                        </div>

                    </div>

                    @endif


                @else

                    @if ($isEdit)

                        <div class="page-controls">
                            <div class="form-check form-switch">
                                <input class="form-check-input switch" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Editar senha</label>
                            </div>

                        </div>

                        <div class="form-group d-none password">

                            <label for="password">Senha</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" >

                                @error('password')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror
                        </div>

                        <div class="form-group d-none password">

                            <label for="password-confirm">Confirmar senha</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >

                        </div>

                    @else

                        <div class="form-group">

                            <label for="password">Senha</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror
                        </div>

                        <div class="form-group">

                            <label for="password-confirm">Confirmar senha</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                        </div>

                    @endif

                @endif

                <div class="page-controls">

                    @if (Session::get('employee'))

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
