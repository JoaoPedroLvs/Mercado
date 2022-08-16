@extends('layouts.main')

@section('title', 'Promoções')

@section('content')

    <br>

    <div class="container">
        <h1>Promoções</h1>


        @if (session()->has('msg'))

        <h4>{{session()->get('msg')}}</h4>

        @endif

        @if (count($promotions) > 0)

            <a href="/create/promotion">Criar promoção</a>

            <br><br>

            <table>

                <thead>

                    <tr>

                        <th>Id</th>
                        <th>Preço</th>
                        <th>Produto</th>
                        <th>Data inicial</th>
                        <th>Data final</th>
                        <th>Estado</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                @foreach ($promotions as $promotion)

                    <tbody>

                        <tr>

                            <td>{{$promotion->id}}</td>
                            <td>{{number_format($promotion->price, 2, ',', ' ')}}</td>
                            <td>{{$promotion->product->name}}</td>
                            <td>{{$promotion->started_at->format('d/m/Y')}}</td>
                            <td>{{$promotion->ended_at->format('d/m/Y')}}</td>
                            <td>{{$promotion->is_active ? "Ativo" : "Inativo"}}</td>
                            <td>
                                <a href="/edit/promotion/{{$promotion->id}}">Editar</a>
                                <a href="/delete/promotion/{{$promotion->id}}">Deletar</a>
                            </td>

                        </tr>

                    </tbody>

                @endforeach

            </table>

        @else

            <h2>Nenhuma promoção criada</h2>
            <p><a href="/create/promotion">Clique aqui</a> para criar uma nova promoção</p>

        @endif
    </div>

@endsection
