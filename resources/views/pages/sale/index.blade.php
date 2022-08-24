@extends('layouts.main', [
    'pageTitle' => 'Vendas'
])

@section('content')

    <div class="page page-sale page-index">

        <div class="page-header">
            <h1>Vendas <small>Listagem de vendas</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            @if (count($sales) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Valor</th>
                            <th>Quantidade de produtos</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($sales as $sale)

                        <tbody>

                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>R$ {{ number_format($sale->total, 2, ',', ' ') }}</td>
                                <td>{{ count($sale->products) }}</td>
                                <td>
                                    <a href="{{ url('/sale/'.$sale->id.'/products') }}">Detalhes</a><br>
                                    <a href="{{ url('/sale/'.$sale->id.'/delete') }}">Remover</a>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

            @else

                <div class="page-message">
                    <h3>Nenhuma venda criada</h3>
                </div>

            @endif

            <div class="page-controls">
                <a href="{{ url('sale/create') }}" class="btn btn-primary">Criar venda</a>
            </div>

        </div>

    </div>

@endsection
