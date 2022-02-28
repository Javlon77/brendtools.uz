@extends('layout')
@section('content')
@section('header-text', "Sotuv voronkasini yaratish")

<div class="container container-bg">

<form method="post" action="{{ route('funnel.store') }}">
    @csrf 
    <div class="j-row ">
            <!--mijoz -->
            <div class="mb-3 input-width">
                <label for="client_id" class="form-label j-label">Mijoz  <strong class="text-danger">*</strong></label>
                <div class="input-group">
                    <select class="form-control" id="client_id" name="client_id" value="" style="pointer-events: none;">
                        <option selected value="{{ old('client_id') }}">{{ old('client_id')!==NULL ? $clients->keyBy('id')[old('client_id')]->name : ''}}</option>
                    </select>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#choose-client-modal">Tanlash</button>
                </div>
                <div class="invalid-feedback client-id-error"></div>
            </div>    
            <!--status -->
            <div class="mb-3 input-width">
                <label for="status" class="form-label j-label"> Status <strong class="text-danger">*</strong></label>
                <select id="status"  name="status" class="form-select" aria-label="Default select example" >
                    <option selected value="Birinchi suhbat">Birinchi suhbat</option>
                    <option value="Ko'ndirish jarayoni">Ko'ndirish jarayoni</option>
                    <option value="Bitm tuzildi">Bitm tuzildi</option>
                    <option value="To'lov qilindi">To'lov qilindi</option>
                    <option value="Yakunlandi">Yakunlandi</option>
                    <option value="Qaytarib berildi">Qaytarib berildi</option>
                    @if(old('status'))
                        <option value="{{ old('status') }}" selected>{{ old('status') }}</option>
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>    
            <!-- qayerdan eshitdi -->
            <div class="mb-3 input-width">
                <label for="awareness" class="form-label j-label"> Xabardorlik <strong class="text-danger">*</strong></label>
                <select id="awareness"  name="awareness" class="form-select">
                    <option selected value="Google">Google</option>
                    <option value="Yandex">Yandex</option>
                    <option value="Telegram">Telegram</option>
                    <option value="Instagram">Instagram</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Reklama">Reklama</option>
                    <option value="Tanish-blish">Tanish-bilish</option>
                    <option value="Qayta-xarid">Qayta-xarid</option>
                    @if(old('awareness'))
                        <option value="{{ old('awareness') }}" selected>{{ old('awareness') }}</option>
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>  
            <!-- kerak bo'lgan mahsulot narxi -->
            <div class="mb-3 input-width">
                <label for="price" class="form-label j-label">Umumiy qiymat <strong class="text-success">*</strong></label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="price" name="price" style="text-align:right" value="{{ old('price') }}" autocomplete="off">
                    <span class="input-group-text" id="basic-addon2">So'm</span>
                </div>
                <div class="invalid-feedback"></div>
            </div>   
            <!-- kerak bo'lgan mahsulot -->
            <div class="mb-3 input-width">
                <label for="product" class="form-label j-label">Mahsulotlar</label>
                <textarea name="product" id="product" cols="30" rows="1" class="form-control" maxlength="1999">{{ old('product') }}</textarea>
                <div class="invalid-feedback"></div>
            </div>     
            <!-- Qo'shimcha -->
            <div class="mb-3 input-width">
                <label for="additional" class="form-label j-label"> Qo'shimchalar</label>
                <textarea name="additional" id="additional" cols="30" rows="1" class="form-control" maxlength="999">{{ old('additional') }}</textarea>
            </select>
            <div class="invalid-feedback"></div>
        </div>     
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button type="submit" class="btn btn-success px-3 py-2 mt-3">Yaratish</button>
    </div>
</form>

<!-- Modal -->
    <div class="modal fade" id="choose-client-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-dark">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title w-100" id="exampleModalLabel">Mijozni qidirish:</h5>
                <input type="text" class="form-control input-width mb-0" id="search-client" placeholder="Ism, familiya, telefon">
            
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
            <div class="table-responsive rounded">
                <table class="table" style="width:100%" id="c-table" data-page-length='25'>
                    <thead>
                        <tr>
                            <th>T/R</th>
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
    <!--  end of modal  -->
</div>
@endsection

@section('script')
    <script>
        jQuery(document).ready(function(){

            //input price separator
            $("#price").on('input keydown keyup mousedown mouseup select contextmenu drop' ,function(){
            if(this.value!==''){
                let a = $("#price").val().replace(/\s/g, '')
                let p = parseInt(a)
                function numberWithSpaces(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                    }
                if(isNaN(p)){
                    $("#price").val('')
                }
                 else{
                    $("#price").val(numberWithSpaces(p))
                }
            }
            });       

            //choose client
            $('#c-table').on('click','.choose-client', function() {
                let id = jQuery(this).attr('idx');
                let name= jQuery(this)[0].children[1].textContent;
                jQuery('#client_id').append('<option value="'+id+'" selected>'+name+'</option>');
                $('#choose-client-modal').modal('hide');
            });
            //search on keyup
            jQuery(document).on('keyup', '#search-client', function(e){
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let text =jQuery('#search-client').val();
                let token = $('meta[name=token]').attr('content');
                if(jQuery.trim(text)!==''){
                    if(jQuery.trim(text).length>2){
                        jQuery.ajax({
                            method: 'POST',
                            url: '/api/client',
                            headers:{
                                'Authorization':token 
                            },
                            dataType: 'json',
                            data: {
                                'search': text
                            },
                            success : function(response){
                                if(response[1].length!==0){
                                    let raw = '';
                                    jQuery('.add-client').html('');
                                    jQuery.each(response[1], function(index ,value){ 
                                        index=index+1;
                                        if(value.company_code==null){value.company_code='-'}else{  value.company_code = response[0].find(x => x.id === value.company_code).company };
                                        if(value.master_code==null){value.master_code='-'}else{  value.master_code = response[2].find(x => x.id === value.master_code).master };
                                        if(value.phone2==null){value.phone2='-'}
                                        if(value.address==null){value.address='-'}
                                        if(value.feedback==null){value.feedback='-'}
                                        if(value.surname == null) {value.surname = '-'}
                            
                                        raw = ' <tr class="choose-client" idx="'+value.id +'"><td>'+ index +'</td><td>'+ value.name+'</td><td>'+ value.surname+'</td><td>'+ value.type+'</td><td>'+ value.company_code+'</td><td>'+ value.master_code+'</td><td>'+ value.phone1+'</td><td>'+ value.phone2+'</td><td>'+ value.region+'</td><td>'+ value.address+'</td><td>'+ value.feedback+'</td> </tr>  '
                                        jQuery('.add-client').append(raw);
                                    });      
                                                
                                }
                                else{
                                    jQuery('.add-client').html('<tr class="text-uppercase" style="font-weight: bold;"><td>t</td><td>o</td><td>p</td><td>i</td><td>l</td><td>m</td><td>a</td><td>d</td><td>i</td></tr>');
                                }
                            }
                            
                        })          
                    }
                    else{
                        jQuery('.add-client').html('<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>');
                    }

                }
                else{
                    jQuery('.add-client').html('<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>');
                }
            }); 
            // END OF SEARCH KEYUP

                // show errors to input fields
            let client_id = "{{ $errors->first('client_id') }}";

                if(client_id!==''){
                    $('.client-id-error').append(client_id)
                    $('.client-id-error').show()
                    $('#client_id').addClass('is-invalid')
                }
            
        });

    </script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/>
<style>
    .choose-client{
        cursor:pointer;
    }
</style>
@endsection  