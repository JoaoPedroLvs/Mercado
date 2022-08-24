@extends('layouts.main',[
    'pageTitle' => 'Categorias'
])

@section('content')

    <div class="page page-category page-details">

        <div class="page-header">
            <h1>Categorias <small>Produtos da categoria</small></h1>
        </div>

        <div class="page-body">

            @if (count($category->products) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Quantidade</th>
                        </tr>

                    </thead>

                    @foreach ($category->products as $product)

                        <tbody>

                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->current_qty }}</td>
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
                <a href="{{ url('categories') }}" class="btn btn-primary">Voltar</a>
            </div>

        </div>

    </div>

@endsection
