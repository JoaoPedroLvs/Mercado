@extends('layouts.main')

@section('title', 'Vendas')

@section('content')

    <div class="container">

        <h1>Vendas</h1>

        @if(session()->has('msg'))

            <h4>{{session()->get('msg')}}</h4>

        @endif

        @if ( count($sales) > 0 )

            <a href="/new/sale">Criar nova venda</a>

            <table>

                <thead>

                    <tr>

                        <th>Id</th>
                        <th>Valor</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                @foreach ($sales as $sale)

                    <tbody>

                        <tr>

                            <td>{{$sale->id}}</td>
                            <td>{{$sale->total}}</td>
                            <td>
                                <a href="/sale/{{$sale->id}}/products">Detalhes</a>
                                <a href="/delete/sale/{{$sale->id}}">Deletar</a>
                            </td>

                        </tr>

                    </tbody>

                @endforeach

            </table>

        @else

            <h2>Nenhuma venda criada</h2>

            <p><a href="/new/sale">Clique aqui </a>para criar uma nova</p>

        @endif

    </div>

@endsection
