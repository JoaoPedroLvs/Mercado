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

            <div class="page-controls">
                <a href="{{ url('customer/create') }}" class="btn btn-primary">Novo Cliente</a>
            </div>

            @if (count($customers) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data de criação</th>
                            <th>Ações</th>

                        </tr>

                    </thead>

                    @foreach ($customers as $customer)

                        <tbody>

                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->created_at->format('d/m/Y') }}</td>
                                <td>

                                    <div class="table-options">

                                        <a href="{{ url('customer/'.$customer->id.'/show') }}" class="btn btn-secondary buttons" ><i class="fas fa-list"></i></a><br>
                                        <a href="{{ url('customer/'.$customer->id.'/edit') }}" class="btn btn-primary buttons" ><i class="far fa-edit"></i></a><br>
                                        <a href="{{ url('customer/'.$customer->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>

                            </tr>

                        </tbody>

                    @endforeach


                </table>

                <div class="paginate">

                    {{ $customers->appends(Request::except('page'))->links() }}

                </div>

            @else

                <div class="page-message">

                    <h3>Nenhum cliente criado</h3>

                </div>

            @endif

        </div>

    </div>

@endsection
