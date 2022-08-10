@extends('layouts.main')

@section('title', $isEdit ? 'Editando perfil de '.$customer->name : 'Criando perfil')

@section('content')

<br><br>

    <a href="/customers">Ver Clientes</a>
    <br><br>

    <div class="container">
        <form action="/form/customer" method="POST">
            @csrf

            @method($isEdit ? "PUT" : "POST")

            <label>Nome: </label>
            <input type="text" name="name" required value="{{$customer->name ?? ""}}">
            <br><br>

            <label>Email: </label>
            <input type="email" name="email" required value="{{$customer->email ?? ""}}">
            <br><br>

            <label>Endereço: </label>
            <input type="text" name="address" required value="{{$customer->address ?? ""}}">
            <br><br>

            <label>RG: </label>
            <input type="number" name=rg required value="{{$customer->rg ?? ""}}">
            <br><br>

            <label>CPF: </label>
            <input type="number" name="cpf" required value="{{$customer->cpf ?? ""}}">
            <br><br>

            @if ($isEdit)
                <input type="hidden" name="id" value="{{$customer->id}}">
            @endif
            <button type="submit">Salvar</button>
            <input type="reset" value="Redefinir alterações">

        </form>
    </div>

@endsection
