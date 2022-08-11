@extends('layouts.main')

@section('title', $isEdit ? 'Editando perfil de '.$employee->name : 'Criando funcionário')

@section('content')
<br>
    <a href="/employees">Voltar para funcionários</a>
    <br><br>

    <div class="container">
        <form action="/form/employee" method="POST">
            @csrf

            @method($isEdit ? "PUT" : "POST")

            <label>Nome: </label>
            <input type="text" name="name" required value="{{$employee->name ?? ""}}"><br><br>

            <label>Email: </label>
            <input type="email" name="email" required value="{{$employee->email ?? ""}}"><br><br>

            <label>Telefone: </label>
            <input type="number" name="phone" required value="{{$employee->phone ?? ""}}"><br><br>

            <label>CPF: </label>
            <input type="number" name="cpf" required value="{{$employee->cpf ?? ""}}"><br><br>

            <label>RG: </label>
            <input type="number" name="rg" required value="{{$employee->rg ?? ""}}"><br><br>

            <label>Carteira de trabalho</label>
            <input type="number" name="work_code" required value="{{$employee->work_code}}"><br><br>

            @if ($isEdit)
                <input type="hidden" name="id" value="{{$employee->id}}">
            @endif

            <button type="submit">Enviar</button>
            <input type="reset" value="Redefinir alterações">
        </form>
    </div>

@endsection
