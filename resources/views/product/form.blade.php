@extends('layouts.main')

@section('title', $isEdit ? 'Editando ' . $product->name : 'Criando produto')

@section('content')

    <br>

    @if(session()->has('msg'))

        <h4>{{session()->get('msg')}}</h4>

    @endif

    <a href="/products">Voltar para produtos</a>

    <br><br>

    <div class="container">
        <form action="/form/product" method="POST">

            @csrf

            @method($isEdit ? 'PUT' : 'POST')

            <label>Nome: </label>
            <input type="text" name="name" required value="{{ $product->name ?? '' }}">

            <br><br>

            <label>Preço: </label>
            <input type="number" name="price" step="0.01" required value="{{ $product->price ?? '' }}">

            <br><br>

            <label>Categorias</label>
            <select name="category_id" required>

                @if (count($categories) > 0)

                    @foreach ($categories as $category)

                        <option value="{{ $category->id }}">{{ $category->name }}</option>

                    @endforeach

                @else

                    <option>Nenhuma categoria criada</option>

                @endif

            </select>

            <br><br>

            @if ($isEdit)

                <input type="hidden" name="id" value="{{ $product->id }}">

            @endif

            <button type="submit">Enviar</button>

            <input type="reset" value="Redefinir alteirações">

        </form>
    </div>

@endsection
