        <!-- success message -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif  
        <!-- hasInSite -->
        <div class="mb-3" style="width:100%">
            <label for="hasInSite" class="form-label">Mahsulot Brandtools.uz saytida mavjudmi? <strong class="text-danger">*</strong></label>
            <div class="" style="width:150px">
                <select name="hasInSite" id="hasInSite" class="form-select">
                    <option value="1">Mavjud</option>   
                    <option value="0">Mavjud emas</option>
                    @if(old('hasInSite')==1)
                        <option selected value="1">Mavjud</option>               
                    @elseif(old('hasInSite')!==NULL && old('hasInSite')==0)
                        <option selected value="0">Mavjud emas</option>               
                    
                    @elseif(isset($product->hasInSite))
                        @if($product->hasInSite==1)
                            <option selected value="1">Mavjud</option>   
                        @else
                            <option selected value="0">Mavjud emas</option>
                        @endif
                    @endif
                </select>
            </div>
        </div>

        <div class="j-row">
            <!-- category-->         
            <div class="input-width">
                <label for="category_id" class="form-label j-label">Kategorya <strong class="text-danger">*</strong></label>
                <div class="input-group">
                    <select id="category_id"  name="category_id" class="form-select @error('category_id') is-invalid @enderror" aria-label="Default select example" aria-describedby="button-addon2">
                        <option selected value="{{ old('category_id') ?? $product['category_id'] ?? '' }}">{{old('category_id')=='' ? isset($product)? $categories->keyBy('id')[$product['category_id']]->category : '' : $categories->keyBy('id')[old('category_id')]->category ?? ''  }}</option>
                        @foreach($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['category'] }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#add-category-modal">+ qo'shish</button>
                </div>
                @error('category_id')
                <div class="invalid-feedback" style="display:block">{{ $message }}</div>  
                @enderror    
            </div>
            <!-- Brend-->
            <div class="input-width">
                <label for="brand_id" class="form-label j-label">Brend <strong class="text-danger">*</strong></label>
                <div class="input-group">
                    <select id="brand_id"  name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" aria-label="Default select example" aria-describedby="button-addon2">
                        <option selected value="{{ old('brand_id') ?? $product['brand_id'] ?? '' }}">{{old('brand_id')=='' ? isset($product)? $brands->keyBy('id')[$product['brand_id']]->brand : '' : $brands->keyBy('id')[old('brand_id')]->brand ?? ''  }}</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand['id'] }}">{{ $brand['brand'] }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#add-brand-modal">+ qo'shish</button>
                </div>
                @error('brand_id')
                    <div class="invalid-feedback" style="display:block">{{ $message }}</div>  
                @enderror         
            </div>
            <!-- Product -->
            <div class="mb-3 input-width">
                <label for="product" class="form-label j-label">Mahsulot nomi <strong class="text-danger">*</strong></label>
                <div class="input-group">
                    <textarea name="product" id="" rows="2" class="form-control @error('product') is-invalid @enderror" id="product">{{ old('product') ?? $product->product ?? ''}}</textarea>
                </div>
                @error('product')
                    <div class="invalid-feedback" style="display:block">{{ $message }}</div>  
                @enderror  
            </div> 
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-success px-3 py-2 mt-3">Qo'shish</button>
        </div>

     <!-- Modal add category-->
     <div class="modal fade" id="add-category-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Kategorya nomini kiriting:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>       
                <div class="modal-body">
                    <input type="text" class="form-control" id="category_input" name="category_input" value="">
                    <div class="col-12 mt-3 company-message">
                        <div id="category-success" class="alert alert-success" role="alert" style="display:none"></div>
                        <div id="category-error" class="alert alert-danger" role="alert" style="display:none"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Modalni yopish</button>
                    <button id="add-category" type="submit" class="btn btn-primary">Qo'shish</button>                            
                </div>                         
            </div>
        </div>
    </div>
    <!-- End of Modal add category-->

    <!-- Modal add brand-->
    <div class="modal fade" id="add-brand-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Brend nomini kiriting:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>       
                <div class="modal-body">
                    <input type="text" class="form-control" id="brand_input" name="brand_input" value="{{ old('brand_input')}}">
                    <div class="col-12 mt-3 company-message">
                        <div id="brand-success" class="alert alert-success" role="alert" style="display:none"></div>
                        <div id="brand-error" class="alert alert-danger" role="alert" style="display:none"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Modalni yopish</button>
                    <button id="add-brand" type="submit" class="btn btn-primary">Qo'shish</button>                            
                </div>                         
            </div>
        </div>
    </div>
    <!-- End of Modal add brand-->