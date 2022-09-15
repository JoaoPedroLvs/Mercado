@extends('layouts.main',[
    'pageTitle' => 'Admistração'
])


@section('content')
    @php
        $isEdit = !empty($manager->id);
        $personData = $manager->person ?? $manager;
    @endphp

    <div class="page page-admin page-form">


        <div class="page-header">
            <h1>Administração <small>{{$isEdit ? 'Editando' : 'Criando'}} um administrador</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('admin') }}" method="POST">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                @if (!$isEdit)


                    <div class="form-check form-switch">
                        <input class="form-check-input switch" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="manager">
                        <label class="form-check-label label-switch" for="flexSwitchCheckChecked">Pessoa já criada</label>
                    </div>

                    <div class="form-group person">

                        <label for="person">Pessoa</label>
                        <select name="person_id" id="person" class="form-select">

                            <option value="">Selecione uma pessoa</option>

                            @foreach ($people as $person)

                                <option value="{{ $person->id }}">{{ $person->name }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="d-none new-person">

                        @include('components.person-form')

                    </div>

                @else

                    <input type="hidden" name="id" value="{{ $manager->id }}">

                    <div class="form-group">

                        <label for="person">Pessoa</label>
                        <select name="person_id" id="person" class="form-select">

                            <option value="">Selecione uma pessoa</option>

                            @foreach ($people as $person)

                                <option value="{{ $person->id }}" {{ $person->id == $manager->person_id ? 'selected' : '' }}>{{ $person->name }}</option>

                            @endforeach

                        </select>

                    </div>

                @endif

                <div class="page-controls">

                    <a href="{{ url('admins') }}" class="btn btn-outline-primary">Voltar</a>
                    <button type="submit" class="btn btn-success">Enviar</button>

                </div>

            </form>

        </div>

    </div>

@endsection

