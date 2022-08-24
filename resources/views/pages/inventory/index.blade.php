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

            @if (count($inventories) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($inventories as $inventory)

                        <tbody>

                            <tr>
                                <td>{{ $inventory->id }}</td>
                                <td>{{ $inventory->product->name }}</td>
                                <td>{{ $inventory->qty }}</td>
                                <td>
                                    <a href="{{ url('inventory/'.$inventory->id.'/delete') }}">Remover</a>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

            @else

                <div class="page-message">
                    <h3>Nenhum estoque criado</h3>
                </div>

            @endif

            <div class="page-controls">
                <a href="{{ url('inventory/create') }}" class="btn btn-primary">Criar Estoque</a>
            </div>

        </div>

    </div>

@endsection
