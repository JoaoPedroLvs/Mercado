@extends('layouts.main',[
    'pageTitle' => 'Categorias'
])

@section('content')

    <div class="page page-category page-details">

        <div class="page-header">
            <h1>Categorias <small>Produtos da categoria</small></h1>
        </div>

        <div class="page-body mb-3">

            @if (count($category->products) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Data de criação</th>

                            @if (Auth::user()->role == 2)

                                <th>Ações</th>

                            @endif
                        </tr>

                    </thead>

                    @foreach ($category->products as $product)

                        <tbody>

                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->current_qty }}</td>
                                <td>{{ (string) $product->created_at->format('d/m/Y') }}</td>

                                @if (Auth::user()->role == 2)
                                    <td>
                                        <button type="button" class="btn btn-primary btn-cart-add"><i class="bi bi-plus"></i></button>
                                        <button type="button" class="btn btn-danger d-none btn-cart-remove"><i class="bi bi-x-lg"></i></button>
                                    </td>
                                @endif
                            </tr>

                        </tbody>

                    @endforeach

                </table>

            @else

                <div class="page-message">
                    <h3>Nenhuma categoria criada</h3>
                </div>

            @endif

            <div class="page-controls">
                <a href="{{ url('categories') }}" class="btn btn-outline-primary">Voltar</a>
            </div>

        </div>

    </div>

@endsection
