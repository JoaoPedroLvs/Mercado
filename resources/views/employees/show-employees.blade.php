@extends('layouts.main')

@section('title', 'Funcionários')

@section('content')

    <br>

    <a href="/create/employee">Criar funcionário</a>

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
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>

        @foreach ($employees as $employee)
            <tbody>
                <tr>
                    <td>{{$employee->id}}</td>
                    <td>{{$employee->name}}</td>
                    <td>{{$employee->phone}}</td>
                    <td>
                        <a href="/edit/employee/{{$employee->id}}">Editar</a>
                        <a href="/profile/employee/{{$employee->id}}">Perfil</a>
                        <a href="/delete/employee/{{$employee->id}}">Excluir</a>
                    </td>
                </tr>
            </tbody>
        @endforeach
    </table>

@endsection
