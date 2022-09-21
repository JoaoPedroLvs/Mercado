@extends('layouts.main', [
    'pageTitle' => 'Produtos'
])

@section('content')

    <div class="page page-product page-index">

        <div class="page-header">
            <h1><a href="/products">Produtos</a> <small>Listagem de produtos</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            @if(!Session::get('customer'))

                <div class="page-controls mb-3">

                    <a href="{{ url('product/create') }}" class="btn btn-primary">Novo Produto</a>

                </div>

            @endif

            <div class="row g-3">

                <div class="col-md-6">

                    <form action="/products" method="get">

                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                            </div>
                        </div>

                    </form>

                </div>

                <div class="col-md-6">

                    <form action="/products" method="get">
                        @csrf


                        <div class="input-group">

                            <select name="qtyPaginate" id="qtyPaginate" class="form-control select-qty" data-url="/products">

                                <option {{ $qtyPaginate == 10 ? 'selected' : '' }}>Quantos itens deseja aparecer</option>
                                <option data-value="10">10</option>
                                <option data-value="25" {{ $qtyPaginate == 25 ? 'selected' : '' }}>25</option>
                                <option data-value="50" {{ $qtyPaginate == 50 ? 'selected' : '' }}>50</option>

                            </select>

                        </div>


                    </form>

                </div>

            </div>

            @if ($search)

                <div class="page-message">

                    <h4>Pesquisando por: <small>{{ $search }}</small></h4>

                </div>

            @endif

            @if (count($products) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th class="order" data-url="/products" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th>Imagem</th>
                            <th class="order" data-url="/products" data-field="name" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Nome <span><small><i class="bi bi-caret-down d-none name"></i><i class="bi bi-caret-up d-none name"></i></small></span></th>

                            @if (!Session::has('customer'))

                                <th>Categoria</th>

                            @endif

                            <th class="order" data-url="/products" data-field="price" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Preço <span><small><i class="bi bi-caret-down d-none price"></i><i class="bi bi-caret-up d-none price"></i></small></span></th>

                            @if (!Session::has('customer'))

                                <th>Quantidade</th>

                            @endif

                            <th>Data de criação</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($products as $product)

                        <tbody>

                            <tr>
                                <td>{{ $product->id }}</td>

                                <td>

                                    <a data-fancybox data-src="{{ url('product/'.$product->id.'/image') }}" data-caption="{{ $product->name }}">

                                        <img src="{{ url('product/'.$product->id.'/image') }}" alt="{{ $product->name }}" height="41px" class="image">

                                    </a>

                                </td>
                                <td>{{ $product->name }}</td>

                                @if (!Session::has('customer'))

                                    <td>{{ $product->category->name }}</td>

                                @endif

                                <td>R$ {{$product->promotion ? number_format($product->promotion, '2', ',', ' ') : number_format($product->price, '2', ',', ' ' ) }}</td>

                                @if (!Session::has('customer'))

                                    <td>{{ $product->current_qty }}</td>

                                @endif

                                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if (!Session::get('customer'))

                                        <div class="table-options">

                                            <a href="{{ url('product/'.$product->id.'/edit') }}" class="btn btn-primary buttons" ><i class="bi bi-pencil-square"></i></a><br>
                                            <a href="{{ url('product/'.$product->id.'/delete') }}" class="btn btn-danger buttons" ><i class="bi bi-trash"></i></a>

                                        </div>
                                    @else
                                        <div class="table-options">
                                            <a href="{{ url('add/cart/'.$product->id) }}" class="btn btn-primary"><i class="bi bi-plus"></i></a>

                                            @php
                                                $cart = Session::get('cart');
                                            @endphp

                                            @if (isset($cart[$product->id]))

                                                @if ($cart[$product->id]['qty'] > 0)

                                                    <div class="product-qty">

                                                        <p>{{ $cart[$product->id]['qty'] }}</p>

                                                    </div>

                                                    <a href="{{ url('remove/cart/'.$product->id) }}" class="btn btn-danger removeCart"><i class="bi bi-x-lg"></i></a>

                                                @endif

                                            @endif

                                        </div>

                                    @endif
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

                <div class="paginate">

                    {{ $products->appends(Request::except('page'))->links() }}

                </div>

            @else

                <div class="page-message">

                    <h3>Nenhum produto criado</h3>

                </div>

            @endif

        </div>

    </div>

@endsection
