@extends('layouts.main')

@section('title', 'Perfil de '. $employee->name)

@section('content')

    <h1>Perfil de {{$employee->name}}</h1>

    <h4>E-mail: </h4>{{$employee->email}}

    <h4>Endereço: </h4>{{$employee->address}}

    <h4>Telefone: </h4>{{$employee->phone}}

    <h4>CPF: </h4>{{$employee->cpf}}

    <h4>RG: </h4>{{$employee->rg}}

    <h4>Carteira de trabalho: </h4>{{$employee->work_code}}

@endsection
