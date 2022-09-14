<div class="form-group">

    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" class="form-control" autofocus value="{{ old('name',$personData->name) }}">
    </div>

    <div class="row g-3">

        <div class="col-md-6">

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control cpf" value="{{ old('cpf',$personData->cpf) }}">
            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">
                <label for="rg">RG</label>
                <input type="text" name="rg" id="rg" class="form-control rg" maxlength="14" value="{{ old('rg',$personData->rg) }}">
            </div>

        </div>

    </div>

    <div class="row g-3">

        <div class="col-md-6">

            <div class="form-group">

                <label for="phone">Telefone</label>
                <input type="text" name="phone" id="phone" class="form-control phone" value="{{ old('phone',$personData->phone) }}">

            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">

                <label for="gender">Gênero</label>
                <select name="gender" id="gender" class="form-select">
                    <option value="">Selecione um gênero</option>
                    <option {{ $personData->gender=='m' ? 'selected' : '' }} value="m">Masculino</option>
                    <option {{ $personData->gender=='f' ? 'selected' : '' }} value="f">Feminino</option>
                    <option {{ $personData->gender=='L' ? 'selected' : '' }} value="L">LGBTQIA+PLUS</option>
                </select>

            </div>

        </div>

    </div>

    <div class="form-group">

        <label for="address">Endereço</label>
        <input type="text" name="address" id="address" class="form-control" value="{{ old('address',$personData->address) }}">

    </div>

</div>
