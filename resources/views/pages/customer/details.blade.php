@extends('layouts.main', [
    'pageTitle' => 'Clientes'
])

@section('content')

    <div class="page page-customer page-details">
        <h1>Clientes <small>Detalhes do cliente</small></h1>

        <div class="page-body">

            <ul>
                <li><b>Nome: </b>{{ $customer->user->name }}</li>
                <li><b>E-mail: </b>{{ $customer->user->email }}</li>
                <li><b>Endereço: </b>{{ $customer->address }}</li>
                <li><b>CPF: </b>{{ $customer->cpf }}</li>
                <li><b>RG: </b>{{ $customer->rg }}</li>
            </ul>

            <div class="page-controls">
                @if (Auth::user()->role != 2)

                    <a class="btn btn-outline-primary" href="{{ url('customers') }}">Voltar</a>

                @else

                    <a class="btn btn-outline-primary" href="{{ url('/') }}">Voltar</a>
                    <a href="{{ url('/customer/'. Auth::user()->customer->id .'/edit') }}" class="btn btn-primary">Editar</a>

                @endif
            </div>

        </div>
    </div>

@endsection
