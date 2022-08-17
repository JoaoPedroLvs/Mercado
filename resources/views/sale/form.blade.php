@extends('layouts.main')

@section('title', 'Nova venda')

@section('content')

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

            @if (count($products) > 0)
                <label>Qual produto foi comprado e sua quantidade: </label><br>

                @foreach ($products as $k => $product)

                    <input type="checkbox" name="product_id[{{$k}}]" value="{{ $product->id }}">{{$product->name}}

                    <input type="number" name="qty_sales[]">
                    <br>

                @endforeach

            @else

                <h3>Nenhum produto cadastrado</h3>
                <p><a href="/create/product">Clique aqui</a> para criar um novo</p>

            <br>

            @endif
            <button type="submit">Enviar</button>
        </form>

    </div>

@endsection
