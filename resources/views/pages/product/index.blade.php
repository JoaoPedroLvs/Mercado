@extends('layouts.main', [
    'pageTitle' => 'Produtos'
])

@section('content')

    <div class="page page-product page-index">

        <div class="page-header">
            <h1>Produtos <small>Listagem de produtos</small></h1>
            <h3>Produto mais vendido: <small>{{ isset($productMostSold->total_sold) == 0 ? 'Nenhum produto criado' : $productMostSOld->name }}</small></h3>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls">

                <a href="{{ url('product/create') }}" class="btn btn-primary">Novo Produto</a>

            </div>

            @if (count($products) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Vendido</th>
                            <th>Data de criação</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($products as $product)

                        <tbody>

                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>R$ {{ number_format($product->price, '2', ',', ' ' ) }}</td>
                                <td>{{ $product->current_qty }}</td>
                                <td>{{ $product->total_sold }}</td>
                                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="table-options">

                                        <a href="{{ url('product/'.$product->id.'/edit') }}" class="btn btn-primary buttons" ><i class="far fa-edit"></i></a><br>
                                        <a href="{{ url('product/'.$product->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $products->appends(Request::except('page'))->links() }}

            @else

                <div class="page-message">

                    <h3>Nenhum produto criado</h3>

                </div>

            @endif

        </div>

    </div>

@endsection
