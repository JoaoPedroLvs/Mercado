@extends('layouts.main')

@section('title', 'Produtos da categoria '. $category->name)

@section('content')


<br><br>

    <div class="container">

        @if (count($products) > 0)

            <a href="/categories">Ver categorias</a>
            <br><br>

            <table>

                <thead>

                    <tr>

                        <th>Id</th>

                        <th>Nome</th>

                        <th>Quantidaede</th>

                    </tr>

                </thead>

                @foreach ($products as $product)

                    <tbody>

                        <tr>

                            <td>{{$product->id}}</td>

                            <td>{{$product->name}}</td>

                            <td>{{$product->current_qty}}</td>


                        </tr>
                    </tbody>

                @endforeach

            </table>

        @else

            <h2>Esta categoria não possui nenhum produto</h2>

        @endif

    </div>

@endsection
