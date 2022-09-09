@extends('layouts.main', [
    'pageTitle' => 'Vendas'
])

@section('content')

    <div class="page page-sale page-index">

        <div class="page-header">
            <h1><a href="/sales">Vendas</a> <small>Listagem de vendas</small></h1>
            <h3>Valor total de vendas: <small>R$ {{ number_format($total,2,',','.') }}</small></h3>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls mb-3">
                <a href="{{ url('sale/create') }}" class="btn btn-primary">Nova venda</a>
            </div>

            @if (count($sales) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th class="order" data-url="/sales" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/sales" data-field="total" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Valor <span><small><i class="bi bi-caret-down d-none total"></i><i class="bi bi-caret-up d-none total"></i></small></span></th>
                            <th>Quantidade de produtos</th>
                            <th class="order" data-url="/sales" data-field="created_at" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Data da venda <span><small><i class="bi bi-caret-down d-none created_at"></i><i class="bi bi-caret-up d-none created_at"></i></small></span></th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($sales as $sale)

                        <tbody>

                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>R$ {{ number_format($sale->total, 2, ',', ' ') }}</td>
                                <td>{{ count($sale->products) }}</td>
                                <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                                <td>

                                    <div class="table-options">

                                        <a href="{{ url('/sale/'.$sale->id.'/products') }}" class="btn btn-secondary buttons" ><i class="fas fa-list"></i></a><br>
                                        <a href="{{ url('/sale/'.$sale->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $sales->appends(Request::except('page'))->links() }}

            @else

                <div class="page-message">
                    <h3>Nenhuma venda criada</h3>
                </div>

            @endif


        </div>

    </div>

@endsection
