@extends('layouts.main')

@section('title', 'Produtos')

@section('content')

    <br>


    <div class="container">
        <h1>Produtos</h1>

        @if (session()->has('msg'))

            <h4>{{session()->get('msg')}}</h4>

        @endif</a></td>

        @if (count($products) > 0)

            <a href="/create/product">Criar produto</a>

            <br><br>

            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                @foreach ($products as $k => $product)
                    <tbody>

                        {{-- @dd($product->category()->get()) --}}

                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td><a href="/category/{{$product->category->id}}/products">{{ $product->category->name }}</td>
                            <td>{{ $product->current_qty }}</td>
                            <td>
                                <a href="/edit/product/{{ $product->id }}">Editar</a>
                                <a href="/delete/product/{{ $product->id }}">Deletar</a>
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        @else
            <h2>Nenhum produto cadastrado</h2>
            <p><a href="/create/product">Clique aqui</a> para criar um novo</p>

        @endif


    </div>

@endsection
