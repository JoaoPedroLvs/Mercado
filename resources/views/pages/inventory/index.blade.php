@extends('layouts.main', [
    'pageTitle' => 'Estoque'
])

@section('content')

    <div class="page pgae-inventories page-index">

        <div class="page-header">
            <h1><a href="/inventories">Estoque</a> <small>Listagem de estoques</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls mb-3">
                <a href="{{ url('inventory/create') }}" class="btn btn-primary">Novo Estoque</a>
            </div>


            <form action="/inventories" method="get">

                @csrf

                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                    <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                </div>

            </form>

            @if ($search)

                <div class="page-message">
                    <h4>Procurando por: <small>{{ $search }}</small></h4>
                </div>

            @endif
            @if (count($inventories) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th class="order" data-url="/inventories" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/inventories" data-field="name" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Produto <span><small><i class="bi bi-caret-down d-none name"></i><i class="bi bi-caret-up d-none name"></i></small></span></th>
                            <th class="order" data-url="/inventories" data-field="qty" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Quantidade <span><small><i class="bi bi-caret-down d-none qty"></i><i class="bi bi-caret-up d-none qty"></i></small></span></th>
                            <th class="order" data-url="/inventories" data-field="created_at" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Data de entrada <span><small><i class="bi bi-caret-down d-none created_at"></i><i class="bi bi-caret-up d-none created_at"></i></small></span></th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($inventories as $inventory)

                        <tbody>

                            <tr>
                                {{-- @dd($inventory->created_at) --}}
                                <td>{{ $inventory->id }}</td>
                                <td>{{ $inventory->name }}</td>
                                <td>{{ $inventory->qty }}</td>
                                <td>{{ $inventory->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ url('inventory/'.$inventory->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $inventories->appends(Request::except('page'))->links() }}

            @else

                <div class="page-message">
                    <h3>Nenhum estoque criado</h3>
                </div>

            @endif

        </div>

    </div>

@endsection
