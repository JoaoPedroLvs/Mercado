@extends('layouts.main')

@section('title', 'Clientes')

@section('content')

<br>

<div class="container">

    <h1>Clientes</h1>



    @if($errors->any())

    <h4>{{$errors->first()}}</h4>

    @elseif(session()->has('msg'))

    <h4>{{session()->get('msg')}}</h4>

    @endif

    @if (count($customers) > 0)

        <a href="/create/customer">Criar Perfil</a>
        <br><br>

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

    @else

        <h2>Não possui nenhum cliente cadastrado</h2>
        <p><a href="/create/customer">Clique aqui</a> para criar um novo</p>

    @endif

</div>

@endsection
