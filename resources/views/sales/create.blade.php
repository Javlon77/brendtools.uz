@extends('layout')
@section('title', "Sotuv qo'shish")
@section('header-text', "Sotuv qo'shish")
@section('content')
<div class="container container-bg">
@if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
    <form method="post" action="{{ route('sales.store') }}">
        @csrf
        @include('sales.form')
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-success px-3 py-2 mt-3">Qo'shish</button>
        </div>
    </form>
</div>

@endsection
@section('script')
<script>
jQuery(document).ready(function() {
    let brands = { @foreach($brands as $brand)  {{ $brand->id }} : "{{ $brand->brand }}" , @endforeach }
    let categories = { @foreach($categories as $category)  {{ $category->id }} : "{{ $category->category }}" , @endforeach }
    //choose client
    $('#client-table').on('click', '.choose-client', function() {
        let id = jQuery(this).attr('idx');
        let name = jQuery(this)[0].children[1].textContent;
        jQuery('#client_id').append('<option value="' + id + '" selected>' + name + '</option>');
        $('#choose-client-modal').modal('hide');
    });
    //search client
    jQuery(document).on('input', '#search-client', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let text = jQuery('#search-client').val();
        let token = $('meta[name=token]').attr('content');
        if (jQuery.trim(text) !== '') {
            if (jQuery.trim(text).length > 2) {
                jQuery.ajax({
                    method: 'POST',
                    url: '/api/client',
                    headers: {
                        'Authorization': token
                    },
                    dataType: 'json',
                    data: {
                        'search': text
                    },
                    success: function(response) {
                        if (response[1].length !== 0) {
                            let raw = '';
                            jQuery('.add-client').html('');
                            jQuery.each(response[1], function(index, value) {
                                index = index + 1;
                                if (value.company_code == null) {
                                    value.company_code = '-'
                                } else {
                                    value.company_code = response[0].find(x => x
                                        .id === value.company_code).company
                                };
                                if (value.master_code == null) {
                                    value.master_code = '-'
                                } else {
                                    value.master_code = response[2].find(x => x
                                        .id === value.master_code).master
                                };
                                if (value.phone2 == null) {
                                    value.phone2 = '-'
                                }
                                if (value.address == null) {
                                    value.address = '-'
                                }
                                if (value.feedback == null) {
                                    value.feedback = '-'
                                }
                                raw = ' <tr class="choose-client" idx="' + value
                                    .id + '"><td>' + index + '</td><td>' + value
                                    .name + '</td><td>' + value.surname +
                                    '</td><td>' + value.type + '</td><td>' + value
                                    .company_code + '</td><td>' + value
                                    .master_code + '</td><td>' + value.phone1 +
                                    '</td><td>' + value.phone2 + '</td><td>' + value
                                    .region + '</td><td>' + value.address +
                                    '</td><td>' + value.feedback + '</td> </tr>  '
                                jQuery('.add-client').append(raw);
                            });

                        } else {
                            jQuery('.add-client').html(
                                '<tr class="text-uppercase" style="font-weight: bold;"><td>t</td><td>o</td><td>p</td><td>i</td><td>l</td><td>m</td><td>a</td><td>d</td><td>i</td></tr>'
                            );
                        }
                    }

                })
            } else {
                jQuery('.add-client').html(
                    '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
                );
            }

        } else {
            jQuery('.add-client').html(
                '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
            );
        }
    });
    // END OF SEARCH CLIENT

    //choose product
    let productLabel
    let productInput
    $('#product-table').on('click', '.choose-product', function() {
        let id = jQuery(this).attr('idx');
        let product = jQuery(this)[0].children[1].textContent;
        productLabel.text(product);
        productInput.val(id);
        $('#choose-product-modal').modal('hide');
    });
    //search product
    $('body').on('click', '.choose-product-modal', function() {

        productLabel = $(this).closest('.clone').find('.product_label')
        productInput = $(this).closest('.clone').find('.product_input')

    })
    jQuery(document).on('input', '#search-product', function(e) {
        e.preventDefault();
        let text = jQuery('#search-product').val();
        let token = $('meta[name=token]').attr('content');
        if (jQuery.trim(text) !== '') {
            if (jQuery.trim(text).length > 2) {
                jQuery.ajax({
                    method: 'POST',
                    url: '/api/product',
                    headers: {
                        'Authorization': token
                    },
                    dataType: 'json',
                    data: {
                        'search': text
                    },
                    success: function(response) {
                        if (response.length !== 0) {
                            let raw = '';
                            jQuery('.add-product').html('');
                            jQuery.each(response, function(index, value) {
                                index = index + 1;
                                raw = ' <tr class="choose-product" idx="' + value
                                    .id + '"><td>' + index + '</td><td>' + value
                                    .product + '</td> <td>' + brands[value
                                        .brand_id] + '</td> <td>' + categories[value
                                        .category_id] + '</td></tr>  '
                                jQuery('.add-product').append(raw);
                            });
                        } else {
                            jQuery('.add-product').html(
                                '<tr class="text-uppercase" style="font-weight: bold;"><td>-</td><td>TOPILMADI</td></tr>'
                            );
                        }
                    }

                })
            } else {
                jQuery('.add-product').html('<tr><td>-</td><td>-</td></tr>');
            }

        } else {
            jQuery('.add-product').html('<tr><td>-</td><td>-</td></tr>');
        }
    });
    // END OF SEARCH product

    //input price separator
    function numberWithSpaces(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }
    $("body").on('input', '.seperator', function(e) {
        if (this.value !== '') {
            let a = $(this).val().replace(/\s/g, '')
            let p = parseInt(a)
            if (isNaN(p)) {
                $(this).val('')
            } else {
                $(this).val(numberWithSpaces(p))
            }
        }
    });

    //enable - disable delivery price
    $('#delivery_method').on('change', function() {
        if ($('#delivery_method').val() == 'pickup') {
            $('#delivery_price').val('')
            $('#client_delivery_payment').val('')
            $('.delivery-price').addClass('disabled-div')
            $("#delivery_price").prop('required', false);
        } else {
            $('.delivery-price').removeClass('disabled-div')
            $("#delivery_price").prop('required', true)
        }
    });

    //add new product wrapper

    $('.add-new-product-wrapper').on('click', function() {
        $('.add-product-wrapper').before(`
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
                                <input type="number" class="form-control" name="quantity[]" style="text-align:right" value="1" autocomplete="off" min="1" required> 
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
                        <div class="product-input">
                            <i class="bi bi-x-square btn btn-danger w-100 delete-new-product-wrapper"></i>
                        </div> 
                    </div>
                    </div>
                `)
    });
    // delete-new-product-wrapper
    $('body').on('click', '.delete-new-product-wrapper', function() {
        $(this).closest('.clone').remove()
    })

});
</script>
@endsection

