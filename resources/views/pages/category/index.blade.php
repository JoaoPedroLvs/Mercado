@extends('layouts.main',[
    'pageTitle' => 'Categorias'
])

@section('content')

    <div class="page page-categories page-index">

        <div class="page-header">
            <h1>Categorias <small>Listagem de categorias</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            @if (count($categories) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($categories as $category)

                        <tbody>

                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ url('category/'.$category->id.'/products') }}">Ver Produtos</a><br>
                                    <a href="{{ url('category/'.$category->id.'/edit') }}">Editar</a><br>
                                    <a href="{{ url('category/'.$category->id.'/delete') }}">Remover</a>
                                </td>
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
                <a href="{{ url('category/create') }}" class="btn btn-primary">Nova categoria</a>
            </div>

        </div>

    </div>

@endsection
