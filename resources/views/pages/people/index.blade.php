@extends('layouts.main',[
    'pageTitle' => 'Pessoa'
])

@section('content')

    <div class="page page-people page-index">

        <div class="page-header">
            <h1><a href="/people">Pessoas</a> <small>Listagem de pessoas</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <div class="page-controls mb-3">

                <a href="{{ url('person/create') }}" class="btn btn-primary">Nova Pessoa</a>

            </div>

            <div class="row g-3">

                <div class="col-md-6">

                    <form action="/people" method="get">

                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                            <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                        </div>

                    </form>

                </div>

                <div class="col-md-6">

                    <form action="/people" method="get">
                        @csrf


                        <div class="input-group">

                            <select name="qtyPaginate" id="qtyPaginate" class="form-select select-qty" data-url="/people">

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

                    <h4>Pesquisando por: <small>{{ $search }}</small></h4>

                </div>
            @endif

            @if (count($people) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th class="order" data-url="/people" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/people" data-field="name" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Nome <span><small><i class="bi bi-caret-down d-none name"></i><i class="bi bi-caret-up d-none name"></i></small></span></th>
                            <th>CPF</th>
                            <th>Data de criação</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    @foreach ($people as $person)

                        <tbody>

                            <tr>

                                <td>{{ $person->id }}</td>
                                <td>{{ $person->name }}</td>
                                <td>{{ $person->cpf }}</td>
                                <td>{{ $person->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="table-options">

                                        <a href="{{ url('person/'.$person->id.'/show') }}" class="btn btn-secondary buttons"><i class="fas fa-list"></i></a>
                                        <a href="{{ url('person/'.$person->id.'/edit') }}" class="btn btn-primary buttons"><i class="far fa-edit"></i></a>
                                        <a data-url="person/{{ $person->id }}/delete" class="btn btn-danger buttons delete"><i class="fas fa-trash"></i></a>

                                    </div>
                                </td>

                            </tr>

                        </tbody>

                    @endforeach

                </table>

                <div class="paginate">

                    {{ $people->appends(Request::except('page'))->links() }}

                </div>

            @else

                <div class="page-message">

                    <h3>Nenhuma pessoa criada</h3>

                </div>

            @endif

        </div>

    </div>
@endsection
