@extends('layouts.main',[
    'pageTitle' => 'Categorias'
])

@section('content')

    <div class="page page-categories page-index">

        <div class="page-header">
            <h1><a href="/categories">Categorias </a><small>Listagem de categorias</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            @if (Auth::user()->role != 2)

                <div class="page-controls mb-3">
                    <a href="{{ url('category/create') }}" class="btn btn-primary">Nova categoria</a>
                </div>

            @endif

            <div class="row g-3">

                <div class="col-md-6">

                    <form action="/categories" method="get">

                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                            <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                        </div>

                    </form>

                </div>

                <div class="col-md-6">

                    <form action="/categories" method="get">
                        @csrf


                        <div class="input-group">

                            <select name="qtyPaginate" id="qtyPaginate" class="form-select select-qty" data-url="/categories">

                                <option {{ $qtyPaginate == 10 ? 'selected' : '' }}>Quantos itens deseja aparecer</option>
                                <option data-value="10">10</option>
                                <option data-value="25" {{ $qtyPaginate == 25 ? 'selected' : '' }}>25</option>
                                <option data-value="50" {{ $qtyPaginate == 50 ? 'selected' : '' }}>50</option>

                            </select>

                        </div>


                    </form>

                </div>
            </div>

            @if ($search)

                <div class="page-message">
                    <h4>Procurando por: <small>{{ $search }}</small></h4>
                </div>

            @endif

            @if (count($categories) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th class="order" data-url="/categories" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/categories" data-field="name" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Nome <span><small><i class="bi bi-caret-down d-none name"></i><i class="bi bi-caret-up d-none name"></i></small></span></th>
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

                                        @if (Auth::user()->role != 2)

                                            <a href="{{ url('category/'.$category->id.'/edit') }}" class="btn btn-primary buttons" ><i class="far fa-edit"></i></a><br>
                                            <a href="{{ url('category/'.$category->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>

                                        @endif

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
