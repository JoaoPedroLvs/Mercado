@extends('layouts.main', [
    'pageTitle' => 'Funcionários'
])

@section('content')

    <div class="page page-employee page-index">

        <div class="page-header">
            <h1><a href="/employees">Funcionários</a> <small>Listagem de funcionários</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls mb-3">
                <a href="{{ url('employee/create') }}" class="btn btn-primary">Novo funcionário</a>
            </div>

            <div class="row g-3">

                <div class="col-md-6">

                    <form action="/employees" method="get">

                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                            <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                        </div>

                    </form>

                </div>

                <div class="col-md-6">

                    <form action="/employees" method="get">
                        @csrf


                        <div class="input-group">

                            <select name="qtyPaginate" id="qtyPaginate" class="form-select select-qty" data-url="/employees">

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

                    <h4>Pesquisando por <small>{{ $search }}</small></h4>

                </div>
            @endif

            @if (count($employees))

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th class="order" data-url="/employees" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/employees" data-field="name" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Nome <span><small><i class="bi bi-caret-down d-none name"></i><i class="bi bi-caret-up d-none name"></i></small></span></th>
                            <th class="order" data-url="/employees" data-field="email" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">E-mail <span><small><i class="bi bi-caret-down d-none email"></i><i class="bi bi-caret-up d-none email"></i></small></span></th>
                            <th>Data de criação</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($employees as $employee)

                        <tbody>

                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->user->name }}</td>
                                <td>{{ $employee->user->email }}</td>
                                <td>{{ $employee->created_at->format('d/m/Y') }}</td>
                                <td>

                                    <div class="table-options">

                                        <a href="{{ url('employee/'.$employee->id.'/show') }}" class="btn btn-secondary buttons" ><i class="fas fa-list"></i></a><br>
                                        <a href="{{ url('employee/'.$employee->id.'/edit') }}" class="btn btn-primary buttons" ><i class="far fa-edit"></i></a><br>
                                        <a href="{{ url('employee/'.$employee->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $employees->appends(Request::except('page'))->links() }}

            @else

                <div class="page-message">

                    <h3>Nenhum funcionário criado</h3>

                </div>

            @endif

        </div>

    </div>

@endsection
