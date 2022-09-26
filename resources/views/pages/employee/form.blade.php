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
                        <input class="form-check-input switch" type="checkbox" role="switch" id="check" name="employee">
                        <label class="form-check-label label-switch" for="check">Pessoa já criada</label>
                    </div>

                    {{-- @dd($people[0]->employee) --}}
                    <div class="form-group person">

                        <label for="person">Pessoa</label>
                        <select name="person_id" id="person" class="form-control" required required data-parsley-errors-container="#people-type-error" data-parsley-error-message="Pessoa necessária">

                            <option value="">Selecione uma pessoa</option>

                            @foreach ($people as $person)

                                @if (!isset($person->employee))

                                    <option value="{{ $person->id }}">{{ $person->name }}</option>

                                @endif

                            @endforeach

                        </select>

                        <div class="" id="people-type-error"></div>
                    </div>

                    <div class="d-none new-person">

                        @include('components.person-form')

                    </div>

                @else

                    <input type="hidden" name="id" value="{{ $employee->id }}">

                    <div class="form-group">

                        <label for="person">Pessoa</label>
                        <select name="person_id" id="person" class="form-control">

                            <option value="">Selecione uma pessoa</option>

                            @foreach ($people as $person)

                                @if (!isset($person->employee) || $person->id == $employee->person_id)

                                    <option value="{{ $person->id }}" {{ $person->id == $employee->person_id ? 'selected' : '' }}>{{ $person->name }}</option>

                                @endif

                            @endforeach

                        </select>

                    </div>

                @endif

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Carteira de trabalho</label>
                            <input type="text" name="work_code" class="form-control work-code" required data-parsley-errors-container="#work-code-type-error" data-parsley-error-message="Carteira de trabalho necessário" value="{{ old('work_code', $employee->work_code) }}" required/>
                            <div id="work-code-type-error"></div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="role">Cargo</label>

                            <select class="form-control" name="role_id" required required data-parsley-errors-container="#role-type-error" data-parsley-error-message="Cargo necessário">

                                <option value="" selected>Selecione um cargo</option>

                                @foreach ($roles as $role)

                                    <option value="{{ $role->id }} {{ $employee->role_id == $role->id ? 'selected' : '' }}">{{ $role->name }}</option>

                                @endforeach

                                <div id="role-type-error"></div>
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
