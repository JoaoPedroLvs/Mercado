@extends('layouts.main')

@section('content')

<div class="page page-auth page-index">

    <div class="page-header">

        <h1>Mercado JP</h1>

    </div>

    <div class="page-body">

        @include('components.alert')

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8">

                    <div class="card">

                        <div class="card-header d-flex justify-content-center">Login</div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('login') }}">

                                @csrf

                                <div class="row mb-3">

                                    <label for="email" class="col-md-4 col-form-label text-md-end">E-mail:</label>

                                    <div class="col-md-6">

                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    </div>

                                </div>

                                <div class="row mb-3">

                                    <label for="password" class="col-md-4 col-form-label text-md-end">Senha:</label>

                                    <div class="col-md-6">

                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    </div>

                                </div>

                                <div class="row mb-0">

                                    <div class="col-md-8 offset-md-4">

                                        <button type="submit" class="btn btn-primary">Entrar</button>

                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Criar conta</a>

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
