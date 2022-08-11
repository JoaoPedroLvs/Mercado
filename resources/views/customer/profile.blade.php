@extends('layouts.main')

@section('title', 'Vendo perfil de '. $customer->name)

@section('content')

    <h1>Perfil de {{$customer->name}}</h1>

    <h4>E-mail: </h4>{{$customer->email}}

    <h4>Endereço: </h4>{{$customer->address}}

    <h4>CPF: </h4>{{$customer->cpf}}

    <h4>RG: </h4>{{$customer->rg}}

@endsection
