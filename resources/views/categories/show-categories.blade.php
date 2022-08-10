@extends('layouts.main')

@section('title', 'Categorias')

@section('content')
<br>

    <div class="container">
        <h1>Categorias</h1>

        <a href="/create/category">Criar categoria</a>

    @if($errors->any())

        <h4>{{$errors->first()}}</h4>

    @elseif(session()->has('msg'))

        <h4>{{session()->get('msg')}}</h4>

    @endif
<br><br>
    <table>

        <thead>

            <tr>

                <th>Id</th>
                <th>Nome</th>
                <th>Ações</th>

            </tr>

        </thead>

        @foreach ($categories as $category)
            <tbody>

                <tr>

                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td>
                        <a href="/edit/category/{{$category->id}}">Editar</a>
                        <a href="/category/{{$category->id}}/products">Produtos</a>
                        <a href="/delete/category/{{$category->id}}">Deletar</a>

                    </td>

                </tr>

            </tbody>
        @endforeach
    </table>
    </div>

@endsection
