<!-- payment -->
<div class="j-row payment" >
    <!-- payment_method -->
    <div class="mx-2" style="width:200px">
        <label for="" class="form-label j-label">To'lash usuli</label>
        <select name="payment_method" class="form-select" id="">
            <option value="completely">Birdaniga</option>
            <option value="monthly">Oyma-oy</option>
        </select>
    </div>
    <!-- payment -->
    <div class="mx-2" style="width:200px">
        <label for="" class="form-label j-label">To'lov</label>
        <select name="payment" class="form-select" id="">
            <option value="cash">Naqd pul</option>
            <option value="transfer">Pul o'tkazmasi</option>
        </select>
    </div>
</div>
<!-- customer details -->
<div class="j-row" style="justify-content: space-around">
    <!--mijoz -->
    <div class="mb-3 input-width">
        <label for="client_id" class="form-label j-label">Mijoz <strong class="text-danger">*</strong></label>
        <div class="input-group">
            <select class="form-control" id="client_id" name="client_id" value="" style="pointer-events: none;" required>
                <option selected value="{{ old('client_id') }}">{{ old('client_id')!==NULL ? $clients->keyBy('id')[old('client_id')]->name : ''}}</option>
            </select>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#choose-client-modal">Tanlash</button>
        </div>
        <div class="invalid-feedback client-id-error"></div>
    </div> 
    <!-- delivery_method -->
    <div class="mb-3 input-width">
        <label for="delivery_method" class="form-label j-label">Mahsulotni qabul qilish usuli <strong class="text-danger">*</strong></label>
        <div class="input-group">
            <select id="delivery_method"  name="delivery_method" class="form-select " aria-label="Default select example" aria-describedby="button-addon2">
                <option value="delivery">Yetkazib berish</option>
                <option value="pickup">Olib ketish</option>
            </select>
        </div>
        <div class="invalid-feedback"></div>            
    </div>
    <!-- delivery_price -->
    <div class="mb-3 input-width delivery-price">
        <label for="delivery_price" class="form-label">Yetkazib berish narxi <strong class="text-danger">*</strong></label>
        <div class="input-group mb-3">
            <input type="text" class="form-control seperator" id="delivery_price" name="delivery_price" style="text-align:right" value="" autocomplete="off" required >
            <span class="input-group-text" id="basic-addon2">So'm</span>
        </div>
        <div class="invalid-feedback"></div>
    </div> 
     <!-- client_delivery_payment -->
     <div class="mb-3 input-width delivery-price">
        <label for="client_delivery_payment" class="form-label">Mijoz yetkazib berishga bergan pul <strong class="text-warning">*</strong></label>
        <div class="input-group mb-3">
            <input type="text" class="form-control seperator" id="client_delivery_payment" name="client_delivery_payment" style="text-align:right" value="" autocomplete="off" >
            <span class="input-group-text" id="basic-addon2">So'm</span>
        </div>
        <div class="invalid-feedback"></div>
    </div>
    <!-- additional_cost -->
    <div class="mb-3 input-width">
        <label for="additional_cost" class="form-label">Qo'shimcha xarajatlar <strong class="text-warning">*</strong></label>
        <div class="input-group mb-3">
            <input type="text" class="form-control seperator" id="additional_cost" name="additional_cost" style="text-align:right" value="" autocomplete="off">
            <span class="input-group-text" id="basic-addon2">So'm</span>
        </div>
        <div class="invalid-feedback"></div>
    </div>
    <!-- Additional -->
    <div class="mb-3 input-width">
        <label for="additional" class="form-label j-label">Qo'shimchalar</label>
        <textarea id="additional" class="form-control" name="additional" maxlength="199" rows="1">{{ old('feedback') ?? $client->feedback ?? '' }}</textarea>
        <div class="invalid-feedback"></div>
    </div>
