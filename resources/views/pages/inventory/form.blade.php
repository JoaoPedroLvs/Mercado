@extends('layouts.main', [
    'pageTitle' => 'Estoque'
])

@section('content')

    <div class="page page-inventories page-form">

        <div class="page-header">
            <h1>Estoque <small>Criar estoque</small></h1>
        </div>

        <div class="page-body">
            @include('components.alert')

            <form action="{{ url('inventory') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Produto</label>
                    <select name="product_id" class="form-control" required data-parsley-errors-container="#product-type-error" data-parsley-error-message="Produto necessário">

                        <option value="" selected>Selecione um produto:</option>

                        @foreach ($products as $product)

                            <option value="{{ $product->id }}">{{ $product->name }}</option>

                        @endforeach

                    </select>

                    <div id="product-type-error"></div>
                </div>

                <div class="form-group">
                    <label>Quantidade</label>
                    <input type="number" name="qty" class="form-control" required data-parsley-errors-container="#qty-type-error" data-parsley-error-message="Preço necessário">
                    <div id="qty-type-error"></div>
                </div>

                <div class="form-group">
                    <label>Data de entrada</label>
                    <input type="date" name="created_at" class="form-control" required data-parsley-errors-container="#date-type-error" data-parsley-error-message="Data necessária">
                    <div class="" id="date-type-error"></div>
                </div>

                <div class="page-controls">

                    <a href="{{ url('inventories') }}" class="btn btn-outline-primary">Voltar</a>

                    <button type="submit" class="btn btn-success">Enviar</button>

                </div>

            </form>

        </div>

    </div>

@endsection
