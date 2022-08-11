@extends('layouts.main')

@section('title', 'Estoque')

@section('content')
    <br>

    <div class="container">
        <h1>Estoque</h1>

        @if($errors->any())

            <h4>{{$errors->first()}}</h4>

        @elseif(session()->has('msg'))

            <h4>{{session()->get('msg')}}</h4>

        @endif


        @if (count($inventories) > 0)

            <a href="/create/inventory">Criar estoque</a>

            <table>

                <thead>

                    <tr>

                        <th>Id</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                @foreach ($inventories as $inventory)

                    <tbody>

                        <tr>

                            <td>{{$inventory->id}}</td>

                            <td>{{$inventory->product->name}}</td>

                            <td>{{$inventory->qty}}</td>

                            <td>
                                <a href="/delete/inventory/{{$inventory->id}}">Deletar</a>
                            </td>

                        </tr>

                    </tbody>

                @endforeach

            </table>

        @else

            <h2>Não possui nenhum estoque criado</h2>
            <p><a href="/create/inventory">Clique aqui</a> para criar um novo</p>

        @endif

    </div>

@endsection
