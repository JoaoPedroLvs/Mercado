@extends('layouts.main',[
    'pageTitle' => 'Administração'
])

@section('content')

    <div class="page page-admin page-details">

        <div class="page-header">
            <h1>Adminstração <small>Detalhes do administrador</small></h1>
        </div>

        <div class="page-body">
            @include('components.alert')

            <ul>
                <li><b>Nome:</b> {{ $user->name }}</li>
                <li><b>E-mail:</b> {{ $user->email}} </li>
            </ul>

            <div class="page-controls">

                <a href="{{ url('admins') }}" class="btn btn-outline-primary">Voltar</a>

            </div>

        </div>

    </div>


@endsection
