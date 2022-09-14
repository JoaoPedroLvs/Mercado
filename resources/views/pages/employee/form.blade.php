@extends('layouts.main', [
    'pageTitle' => 'Funcionários'
])

@section('content')

    @php
        $isEdit = !empty($employee->id);
        $personData = $employee->person ?? $employee;
    @endphp

    <div class="page page-employee page-form">

        <div class="page-header">
            <h1>Funcionários <small>{{ $isEdit ? 'Editar funcionário' : 'Novo funcionário' }}</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('employee') }}" method="POST">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                @if (!$isEdit)

                    <div class="form-check form-switch">
                        <input class="form-check-input switch" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="checkbox">
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

                    <input type="hidden" name="id" value="{{ $employee->id }}">

                    <div class="form-group">

                        <label for="person">Pessoa</label>
                        <select name="person_id" id="person" class="form-select">

                            <option value="">Selecione uma pessoa</option>

                            @foreach ($people as $person)

                                <option value="{{ $person->id }}" {{ $person->id == $employee->person_id ? 'selected' : '' }}>{{ $person->name }}</option>

                            @endforeach

                        </select>

                    </div>

                @endif

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Carteira de trabalho</label>
                            <input type="text" name="work_code" class="form-control work-code" value="{{ old('work_code', $employee->work_code) }}" required/>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="role">Cargo</label>

                            <select class="form-select" name="role_id">

                                <option value="" selected>Selecione um cargo</option>

                                @foreach ($roles as $role)

                                    <option value="{{ $role->id }} {{ $employee->role_id == $role->id ? 'selected' : '' }}">{{ $role->name }}</option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>

                <div class="page-controls">

                    @if (Session::get('employee'))

                        <a href="{{ url('employee/'. $employee->id. '/show') }}" class="btn btn-outline-primary">Voltar</a>

                    @else

                        <a class="btn btn-outline-primary" href="{{ url('employees') }}">Voltar</a>

                    @endif

                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>

            </form>

        </div>

    </div>

@endsection
