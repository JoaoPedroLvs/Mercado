@extends('layouts.main', [
    'pageTitle' => 'Produtos'
])

@section('content')

    <div class="page page-product page-index">

        <div class="page-header">
            <h1>Produtos <small>Listagem de produtos</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            @if(Auth::user()->role != 2)

                <div class="page-controls mb-3">

                    <a href="{{ url('product/create') }}" class="btn btn-primary">Novo Produto</a>

                </div>
            @endif

            @if (count($products) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            @if (Auth::user()->role != 2)

                                <th>Vendido</th>

                            @endif
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
                                <td>R$ {{$product->promotion ? number_format($product->promotion, '2', ',', ' ') : number_format($product->price, '2', ',', ' ' ) }}</td>
                                <td>{{ $product->current_qty }}</td>
                                @if (Auth::user()->role != 2)

                                    <td>{{ $product->total_sold }}</td>

                                @endif
                                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if (Auth::user()->role != 2)

                                        <div class="table-options">

                                            <a href="{{ url('product/'.$product->id.'/edit') }}" class="btn btn-primary buttons" ><i class="far fa-edit"></i></a><br>
                                            <a href="{{ url('product/'.$product->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>

                                        </div>
                                    @else

                                        <div class="table-options">
                                            <button type="button" class="btn btn-primary btn-cart-add"><i class="bi bi-plus"></i></button>
                                            <button type="button" class="btn btn-danger d-none btn-cart-remove"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    @endif
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
