@extends('layouts.main', [
    'pageTitle' => 'Clientes'
])

@section('content')

    @php
        $isEdit = !empty($customer->id);
        $personData = $customer->person ?? $customer;
    @endphp

    <div class="page page-customer page-form">

        <div class="page-header">
            <h1><a href="/customers">Clientes</a> <small>{{ $customer->is_new ? 'Conclua seu cadastro' : ($isEdit ? 'Editar cliente' : 'Novo cliente') }}</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('customer') }}" method="POST">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                @if (!$isEdit)


                    <div class="form-check form-switch">
                        <input class="form-check-input switch" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="customer">
                        <label class="form-check-label label-switch" for="flexSwitchCheckChecked">Pessoa já criada</label>
                    </div>

                    <div class="form-group person">

                        <label for="person">Pessoa</label>
                        <select name="person_id" id="person" class="form-select" required required data-parsley-errors-container="#people-type-error" data-parsley-error-message="Pessoa necessária">

                            <option value="">Selecione uma pessoa</option>

                            @foreach ($people as $person)

                                <option value="{{ $person->id }}">{{ $person->name }}</option>

                            @endforeach

                        </select>
                        <div class="" id="people-type-error"></div>

                    </div>

                    <div class="d-none new-person">

                        @include('components.person-form')

                    </div>

                @else

                    <input type="hidden" name="id" value="{{ $customer->id }}">

                    <div class="form-group">

                        <label for="person">Pessoa</label>
                        <select name="person_id" id="person" class="form-select">

                            <option value="">Selecione uma pessoa</option>

                            @foreach ($people as $person)

                                <option value="{{ $person->id }}" {{ $person->id == $customer->person_id ? 'selected' : '' }}>{{ $person->name }}</option>

                            @endforeach

                        </select>

                    </div>

                @endif

                    <div class="page-controls">

                        <a href="{{ url('customers') }}" class="btn btn-outline-primary">Voltar</a>
                        <button type="submit" class="btn btn-success">Enviar</button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
