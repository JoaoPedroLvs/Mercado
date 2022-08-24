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

            @if (count($products) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($products as $product)

                        <tbody>

                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>R$ {{ number_format($product->price, '2', ',', ' ' ) }}</td>
                                <td>{{ $product->current_qty }}</td>
                                <td>
                                    <a href="{{ url('product/'.$product->id.'/edit') }}">Editar</a><br>
                                    <a href="{{ url('product/'.$product->id.'/delete') }}">Remover</a>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

            @else

                <div class="page-message">

                    <h3>Nenhum produto criado</h3>

                </div>

            @endif

            <div class="page-controls">

                <a href="{{ url('product/create') }}" class="btn btn-primary">Novo Produto</a>
            </div>

        </div>

    </div>

@endsection
