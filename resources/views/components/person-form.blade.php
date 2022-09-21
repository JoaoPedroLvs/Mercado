<div class="form-group">

    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" name="name" disabled="disabled" id="name" class="form-control" data-parsley-errors-container="#personData-type-error" data-parsley-error-message="Nome necessário" autofocus value="{{ old('name',$personData->name) }}">
        <div id="personData-type-error"></div>
    </div>

    <div class="row g-3">

        <div class="col-md-6">

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" disabled="disabled" id="cpf" class="form-control cpf" data-parsley-errors-container="#cpf-type-error" data-parsley-error-message="CPF necessário" value="{{ old('cpf',$personData->cpf) }}">
                <div id="cpf-type-error"></div>
            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">
                <label for="rg">RG</label>
                <input type="text" name="rg" disabled="disabled" id="rg" class="form-control rg" maxlength="14" data-parsley-errors-container="#rg-type-error" data-parsley-error-message="RG necessário" value="{{ old('rg',$personData->rg) }}">
                <div id="cpf-type-error"></div>
            </div>

        </div>

    </div>

    <div class="row g-3">

        <div class="col-md-6">

            <div class="form-group">

                <label for="phone">Telefone</label>
                <input type="text" name="phone" disabled="disabled" id="phone" class="form-control phone" data-parsley-errors-container="#phone-type-error" data-parsley-error-message="Telefone necessário" value="{{ old('phone',$personData->phone) }}">
                <div id="phone-type-error"></div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">

                <label for="gender">Gênero</label>
                <select name="gender" id="gender" disabled="disabled" class="form-control" data-parsley-errors-container="#gender-type-error" data-parsley-error-message="Gênero necessário">
                    <option value="">Selecione um gênero</option>
                    <option {{ $personData->gender=='m' ? 'selected' : '' }} value="m">Masculino</option>
                    <option {{ $personData->gender=='f' ? 'selected' : '' }} value="f">Feminino</option>
                    <option {{ $personData->gender=='L' ? 'selected' : '' }} value="L">LGBTQIA+PLUS</option>
                </select>
                <div id="gender-type-error"></div>
            </div>

        </div>

    </div>

    <div class="form-group">

        <label for="address">Endereço</label>
        <input type="text" name="address" id="address" disabled="disabled" data-parsley-errors-container="#address-type-error" data-parsley-error-message="Endereço necessário" class="form-control" value="{{ old('address',$personData->address) }}">
        <div id="address-type-error"></div>

    </div>

</div>
