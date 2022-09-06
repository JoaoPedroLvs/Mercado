@extends('layouts.main', [
    'pageTitle' => 'Promoções'
])

@section('content')

    <div class="page page-promotions page-index">


        <div class="page-header">
            <h1>Promoções <small>Listagem de promoções</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            @if (Auth::user()->role != 2)

                <div class="page-controls mb-3">
                    <a href="{{ url('promotion/create') }}" class="btn btn-primary">Nova Promoção</a>
                </div>

            @endif

            @if (count($promotions) > 0)

                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Status</th>
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
                                <td>{{ $promotion->product->name }}</td>
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
