@extends('layouts.main', [
    'pageTitle' => 'Clientes'
])

@section('content')

    <div class="page page-customer page-index">

        <div class="page-header">
            <h1>Clientes <small>Listagem de clientes</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            @if (count($customers) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Ações</th>

                        </tr>

                    </thead>

                    @foreach ($customers as $customer)

                        <tbody>

                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    <a href="{{ url('customer/'.$customer->id.'/show') }}">Visualizar</a><br>
                                    <a href="{{ url('customer/'.$customer->id.'/edit') }}">Editar</a><br>
                                    <a href="{{ url('customer/'.$customer->id.'/delete') }}">Remover</a>
                                </td>

                            </tr>

                        </tbody>

                    @endforeach

                </table>

            @else

                <div class="page-message">

                    <h3>Nenhum cliente criado</h3>

                </div>

            @endif

            <div class="page-controls">
                <a href="{{ url('customer/create') }}" class="btn btn-primary">Novo Cliente</a>
            </div>

        </div>

    </div>

@endsection