@section('css')
<style>
.add-product-wrapper {
    min-width: 1000px;
}

.payment {
    padding-bottom: 20px;
    margin-bottom: 14px;
    justify-content: start !important;
    border-bottom: 1px solid #ffffff6b;
}

.add-new-product-wrapper {
    background-color: #ffffff2e;
    color: white
}

.add-new-product-wrapper:hover {
    background-color: #ffffff52;
    color: white
}

.product-hidden-input {
    width: 100%;
    height: 0px;
    padding: 0;
    border: 1px solid transparent;
    display: block;
    background-color: transparent;
}

.product-hidden-input:focus-visible {
    outline-width: 0;
}

.product-wrapper-scroll::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.product-wrapper-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 5px;
}

.product-wrapper-scroll::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 5px;
}

.product-wrapper-scroll::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.product-wrapper-scroll {
    overflow-x: auto;
    border-top: 1px solid #ffffff6b;
    padding-top: 1.5rem;
}

.product-wrapper {
    min-width: 1000px;
}

.product-input:nth-child(1) {
    width: 48%;
}

.product-input:nth-child(2) {
    width: 12%;
}

.product-input:nth-child(3) {
    width: 17%;
}

.product-input:nth-child(4) {
    width: 17%;
}

.product-input:nth-child(5) {
    width: 4%;
}

.choose-client {
    cursor: pointer;
}

.choose-product {
    cursor: pointer;
}

#check {
    width: 85px;
    height: 35px;
    margin-top: 0;
}

.modal-content {
    border: none;
}

#search-product {
    border: 1px solid;
    border-bottom: 1px solid;
    border-radius: 5px;
    box-shadow: 3px 2px #2a2a2a26;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}
</style>
@endsection