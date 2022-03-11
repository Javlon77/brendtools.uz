<div class="j-row ">

    <!--kim -->
    <div class="mb-3 input-width">
        <label for="type" class="form-label j-label">Kim </label>
        <select id="type" name="type" class="form-select" aria-label="Default select example">
            <option>Uy egasi</option>
            <option value="Kompaniya xodimi">Kompaniya xodimi</option>
            <option value="Usta">Usta</option>
            @if( old('type') !== NULL ) <option selected value="{{ old('type') ?? $client->type ?? '' }}">{{ old('type') ?? $client->type ?? '' }}</option> @endif
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <!-- kompaniya nomi -->
    <div id="company-wrapper" class="input-width disabled-div">
        <label for="company_code" class="form-label j-label">Kompaniya nomi <strong
                class="text-danger">*</strong></label>
        <div class="input-group">
            <select id="company_code" name="company_code" class="form-select " aria-label="Default select example"
                aria-describedby="button-addon2">
                <option selected value="{{ old('company_code') ?? $client->company_code ?? '' }}">
                    {{ old('company_code')=='' ? isset($client->company_code) ? $companies->keyBy('id')[$client->company_code]->company : '' : $companies->keyBy('id')[old('company_code')]->company ?? '' }}
                </option>
                @foreach($companies as $company)
                <option value="{{ $company['id'] }}">{{ $company['company'] }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="button" id="button-addon2" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">+ qo'shish</button>
        </div>
        <div class="invalid-feedback"></div>
    </div>
    <!-- Master turi -->
    <div id="master-wrapper" class="input-width disabled-div">
        <label for="master_code" class="form-label j-label">Usta turi <strong class="text-danger">*</strong></label>
        <div class="input-group">
            <select id="master_code" name="master_code" class="form-select " aria-label="Default select example">
                <option class="company-selected" selected value="{{old('master_code') ?? $client->master_code ?? '' }}">
                    {{ old('master_code')=='' ? isset($client->master_code) ? $masters->keyBy('id')[$client->master_code]->master : '' : $masters->keyBy('id')[old('master_code')]->master ?? '' }}
                </option>
                @foreach($masters as $master)
                <option value="{{ $master['id'] }}">{{ $master['master'] }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="button" id="button-addon2" data-bs-toggle="modal"
                data-bs-target="#add-master-type">+ qo'shish</button>
        </div>
        <div class="invalid-feedback"></div>
    </div>


    <!-- ismi -->
    <div class="mb-3 input-width">
        <label for="name" class="form-label j-label ">Ismi <strong class="text-danger">*</strong></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $client->name ?? '' }}">
        <div class="invalid-feedback"></div>

    </div>
    <!-- familyasi -->
    <div class="mb-3 input-width">
        <label for="surname" class="form-label j-label">Familiyasi</label>
        <input type="text" class="form-control" id="surname" name="surname"
            value="{{ old('surname') ?? $client->surname ?? ''}}">
        <div class="invalid-feedback"></div>
    </div>

    <!-- jinsi-->
    <div class="mb-3 input-width">
        <label for="gender" class="form-label j-label">Jinsi </label>
        <select id="gender" name="gender" class="form-select" aria-label="Default select example">
            <option value="Erkak">Erkak</option>
            <option value="Ayol">Ayol</option>
            @if (old('gender')==TRUE)
            <option selected value="{{ old('gender') ?? $client->gender ?? '' }}">
                {{ old('gender') ?? $client->gender ?? '' }}</option>
            @endif


        </select>
    </div>
    <!-- tug'ilgan sanasi -->
    <div class="mb-3 input-width">
        <label for="dateOfBirth" class="form-label j-label">Tu'gilgan sanasi</label>
        <input id="dateOfBirth" type="date" class="form-control" name="dateOfBirth"
            value="{{ old('dateOfBirth') ?? $client->dateOfBirth ?? ''}}">
        <div class="invalid-feedback"></div>
    </div>
    <!-- tel1 -->

    <div class="mb-3 input-width">
        <label for="phone1" class="form-label j-label">Telefon raqami <strong class="text-danger">*</strong></label>
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1">+998</span>
            <input type="text" class="form-control" id="phone1" name="phone1"
                value="{{ old('phone1') ?? $client->phone1 ?? '' }}" maxlength="9">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <!-- tel2 -->
    <div class="mb-3 input-width">
        <label for="phone2" class="form-label j-label">Qo'shimcha telefon raqami</label>
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1">+998</span>
            <input type="text" class="form-control" id="phone2" name="phone2"
                value="{{ old('phone2') ?? $client->phone2 ?? ''}}" maxlength="9">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <!-- region -->
    <div class="mb-3 input-width">
        <label for="region" class="form-label j-label">Viloyati</label>
        <select id="region" name="region" class="form-select" aria-label="Default select example">
            <option value="Toshkent shahri">Toshkent shahri</option>
            <option value="Toshkent viloyati">Toshkent viloyati</option>
            <option value="Namangan">Namangan</option>
            <option value="Farg'ona">Farg'ona</option>
            <option value="Andijon">Andijon</option>
            <option value="Sirdaryo">Sirdaryo</option>
            <option value="Jizzah">Jizzah</option>
            <option value="Samarqand">Samarqand</option>
            <option value="Qashqadaryo">Qashqadaryo</option>
            <option value="Surxondaryo">Surxondaryo</option>
            <option value="Navoiy">Navoiy</option>
            <option value="Buxoro">Buxoro</option>
            <option value="Xorazm">Xorazm</option>
            <option value="Qoraqalpog'iston">Qoraqalpog'iston</option>
            @if( old('region') !== NULL ) <option selected>{{ old('region') ?? $client->region ?? '' }}</option> @endif
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <!-- adress -->
    <div class="mb-3 input-width">
        <label for="address" class="form-label j-label">Manzili</label>
        <input type="text" class="form-control" id="address" name="address"
            value="{{ old('address') ?? $client->address ?? '' }}">
        <div class="invalid-feedback"></div>
    </div>
    <!-- klient haqida hulosa -->
    <div class="mb-3 input-width">
        <label for="address" class="form-label j-label">Mijoz haqidagi fikringiz</label>
        <textarea id="feedback" class="form-control" name="feedback" rows="1">{{ old('feedback') ?? $client->feedback ?? '' }}</textarea>
        <div class="invalid-feedback"></div>
    </div>
</div>




<!-- Modal add company-->
<div class="modal fade company-add-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Kompaniya nomini kiriting:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="addcompanyname" name="company" value="{{ old('company')}}">
                <div class="col-12 mt-3 company-message">
                    <div id="company-added-successfully" class="alert alert-success" role="alert" style="display:none">
                    </div>
                    <div id="company-added-error" class="alert alert-danger" role="alert" style="display:none"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Modalni yopish</button>
                <button id="addcompany" type="submit" class="btn btn-primary">Qo'shish</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal add company-->

<!-- Modal add_Master_type -->
<div class="modal fade company-add-modal" id="add-master-type" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="add-master-type-Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-master-type-Label">Usta turini kiriting:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="master-type" name="master" value="{{ old('master')}}">
                <div class="col-12 mt-3 company-message">
                    <div id="master-type-added-successfully" class="alert alert-success" role="alert"
                        style="display:none"></div>
                    <div id="master-type-added-error" class="alert alert-danger" role="alert" style="display:none">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Modalni yopish</button>
                <button id="add-master-type-to-base" type="submit" class="btn btn-primary">Qo'shish</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal add company-->