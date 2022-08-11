@extends('layouts.main')

@section('title', 'Categorias')

@section('content')
<br>

    <div class="container">
        <h1>Categorias</h1>


        @if($errors->any())

        <h4>{{$errors->first()}}</h4>

        @elseif(session()->has('msg'))

        <h4>{{session()->get('msg')}}</h4>

        @endif


        @if (count($categories) > 0)
            <a href="/create/category">Criar categoria</a>
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

        @else

            <h2>Nenhuma categoria cadastrada</h2>

            <p><a href="/create/product">Clique aqui</a> para criar um novo</p>

        @endif
    </div>

@endsection
