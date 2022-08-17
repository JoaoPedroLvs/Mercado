@extends('layouts.main')

@section('title', 'Criando estoque')

@section('content')

    <br>

    <div class="container">

        @if (session()->has('msg'))

            <h4>{{session()->get('msg')}}</h4>

        @endif

        <form action="/form/inventory" method="POST">

            @csrf

            {{-- @dd($inventory->product); --}}

            <label>Produto: </label>
            <select name="product_id" required>

                @if (count($products) > 0)

                    @foreach ($products as $product)

                        <option value="{{ $product->id }}">{{ $product->name }}</option>

                    @endforeach

                @else

                    <option>Nenhum produto criado</option>

                @endif

            </select><br><br>

            <label>Quantidade: </label>
            <input type="number" name="qty" required><br><br>

            <label>Data: </label>
            <input type="date" name="created_at"><br><br>


            <button type="submit">Enviar</button>

        </form>

    </div>

@endsection
