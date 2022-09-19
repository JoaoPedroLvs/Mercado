@extends('layouts.main', [
    'pageTitle' => 'Promoções'
])

@section('content')

    @php
        $isEdit = !empty($promotion->id);
    @endphp

    <div class="page page-promotion page-form">

        <div class="page-header">
            <h1>Promoções <small>{{ $isEdit ? 'Editando promoção' : 'Criando promoção' }}</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('promotion') }}" method="POST">
                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                <input type="hidden" name="id" value="{{ $promotion->id }}">

                <div class="form-group">
                    <input type="checkbox" name="is_active" id="checkbox" class="from-check-input" {{ $promotion->is_active ? "checked" : "" }} value="{{ true }}">
                    <label for="checkbox">Está Ativo?</label>
                </div>

                <div class="form-group">
                    <label>Produto</label>
                    <select name="product_id" class="form-select" required data-parsley-errors-container="#product-type-error" data-parsley-error-message="Produto necessário">

                        @if (count($products) > 0)

                            <option value="" selected>Selecione um produto</option>

                            @foreach ($products as $product)


                                <option value="{{ $product->id }}" {{ $product->id == $promotion->product_id ? 'selected' : '' }}>{{ $product->name }}</option>

                            @endforeach

                        @else

                            <option>Nenhum produto criado</option>

                        @endif

                    </select>

                    <div id="#product-type-error"></div>

                </div>

                <div class="form-group">
                    <label>Preço</label>

                    <div class="input-group">

                        <span class="input-group-text">R$</span>
                        <input type="text" name="price" step="0.01" class="form-control price" required data-parsley-errors-container="#price-type-error" data-parsley-error-message="Preço necessário" value="{{ old('price',$promotion->price) }}">

                    </div>

                    <div id="price-type-error"></div>

                </div>

                <div class="form-group">
                    <label>Data de início</label>
                    <input type="date" name="started_at" class="form-control" required data-parsley-errors-container="#dateI-type-error" data-parsley-error-message="Data inicial necessária" value="{{ $promotion->started_at ? (string) $promotion->started_at->format('Y-m-d') : '' }}">
                    <div id="dateI-type-error"></div>
                </div>

                <div class="form-group">
                    <label>Data final</label>
                    <input type="date" name="ended_at" class="form-control" required data-parsley-errors-container="#dateF-type-error" data-parsley-error-message="Data final necessária" value="{{ $promotion->ended_at ? (string) $promotion->ended_at->format('Y-m-d') : '' }}">
                    <div id="#dateF-type-error"></div>
                </div>

                <div class="page-controls">

                    <a href="{{ url('promotions') }}" class="btn btn-outline-primary">Voltar</a>

                    <button type="submit" class="btn btn-success">Enviar</button>

                </div>

            </form>

        </div>

    </div>

@endsection
