@extends('layouts.main', [
    'pageTitle' => 'Clientes'
])

@section('content')

    <div class="page page-customer page-details">
        <h1>Clientes <small>Detalhes do cliente</small></h1>

        <div class="page-body">

            <ul>
                <a data-fancybox data-src="{{ asset($customer->image) }}" data-caption="{{ $customer->name }}">

                    <img src="{{ asset($customer->user->image) }}" alt="Foto de perfil" height="100px" width="100px">

                </a>
                <li><b>Nome: </b>{{ $customer->name }}</li>
                <li><b>E-mail: </b>{{ $customer->email }}</li>
                <li><b>Endereço: </b>{{ $customer->address }}</li>
                <li><b>CPF: </b>{{ $customer->cpf }}</li>
                <li><b>RG: </b>{{ $customer->rg }}</li>
            </ul>

            <div class="page-controls">
                @if (!Session::get('customer'))

                    <a class="btn btn-outline-primary" href="{{ url('customers') }}">Voltar</a>

                @else

                    <a class="btn btn-outline-primary" href="{{ url('/') }}">Voltar</a>
                    <a href="{{ url('/customer/'. Auth::user()->customer->id .'/edit') }}" class="btn btn-primary">Editar</a>

                @endif
            </div>

        </div>
    </div>

@endsection
