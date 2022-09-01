@extends('layouts.main', [
    'pageTitle' => 'Estoque'
])

@section('content')

    <div class="page pgae-inventories page-index">

        <div class="page-header">
            <h1>Estoque <small>Listagem de estoques</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls mb-3">
                <a href="{{ url('inventory/create') }}" class="btn btn-primary">Novo Estoque</a>
            </div>

            @if (count($inventories) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Data de entrada</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($inventories as $inventory)

                        <tbody>

                            <tr>
                                {{-- @dd($inventory->created_at) --}}
                                <td>{{ $inventory->id }}</td>
                                <td>{{ $inventory->product->name }}</td>
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
