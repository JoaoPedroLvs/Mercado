@extends('layouts.main')

@section('content')

<div class="page page-auth page-form">

    <div class="page-header">
        <h1>Mercado JP</h1>
    </div>

    <div class="page-body">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8">

                    <div class="card">

                        <div class="card-header d-flex justify-content-center">Criar conta</div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('register') }}">

                                @csrf

                                <div class="row mb-3">

                                    <label for="name" class="col-md-4 col-form-label text-md-end">Nome: </label>

                                    <div class="col-md-6">

                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                    </div>

                                </div>

                                <div class="row mb-3">

                                    <label for="email" class="col-md-4 col-form-label text-md-end">E-mail: </label>

                                    <div class="col-md-6">

                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                    </div>

                                </div>
                                <div class="row mb-3">

                                <label for="cpf" class="col-md-4 col-form-label text-md-end">CPF: </label>

                                    <div class="col-md-6">

                                        <input type="text" name="cpf" id="cpf" class="cpf form-control @error('cpf') is-invalid @enderror" required autocomplete="new-cpf" value="{{ old('cpf') }}">

                                        @error('cpf')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                    </div>

                                </div>

                                <div class="row mb-3">

                                    <label for="password" class="col-md-4 col-form-label text-md-end">Senha: </label>

                                    <div class="col-md-6">

                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                    </div>

                                </div>

                                <div class="row mb-3">

                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar senha:</label>

                                    <div class="col-md-6">

                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                    </div>

                                </div>

                                <div class="row mb-0">

                                    <div class="col-md-6 offset-md-4">

                                        <button type="submit" class="btn btn-primary">Registrar</button>

                                        <a href="/login" class="btn btn-outline-primary">Voltar</a>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@endsection