</div>
<!-- products -->
<div class="w-100 product-wrapper-scroll">
    <div class="j-row product-wrapper">
        <!-- Product -->
        <div class="input-width product-input">
            <label for="" class="form-label j-label">Mahsulot <strong class="text-danger">*</strong></label>
        </div> 
        <!-- quantity -->
        <div class="input-width product-input">
            <label for="quantity" class="form-label">Nechta<strong class="text-danger">*</strong></label>
        </div> 
        <!-- cost price -->
        <div class="input-width product-input">
            <label for="cost_price" class="form-label">Tushgan narx <strong class="text-danger">*</strong></label>
        </div> 
        <!-- selling price -->
        <div class="input-width product-input">
            <label for="selling_price" class="form-label">Sotilgan narx <strong class="text-danger">*</strong></label>
        </div> 
        <!-- for free space -->
        <div class="product-input">
        </div>
    </div>

    <div class="clone w-100">
        <div class="j-row product-wrapper mb-2">
            <!-- Product -->
            <div class=" input-width product-input">
                <div class="input-group">
                    <label for="product_id" class="form-control product_label" style="pointer-events: none;"></label>
                    <button type="button" class="btn btn-primary choose-product-modal" data-bs-toggle="modal" data-bs-target="#choose-product-modal">Tanlash</button>
                </div>
                <input type="text" name="product_id[]" value=""  class="product-hidden-input product_input" required>
                <div class="invalid-feedback client-id-error"></div>
            </div> 
            <!-- quantity -->
            <div class=" input-width product-input">
                <div class="input-group ">
                    <input type="number" class="form-control" name="quantity[]" style="text-align:right" value="{{ old('quantity')? : '1' }}" autocomplete="off" min="1" required> 
                    <span class="input-group-text" id="basic-addon2">Dona</span>
                </div>
                <div class="invalid-feedback"></div>
            </div>
            <!-- cost price -->
            <div class=" input-width product-input">
                <div class="input-group ">
                    <input type="text" class="form-control seperator" name="cost_price[]" style="text-align:right" value="" autocomplete="off" required>
                    <span class="input-group-text" id="basic-addon2">So'm</span>
                </div>
                <div class="invalid-feedback"></div>
            </div> 
            <!-- selling price -->
            <div class=" input-width product-input">
                <div class="input-group ">
                    <input type="text" class="form-control seperator" name="selling_price[]" style="text-align:right" value="" autocomplete="off" required>
                    <span class="input-group-text" id="basic-addon2">So'm</span>
                </div>
                <div class="invalid-feedback"></div>
            </div> 
            <!-- for free space -->
            <div class="product-input btn" style="background-color:#ffffff2e;">
            </div>
        </div>
        
    </div>

    <div class="add-product-wrapper j-row">
        <i class="bi bi-plus-square btn w-100 my-2 add-new-product-wrapper"></i>
    </div>
</div>


<!-- Modal Mijoz tanlash -->
<div class="modal fade" id="choose-client-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-dark">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title w-100" id="exampleModalLabel">Mijozni qidirish:</h5>
                <input type="text" class="form-control input-width mb-0" id="search-client" placeholder="Ism, familiya, telefon">
            </div>
            <div class="modal-body">
                <div class="table-responsive rounded">
                    <table class="table" id="client-table">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Ism</th>
                                <th>Familiya</th>
                                <th>Kim</th>
                                <th>Kompaniya</th>
                                <th>Usta</th>
                                <th>Telefon</th>
                                <th>Telefon 2</th>
                                <th>Viloyat</th>
                                <th>Manzil</th>
                                <th>fikr</th>
                            </tr>        
                        </thead>
                        <tbody class="add-client">
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
            </div>
        </div>
    </div>
</div>
<!--  end of modal mijoz qoshish -->

<!-- Modal mahsulot tanlash -->
<div class="modal fade" id="choose-product-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title w-100" id="exampleModalLabel">Mahsulotni qidirish:</h5>
                <input type="text" class="form-control input-width mb-0" id="search-product" placeholder="Mahsulot">
            </div>
            <div class="modal-body">
                <div class="table-responsive rounded">
                    <table class="table" style="width:100%" id="product-table">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Mahsulot</th>
                                <th>Brend</th>
                                <th>Kategorya</th>
                            </tr>        
                        </thead>
                        <tbody class="add-product">
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
            </div>
        </div>
    </div>
</div>
<!--  end of modal mahsulot tanlash -->
    

    


   