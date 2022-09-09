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

            @if(Auth::user()->role != 2)

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
                            <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                        </div>

                    </form>

                </div>

                <div class="col-md-6">

                    <form action="/products" method="get">
                        @csrf


                        <div class="input-group">

                            <select name="qtyPaginate" id="qtyPaginate" class="form-select select-qty" data-url="/products">

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
                            <th>Categoria</th>
                            <th class="order" data-url="/products" data-field="price" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Preço <span><small><i class="bi bi-caret-down d-none price"></i><i class="bi bi-caret-up d-none price"></i></small></span></th>
                            <th>Quantidade</th>
                            <th>Data de criação</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($products as $product)

                        <tbody>

                            <tr>
                                <td>{{ $product->id }}</td>

                                <td>

                                    <a data-fancybox data-src="{{ asset($product->image) }}" data-caption="{{ $product->name }}">

                                        <img src="{{ asset($product->image) }}" alt="Imagem do produto" height="50px" class="image">

                                    </a>

                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>R$ {{$product->promotion ? number_format($product->promotion, '2', ',', ' ') : number_format($product->price, '2', ',', ' ' ) }}</td>
                                <td>{{ $product->current_qty }}</td>
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
