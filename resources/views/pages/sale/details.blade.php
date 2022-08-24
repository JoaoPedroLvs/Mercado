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

            <table class="table table-striped">

                <thead>

                    <tr>

                        <th>Id</th>
                        <th>Cliente</th>
                        <th>Funcionário</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor do volume</th>

                    </tr>

                </thead>


                @foreach ($sales as $sale)

                    <tbody>

                        <tr>

                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->client }}</td>
                            <td>{{ $sale->employee }}</td>
                            <td>{{ $sale->product }}</td>
                            <td>{{ $sale->qty_sales }}</td>
                            <td>R$ {{ number_format($sale->total_price, 2, ',', ' ') }}</td>

                        </tr>

                    </tbody>

                @endforeach

            </table>

            <div class="page-controls">
                <a href="{{ url('sales') }}">Voltar</a>
            </div>

        </div>

    </div>

@endsection
