@extends('layouts.main')

@section('title', 'Nova venda')

@section('content')

    <div class="page sale form">

        <div class="container">
            <h1>Nova venda</h1>

            <form action="/form/sale" method="POST">

                @csrf

                <label>Cliente: </label>
                <select name="customer_id" required>
                    <option selected>Selecione um cliente</option>

                    @foreach ($customers as $customer)

                        <option value="{{$customer->id}}">{{$customer->name}}</option>

                    @endforeach

                </select>
                <br>

                <label>Funcionário: </label>
                <select name="employee_id" required>
                    <option selected>Selecione um funcionário</option>

                    @foreach ($employees as $employee)

                        <option value="{{$employee->id}}">{{$employee->name}}</option>

                    @endforeach

                </select>
                <br>
                <br>

                <div class="products sale">

                    @if (count($products) > 0)

                        <button type="button" class='btn new product'>Novo produto</button><br><br>

                        <label>Qual produto foi comprado e sua quantidade: </label><br>


                        <div class="products itens">

                            <select name="product_id[]">
                                <option selected>Selecione um produto</option>

                                @foreach ($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach

                            </select>

                            <input type="number" placeholder="Quantidade" name="qty_sales[]">
                            <button type="button" class="btn-delete-product">Excluir produto</button>

                            <br><br>
                        </div>

                    @else

                        <h3>Nenhum produto cadastrado</h3>
                        <p><a href="/create/product">Clique aqui</a> para criar um novo</p>

                    <br>

                    @endif

                </div>

                <button type="submit">Enviar</button>
            </form>

        </div>
    </div>

@endsection
