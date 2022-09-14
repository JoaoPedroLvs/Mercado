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
                <li><b>Nome: </b>{{ $manager->name }}</li>
                <li><b>Gênero: </b>{{ $manager->gender == 'm' ? 'Masculino' : ($manager->gender == 'f' ? 'Feminino' : ($manager->gender == 'L' ? 'LGBTQIA+PLUS' : '-')) }}</li>
                <li><b>CPF: </b>{{ $manager->cpf ?? '-' }}</li>
                <li><b>RG: </b>{{ $manager->rg ?? '-' }}</li>
                <li><b>Endereço: </b>{{ $manager->address ?? '-' }}</li>
            </ul>

            <div class="page-controls">

                <a href="{{ url('admins') }}" class="btn btn-outline-primary">Voltar</a>

            </div>

        </div>

    </div>


@endsection
