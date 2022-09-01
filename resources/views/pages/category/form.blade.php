@extends('layouts.main',[
    'pageTitle' => 'Categorias'
])

@section('content')

    @php
        $isEdit = !empty($category->id)
    @endphp

    <div class="page page-category page-form">

        <div  class="page-header">
            <h1>Categorias <small>{{ $isEdit ? 'Editar categoria' : 'Criar categoria' }}</small></h1>
        </div >

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('category') }}" method="POST">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                <input type="hidden" name="id" value="{{ $category->id }}">

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="name" class="form-control" required maxlength="50" value="{{ old('name',$category->name) }}"/>
                </div>

                <div class="page-controls">


                    <a href="{{ url('categories') }}" class="btn btn-outline-primary">Voltar</a>

                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>

            </form>

        </div>

    </div>

@endsection
