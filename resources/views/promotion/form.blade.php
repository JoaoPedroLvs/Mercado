@extends('layouts.main')

@section('title', $isEdit ? 'Editando promoção '.$promotion->name : 'Criando promoção')

@section('content')

    <br>

    <div class="container">

        <form action="/form/promotion" method="POST">

            @csrf

            @method($isEdit ? "PUT" : "POST")

            <label>Qual produto: </label>
            <select name="product_id">

                @if (count($products) > 0)

                    @foreach ($products as $product)

                        <option value="{{$product->id}}">{{$product->name}}</option>

                    @endforeach

                @else

                    <option>Nenhum produto cadastrado</option>

                @endif

            </select>
            <br>


            <label>Preço: </label>
            <input type="number" step="0.01" name="price" required value="{{$promotion->price ?? ""}}">
            <br><br>

            <input type="checkbox" name="is_active" {{$promotion->is_active ? "checked" : ""}} value="{{true}}">Está ativo?
            <br><br>

            <label>Data inicial: </label>
            <input type="date" name="started_at" required value="{{(string) $promotion->started_at ? $promotion->started_at->format('Y-m-d') : ""}}">
            <br>
            {{-- @dd((string) $promotion->ended_at->format('Y-m-d')) --}}
            <label>Data final: </label>
            <input type="date" name="ended_at" required value="{{(string) $promotion->ended_at ? $promotion->ended_at->format('Y-m-d') : ""}}">
            <br><br>


            @if ($isEdit)

                <input type="hidden" name="id" value="{{$promotion->id}}">

            @endif

            <button type="submit">Enviar</button>


        </form>

    </div>

@endsection
