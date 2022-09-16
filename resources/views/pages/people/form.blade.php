@extends('layouts.main',[
    'pageTitle' => 'Pessoas'
])

@section('content')

    @php
        $isEdit = !empty($person->id);
    @endphp

    <div class="page page-people page-form">

        <div class="page-header">
            <h1>Pessoa <small>{{ $isEdit ? 'Editar pessoa' : 'Criar pessoa' }}</small></h1>
        </div>

        <div class="page-body">

            @include('components.alert')

            <form action="{{ url('person') }}" method="post">

                @csrf

                @method($isEdit ? 'PUT' : 'POST')

                <input type="hidden" name="id" value="{{ $person->id }}">

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" name="name" id="name" class="form-control" required autofocus value="{{ old('name',$person->name) }}">
                </div>

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control cpf" required value="{{ old('cpf',$person->cpf) }}">
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="rg">RG</label>
                            <input type="text" name="rg" id="rg" class="form-control rg" maxlength="14" required value="{{ old('rg',$person->rg) }}">
                        </div>

                    </div>

                </div>

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="phone">Telefone</label>
                            <input type="text" name="phone" id="phone" class="form-control phone" required value="{{ old('phone',$person->phone) }}">

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="gender">Gênero</label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="">Selecione um gênero</option>
                                <option {{ $person->gender=='m' ? 'selected' : '' }} value="m">Masculino</option>
                                <option {{ $person->gender=='f' ? 'selected' : '' }} value="f">Feminino</option>
                                <option {{ $person->gender=='L' ? 'selected' : '' }} value="L">LGBTQIA+PLUS</option>
                            </select>

                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label for="address">Endereço</label>
                    <input type="text" name="address" id="address" class="form-control" required value="{{ old('address',$person->address) }}">

                </div>

                <div class="page-control">

                    @if (Session::has('customer'))

                        <a href="{{ url('customer/'.Auth::user()->customer_id.'/show') }}" class="btn btn-outline-primary">Voltar</a>

                    @else

                        <a href="{{ url('people') }}" class="btn btn-outline-primary">Voltar</a>

                    @endif

                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>
            </form>
        </div>

    </div>

@endsection
