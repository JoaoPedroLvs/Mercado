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

            <div class="page-controls">
                <a href="{{ url('category/create') }}" class="btn btn-primary">Nova categoria</a>
            </div>

            @if (count($categories) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Quantidade de produtos</th>
                            <th>Data de criação</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($categories as $category)

                        <tbody>

                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ count($category->products) }}</td>
                                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="table-options">

                                        <a href="{{ url('category/'.$category->id.'/products') }}" class="btn btn-secondary buttons" ><i class="fas fa-list"></i></a><br>
                                        <a href="{{ url('category/'.$category->id.'/edit') }}" class="btn btn-primary buttons" ><i class="far fa-edit"></i></a><br>
                                        <a href="{{ url('category/'.$category->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $categories->appends(Request::except('page'))->links() }}

            @else

                <div class="page-message">

                    <h3>Nenhuma categoria criada</h3>

                </div>

            @endif

        </div>

    </div>

@endsection
