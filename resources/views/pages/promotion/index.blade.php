@extends('layouts.main', [
    'pageTitle' => 'Promoções'
])

@section('content')

    <div class="page page-promotions page-index">


        <div class="page-header">
            <h1><a href="/promotions">Promoções</a> <small>Listagem de promoções</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            {{-- @if (Auth::user() != 'user') --}}

                <div class="page-controls mb-3">
                    <a href="{{ url('promotion/create') }}" class="btn btn-primary">Nova Promoção</a>
                </div>

            {{-- @endif --}}


            <div class="row g-3">

                <div class="col-md-6">

                    <form action="/promotions" method="get">

                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Pesquisar"/>
                            <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                        </div>

                    </form>

                </div>

                <div class="col-md-6">

                    <form action="/promotions" method="get">
                        @csrf


                        <div class="input-group">

                            <select name="qtyPaginate" id="qtyPaginate" class="form-select select-qty" data-url="/promotions">

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

            @if (count($promotions) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th class="order" data-url="/promotions" data-field="id" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">ID <span><small><i class="bi bi-caret-down d-none id"></i><i class="bi bi-caret-up d-none id"></i></small></span></th>
                            <th class="order" data-url="/promotions" data-field="name" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Produto <span><small><i class="bi bi-caret-down d-none name"></i><i class="bi bi-caret-up d-none name"></i></small></span></th>
                            <th class="order" data-url="/promotions" data-field="price" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Preço <span><small><i class="bi bi-caret-down d-none price"></i><i class="bi bi-caret-up d-none price"></i></small></span></th>
                            <th class="order" data-url="/promotions" data-field="is_active" data-order="{{ $order == 'asc' ? 'desc' : 'asc' }}">Status <span><small><i class="bi bi-caret-down d-none is_active"></i><i class="bi bi-caret-up d-none is_active"></i></small></span></th>
                            <th>Data Inicial</th>
                            <th>Data Final</th>
                            @if (Auth::user()->role != 2)

                                <th>Ações</th>

                            @endif
                        </tr>

                    </thead>

                    @foreach ($promotions as $promotion)

                        <tbody>

                            <tr>
                                <td>{{ $promotion->id }}</td>
                                <td>{{ $promotion->name }}</td>
                                <td>R$ {{ number_format($promotion->price, 2, ',', ' ') }}</td>
                                <td>{{ $promotion->is_active ? 'Ativa' : 'Desativa' }}</td>
                                <td>{{ $promotion->started_at->format('d/m/Y') }}</td>
                                <td>{{ $promotion->ended_at->format('d/m/Y') }}</td>
                                @if (Auth::user()->role != 2)

                                    <td>
                                        <div class="table-options">

                                            <a href="{{ url('promotion/'.$promotion->id.'/edit') }}" class="btn btn-primary buttons" ><i class="far fa-edit"></i></a><br>
                                            <a href="{{ url('promotion/'.$promotion->id.'/delete') }}" class="btn btn-danger buttons" ><i class="fas fa-trash"></i></a>

                                        </div>
                                    </td>

                                @endif
                            </tr>

                        </tbody>

                    @endforeach

                </table>

                {{ $promotions->appends(Request::except('page'))->links() }}

            @else

                <div class="page-message">
                    <h3>Nenhuma promoção criada</h3>
                </div>

            @endif

        </div>

    </div>

@endsection
