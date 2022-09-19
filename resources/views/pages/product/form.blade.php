@extends('layouts.main',[
    'pageTitle' => 'Produtos'
])

@section('content')

    @php
        $isEdit = !empty($product->id);
    @endphp

    <div class="page page-product page-form">

        <div class="page-header">
            <h1>Produtos <small>{{ $isEdit ? 'Editar produto' : 'Criar produto' }}</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('product') }}" method="post" enctype="multipart/form-data">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                <input type="hidden" name="id" value="{{ $product->id }}">

                <div class="form-group">
                    <label for="image" class="btn btn-primary">Selecione uma imagem</label>
                    <input type="file" class="d-none input-image" name="image" id="image" accept="image/*"><span class="file-input">Nenhum arquivo selecionado</span>
                </div>

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name',$product->name) }}" maxlength="100" required required required data-parsley-errors-container="#name-type-error" data-parsley-error-message="Nome necessário" />
                    <div id="name-type-error"></div>
                </div>

                <div class="form-group">
                    <label for="category_id">Categorias</label>
                    <select name="category_id" class="form-select" required required data-parsley-errors-container="#category-type-error" data-parsley-error-message="Categoria necessária">

                    @if (count($categories) > 0)

                    <option value="" {{ $isEdit ?? 'selected' }}>Selecione uma categoria</option>

                            @foreach ($categories as $category)

                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>

                            @endforeach

                        @else

                        <option value="" selected>Nenhuma categoria criada</option>

                        @endif

                    </select>
                    <div id="category-type-error"></div>
                </div>

                <div class="form-group">
                    <label>Preço</label>

                    <div class="input-group">

                        <span class="input-group-text">R$</span>
                        <input type="text" name="price" required required data-parsley-errors-container="#price-type-error" data-parsley-error-message="Preço necessária" step="0.01" class="form-control price" value="{{ old('price',$product->price) }}">

                    </div>


                    <div class="" id="price-type-error"></div>

                </div>

                <div class="page-control">

                    <a href="{{ url('products') }}" class="btn btn-outline-primary">Voltar</a>

                    <button type="submit" class="btn btn-success">Enviar</button>

                </div>

            </form>

        </div>

    </div>

@endsection
