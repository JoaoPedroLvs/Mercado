@extends('layouts.main', [
    'pageTitle' => 'Vendas'
])

@section('content')

    <div class="page page-sale sale-form">

        <div class="page-header">
            <h1>Vendas <small>Criando uma venda</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('sale') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Cliente</label>
                    <select name="customer_id" class="form-select" >

                        @if (count($customers) > 0)

                            <option value="" selected>Selecione o cliente</option>

                            @foreach ($customers as $customer)

                                <option value="{{ $customer->id }}">{{ $customer->user->name }}</option>

                            @endforeach

                        @else

                            <option value="" selected>Nenhum cliente criado</option>

                        @endif

                    </select>

                </div>


                <div class="form-group">

                    <div class="products-sale">

                        @if (count($products) > 0)

                            <button type="button" class='btn btn-new-product btn-primary'>Novo produto</button><br><br>

                            <label>Qual produto foi comprado e sua quantidade: </label><br>


                            <div class="products-itens">

                                <div class="input-group select">

                                    <select name="product_id[]" class="form-select">

                                        <option  value="">Selecione um produto</option>

                                        @foreach ($products as $product)

                                            <option value="{{$product->id}}" data-price="{{ $product->price }}">{{$product->name}}</option>

                                        @endforeach

                                    </select>

                                    <span class="input-group-text d-none span"></span>

                                    <input type="number" placeholder="Quantidade" name="qty_sales[]" class="form-control">

                                    <button type="button" class="btn-delete-product btn btn-danger">X</button>

                                </div>

                            </div>

                        @else

                            <h3>Nenhum produto cadastrado</h3>
                            <p><a href="/create/product">Clique aqui</a> para criar um novo</p>

                        <br>

                        @endif

                    </div>

                </div>

                <div class="page-controls">

                    <a href="{{ url('sales') }}" class="btn btn-outline-primary">Voltar</a>

                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>

            </form>

        </div>

    </div>

@endsection
