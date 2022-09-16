@extends('layouts.main', [
    'pageTitle' => 'Carrinho'
])

@section('content')

    <div class="page page-products page-cart">

        <div class="page-header">
            <h1>Carrinho <small>Listagem de produtos no carrinho</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            @if (Session::has('cart'))

                <table class="table table-striped">

                    <thead>

                        <tr>

                            <th></th>
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Preço unitário</th>
                            <th>Ações</th>

                        </tr>

                    </thead>

                    @php

                        $total = 0;

                    @endphp

                    @foreach (Session::get('cart') as $id => $details)

                        <tbody>

                            <tr>

                                <td>
                                    <a data-fancybox data-src="{{ asset($details['image']) }}" data-caption="{{ $details['name'] }}">
                                        <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" height="40"></td>
                                    </a>
                                <td>{{ $details['name'] }}</td>
                                <td>{{ $details['qty'] }}</td>
                                <td>R$ {{ number_format($details['price'], '2', ',', ' ') }}</td>
                                <td>

                                    <div class="table-options">

                                        <a href="{{ url('add/cart/'.$id) }}" class="btn btn-primary"><i class="bi bi-plus"></i></a>

                                        <a href="{{ url('remove/cart/'.$id) }}" class="btn btn-danger removeCart"><i class="bi bi-x-lg"></i></a>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                        @php

                            $total += $details['price']*$details['qty'];

                        @endphp

                    @endforeach

                    <tfoot>
                        <tr>
                            <td>Total: </td>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td>R$ {{ number_format($total, '2', ',', ' ') }}</td>
                        </tr>
                    </tfoot>

                </table>

                <div class="page-controls d-flex justify-content-center">

                    <a href="/products" class="btn btn-outline-primary buttons">Voltar aos produtos</a>

                    <button type="button" class="btn btn-success buttons sale">Concluir venda</button>

                </div>

            @else

                <h4>Selecione um produto </h4>

            @endif

        </div>

        <form action="/sale" method="POST" class="d-none sale-form">

            @csrf

            @foreach (Session::get('cart') as $id => $product)

                <input type="hidden" name="customer_id" value="{{ Auth::user()->customer_id }}">
                <input type="hidden" name="product_id[]" value="{{ $id }}">
                <input type="hidden" name="qty_sales[]" value="{{ $product['qty'] }}">

            @endforeach

        </form>
    </div>


@endsection
