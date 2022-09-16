@extends('layouts.main', [
    'pageTitle' => 'Clientes'
])

@section('content')

    <div class="page page-customer page-details">

        <div class="page-header">

            <h1>Clientes <small>Detalhes do cliente</small></h1>

        </div>

        <div class="page-body">

            <ul>
                <li><b>Nome: </b>{{ $customer->name }}</li>
                <li><b>Gênero: </b>{{ $customer->gender == 'm' ? 'Masculino' : ($customer->gender == 'f' ? 'Feminino' : ($customer->gender == 'L' ? 'LGBTQIA+PLUS' : '-')) }}</li>
                <li><b>CPF: </b>{{ $customer->cpf ?? '-' }}</li>
                <li><b>RG: </b>{{ $customer->rg ?? '-' }}</li>
                <li><b>Endereço: </b>{{ $customer->address ?? '-' }}</li>
            </ul>

            <div class="page-controls">
                @if (!Session::get('customer'))

                    <a class="btn btn-outline-primary" href="{{ url('customers') }}">Voltar</a>

                @else

                    <a class="btn btn-outline-primary" href="{{ url('/') }}">Voltar</a>
                    <a href="{{ url('/person/'. Auth::user()->customer->person_id .'/edit') }}" class="btn btn-primary">Editar</a>

                @endif
            </div>

        </div>
    </div>

@endsection
