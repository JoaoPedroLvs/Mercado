@extends('layouts.main', [
    'pageTitle' => 'Clientes'
])

@section('content')

    @php
        $isEdit = !empty($customer->id);
        $user = $customer->user ?? $customer;
    @endphp

    <div class="page page-customer page-form">

        <div class="page-header">
            <h1>Clientes <small>{{ $customer->is_new ? 'Conclua seu cadastro' : ($isEdit ? 'Editar cliente' : 'Novo cliente') }}</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('customer') }}" method="POST" enctype="multipart/form-data">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                <input type="hidden" name="id" value="{{ $customer->id }}">

                <div class="page-controls">
                    <label for="image" class="btn btn-primary image">Selecione uma imagem</label>
                    <input type="file" class="d-none input-image" name="image" id="image" accept="image/*"><span class="file-input">Nenhum arquivo selecionado</span>
                </div>

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}" maxlength="100" required />
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email',$user->email) }}" required />
                </div>

                <div class="form-group">
                    <label>Endereço</label>
                    <input class="form-control" type="text" name="address" value="{{ old('address',$customer->address) }}" maxlength="250" required />
                </div>

                <div class="form-group">
                    <label>RG</label>
                    <input class="form-control" type="text" name="rg" value="{{ old('rg',$customer->rg) }}" required />
                </div>

                <div class="form-group">
                    <label>CPF</label>
                    <input class="form-control cpf" type="text" name="cpf" value="{{ old('cpf',$customer->cpf) }}" required />
                </div>

                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="text" name="phone" id="phone" class="form-control phone" value="{{ old('phone', $customer->phone) }}">
                </div>

                @if (Auth::user()->role == 2)

                    @if (Auth::user()->customer->is_new == false)

                        @if($isEdit)

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

                            <div class="page-controls">
                                <div class="form-check form-switch">
                                    <input class="form-check-input switch" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Editar senha</label>
                                </div>

                            </div>

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

                    @if (Auth::user()->role != 2)

                        <a href="{{ url('customers') }}" class="btn btn-outline-primary">Voltar</a>

                    @else

                    <a href="{{ url('/') }}" class="btn btn-outline-primary">Voltar</a>

                    @endif

                    <button type="submit" class="btn btn-success">Enviar</button>

                </div>

            </form>

        </div>

    </div>

@endsection
