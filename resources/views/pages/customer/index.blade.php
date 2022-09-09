@extends('layouts.main', [
    'pageTitle' => 'Clientes'
])

@section('content')

    <div class="page page-customer page-index">

        <div class="page-header">
            <h1><a href="/customers">Clientes</a> <small>Listagem de clientes</small></h1>
        </div>

        <div class="page-body mb-3">

            @include('components.alert')

            <div class="page-controls mb-3">
                <a href="{{ url('customer/create') }}" class="btn btn-primary">Novo Cliente</a>
            </div>

            <form action="/customers" method="get">

                @csrf

                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                    <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                </div>

            </form>

            @if ($search)

                <div class="page-message">

                    <h4>Pesquisando por: <small>{{ $search }}</small></h4>

                </div>

            @endif

            @if (count($customers) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th class="order" data-url="/customers" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/customers" data-field="name" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Nome <span><small><i class="bi bi-caret-down d-none name"></i><i class="bi bi-caret-up d-none name"></i></small></span></th>
                            <th class="order" data-url="/customers" data-field="email" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">E-mail <span><small><i class="bi bi-caret-down d-none email"></i><i class="bi bi-caret-up d-none email"></i></small></span></th>
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
