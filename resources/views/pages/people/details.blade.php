@extends('layouts.main', [
    'pageTitle' => 'Pessoa'
])

@section('content')

    <div class="page page-people page-details">

        <div class="page-header">
            <h1>Pessoas <small>Detalhes de {{ $person->name }}</small></h1>
        </div>

        <div class="page-body">

            <ul>
                <li><b>Nome: </b>{{ $person->name }}</li>
                <li><b>Telefone: </b>{{ $person->phone }}</li>
                <li><b>Gênero: </b>{{ $person->gender == 'm' ? 'Masculino' : $person->gender == 'f' ? 'Feminino' : 'LGBTQIA+PLUS' }}</li>
                <li><b>CPF: </b>{{ $person->cpf }}</li>
                <li><b>RG: </b>{{ $person->rg }}</li>
                <li><b>Endereço: </b>{{ $person->address }}</li>

            </ul>

            <div class="page-controls">

                <a href="{{ url('people') }}" class="btn btn-outline-primary">Voltar</a>
                <a href="{{ url('person/'.$person->id.'/edit') }}" class="btn btn-primary">Editar</a>

            </div>
        </div>

    </div>

@endsection
