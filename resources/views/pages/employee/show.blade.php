@extends('layouts.main')

@section('title', 'Funcionários')

@section('content')

    <br>

    <div class="container">
        <h1>Funcionários</h1>


        @if($errors->any())
        <h4>{{$errors->first()}}</h4>
        @elseif(session()->has('msg'))
        <h4>{{session()->get('msg')}}</h4>
        @endif

        @if (count($employees) > 0)

            <a href="/create/employee">Criar funcionário</a>

            <br><br>

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

        @else

            <h2>Nenhum funcionário cadastrado</h2>
            <p><a href="/create/employee">Clique aqui</a> para criar um novo</p>

        @endif

    </div>


@endsection
