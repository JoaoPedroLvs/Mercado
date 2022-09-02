@extends('layouts.main', [
    'pageTitle' => 'Vendas'
])

@section('content')

    <div class="page page-sales page-details">

        <div class="page-header">
            <h1>Vendas <small>Produtos da venda</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-list">

                <ul>
                    {{-- @dd($sales) --}}

                    <li><b>Cliente: </b>{{ $sales[0]->client }}</li>

                    <li><b>Funcionário: </b>{{ $sales[0]->employee ?? "Administrador" }}</li>

                </ul>

            </div>

            <table class="table table-striped">

                <thead>

                    <tr>

                        <th>Id</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Valor sem promoções</th>

                    </tr>

                </thead>

                @foreach ($sales as $k => $sale)

                    <tbody>

                        <tr>

                            <td>{{ $k+1 }}</td>
                            <td>{{ $sale->product }}</td>
                            <td>{{ $sale->qty_sales }}</td>
                            <td>R$ {{ number_format($sale->total_price, 2, ',', ' ') }}</td>
                            @php

                                if (!$sale->total_no_promotion == 0) {
                                    $price = "R$ ".number_format($sale->qty_sales * $sale->price, 2, ',', ' ');
                                } else {
                                    $price = "-";
                                }

                            @endphp
                            <td>{{ $price }}</td>

                        </tr>

                    </tbody>

                @endforeach

            </table>

            <div class="page-controls">
                <a class="btn btn-outline-primary" href="{{ url('sales') }}">Voltar</a>
            </div>

        </div>

    </div>

@endsection
