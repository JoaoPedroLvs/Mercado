@extends('layouts.main',[
    'pageTitle' => 'Cargos'
])

@section('content')

    @php
        $isEdit = !empty($role->id)
    @endphp

    <div class="page page-role page-form">

        <div class="page-header">
            <h1>Cargos <small>{{ $isEdit ? 'Editar cargo' : 'Novo cargo' }}</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('employees/role') }}" method="post">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                <input type="hidden" name="id" value="{{ $role->id }}">

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name',$role->name) }}" required data-parsley-errors-container="#name-type-error" data-parsley-error-message="Nome necessário" required autofocus />
                    <div id="name-type-error"></div>
                </div>

                <a class="btn btn-outline-primary" href="{{ url('employees/roles') }}">Voltar</a>

                <button type="submit" class="btn btn-success">Enviar</button>

            </form>

        </div>

    </div>

@endsection
