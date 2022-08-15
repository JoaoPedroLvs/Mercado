@extends('layouts.main')

@section('title', 'Produtos da venda')

@section('content')

    <h2>Produtos da venda</h2>


    <a href="/sales">Voltar para vendas</a>
    <table>

        <thead>

            <tr>

                <th>Id</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Preço Total </th>

            </tr>

        </thead>


        @foreach ($sales as $sale)

            <tbody>

                <tr>

                    <td>{{$sale->id}}</td>
                    <td>{{$sale->name}}</td>
                    <td>{{$sale->qty_sales}}</td>
                    <td>{{$sale->total_price}}</td>

                </tr>

            </tbody>

        @endforeach

    </table>

@endsection
