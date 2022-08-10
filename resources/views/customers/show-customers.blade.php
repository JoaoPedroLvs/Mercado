@extends('layouts.main')

@section('title', 'Clientes')

@section('content')

<br>

<div class="container">
    <h1>Clientes</h1>

    <a href="/create/customer">Criar Perfil</a>
    <br><br>
    @if($errors->any())
        <h4>{{$errors->first()}}</h4>
    @elseif(session()->has('msg'))
        <h4>{{session()->get('msg')}}</h4>

    @endif

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>

        @foreach($customers as $customer)
            <tbody>
                <tr>
                    <td>{{$customer->id}}</td>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->email}}</td>
                    <td>
                        <a href="/edit/customer/{{$customer->id}}">Editar</a><br>
                        <a href="/profile/customer/{{$customer->id}}">Ver Perfil</a><br>
                        <a href="/delete/customer/{{$customer->id}}">Deletar</a>
                    </td>
                </tr>
            </tbody>
        @endforeach
    </table>
</div>

@endsection
