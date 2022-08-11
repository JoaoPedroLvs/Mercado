@extends('layouts.main')

@section('title', $isEdit ? 'Editando '. $category->name : 'Criando categoria')

@section('content')

    <br><br>

    <a href="/categories">Ver categorias</a>

    <br><br>

    <div class="container">
        <form action="/form/category" method="POST">
            @csrf

            @method($isEdit ? "PUT" : "POST")

            <label>Nome: </label>
            <input type="text" name="name" required value="{{$category->name ?? ""}}">
            <br><br>

            @if($isEdit)
                <input type="hidden" name="id" value="{{$category->id}}">
            @endif

            <button type="submit">Enviar</button>
            <input type="reset" value="Redefinir alterações">
        </form>
    </div>

@endsection
