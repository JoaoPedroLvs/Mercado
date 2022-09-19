<div class="form-group">

    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" class="form-control" required="" data-parsley-errors-container="#personData-type-error" data-parsley-error-message="Nome necessário" autofocus value="{{ old('name',$personData->name) }}">
        <div id="personData-type-error"></div>
    </div>

    <div class="row g-3">

        <div class="col-md-6">

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control cpf" required data-parsley-errors-container="#cpf-type-error" data-parsley-error-message="CPF necessário" required value="{{ old('cpf',$personData->cpf) }}">
                <div id="cpf-type-error"></div>
            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">
                <label for="rg">RG</label>
                <input type="text" name="rg" id="rg" class="form-control rg" maxlength="14" required data-parsley-errors-container="#rg-type-error" data-parsley-error-message="RG necessário" required value="{{ old('rg',$personData->rg) }}">
                <div id="cpf-type-error"></div>
            </div>

        </div>

    </div>

    <div class="row g-3">

        <div class="col-md-6">

            <div class="form-group">

                <label for="phone">Telefone</label>
                <input type="text" name="phone" id="phone" class="form-control phone" required data-parsley-errors-container="#phone-type-error" data-parsley-error-message="Telefone necessário" required value="{{ old('phone',$personData->phone) }}">
                <div id="phone-type-error"></div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">

                <label for="gender">Gênero</label>
                <select name="gender" id="gender" class="form-select" required required data-parsley-errors-container="#gender-type-error" data-parsley-error-message="Gênero necessário">
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
        <input type="text" name="address" id="address" required data-parsley-errors-container="#address-type-error" data-parsley-error-message="Endereço necessário" class="form-control" required value="{{ old('address',$personData->address) }}">
        <div id="address-type-error"></div>

    </div>

</div>
