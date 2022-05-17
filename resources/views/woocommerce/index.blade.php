@extends('layout')
@section('title', "Woocommerce price manager")
@section('header-text', "Woocommerce price manager")
@section('content')
<div class="container">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    {{-- data inform accordion --}}
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Вы должны знать!
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                Эта программа была сделана для изменения цен и так далее на сайте электронной коммерции. Вызывает только товары типа "публикация" из базы данных. типы «черновик, ожидание, частный» исключаются. Это можно сделать позже, если возникнет необходимость. Вы также можете добавить другие функции. 
                <br>
                1. Максимальное значение для списка продуктов — 100, поэтому некоторые значения могут быть распроделины по  страницам. Не забудьте разбить на страницы!
                <br>
                2. Только переключенные строки изменяються, если вы не хотите редактировать некоторые строки, вы можете оставить их выключенными.
                <br>
                3. Звоните по номеру (+998) 97 155 9007 для получения дополнительной информации!
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              Ключи!
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                1. Все измененные значения окрашены
                <br>
                2. Для обычной цены пустые значения не принимаются
                <br>
                3. Если вы не хотите делать скидку, оставьте поле пустым (значение 0 означает, что товар полностью бесплатный)
                <br>
                4. Щелкнув правой кнопкой мыши, вы можете вернуть исходное значение
                <br>
                5. Средним щелчком мыши вы можете очистить значение
                <br>
                6. Заголовки (Цена, цена в скидке, скидка от, скидка до) таблицы кликабельны, кроме названия продуктов, чтобы отредактировать значение всех столбцов.
                <br>
                7. Щелкнув левой кнопкой мыши по заголовку, вы можете открыть модальное окно для изменения значений всех столбцов.
                <br>
                8. Щелкнув правой кнопкой мыши по заголовку, вы можете вернуть исходные значения всех областей этого столбца.
                <br>
                9. Щелкнув средней кнопкой мыши по заголовку, вы можете сделать все значения областей в этом столбце пустыми.
                <br>
                10. Нажав кнопку переключения на заголовке, вы можете включить или выключить все строки
                <br>
                11. Вы можете сохранить только некоторые данные, включив только строки, которые должны быть изменены
                <br>
                12. Вы можете перейти к продукту, нажав на изображение
            </div>
          </div>
        </div>
      </div>
      {{-- end of data inform accordion --}}
    <form action="" class="filter-form">
        <h5 class="mt-4">Фильтры:</h5>
        <div class="input-group-wrapper">
            {{--  brands  --}}
            <div class="inputs">
                <label for="brand" class="form-label">Бренды</label>
                <select name="brand" id="brand" class="form-select">
                    <option value="">Все</option>
                    @foreach ($brands as $brand)
                        @if($filter_brand == $brand->id)
                        <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                        @else
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            {{-- categories --}}
            <div class="inputs">
                <label for="category" class="form-label">Категории</label>
                <select name="category" id="category" class="form-select">
                    <option value="">Все</option>
                    @foreach ($categories as $category)
                        @if($filter_category == $category->id)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            {{--  min_price  --}}
            <div class="inputs">
                <label for="brand" class="form-label">Минимальная цена ($)</label>
                <input type="text" class="form-control money" name="min_price" value="{{ $min_price }}">
            </div>
            {{--  min_price  --}}
            <div class="inputs">
                <label for="brand" class="form-label">максимальная цена ($)</label>
                <input type="text" class="form-control money" name="max_price" value="{{ $max_price }}">
            </div>
        </div>
        {{-- on_sale --}}
        <div class="inputs mt-2">
            <label for="category" class="form-label">В скидке</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="on_sale" style="width: 61px!important;height: 25px!important;margin: 0;" @if($on_sale == 'on') checked @endif>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary ml-3">Фильтр</button>

    </form>
    <br>
    <br>
    <h5>Результаты:</h5>
    <p style="margin-bottom: 0px;">Всего товаров: {{ $product_count }}</p>
    {{-- pagination  --}}
    <div class="pager-wrapper">
        <p style="margin-bottom: 5px;">Страница {{ $page_number }} из {{ $page_count }} </p>
        <div class="input-group w-auto">
                <a href="{{ $prev }}" class="btn btn-secondary prev-btn paginate-btn @if($page_number < 2) disabled-div @endif"><</a>
                <input type="text" name="page" min="1" max="{{ $page_count }}" value="{{ $page_number }}" class="page-input">
                <a href="{{ $next }}" class="btn btn-secondary next-btn paginate-btn @if($page_number >= $page_count) disabled-div @endif">></a>
            </div>
    </div>

    {{-- update --}}
    <form action="{{ route('woocommerce.store') }}" method="post" class="mb-5">
        @csrf
        <div class="w-100 d-flex justify-content-end">
            <button type="submit" class="btn btn-success my-2 w-auto disabled-div" id="save-btn">Сохранить выделенные строки</button>
        </div>
        <table class="table table-white bg-white" style="width:100%;" id="table" data-page-length="100">
            <thead>
                <tr>
                    <th style="width: 10px">№</th>
                    <th style="width: 10px">Продукт</th>
                    <th>Название товара</th>
                    <th mission="change-all" change-all="regular_price" style="width:100px" class="change-hover change-price" price="regular_price">Цена ($)</th>
                    <th mission="change-all" change-all="on_sale_price" style="width:100px" class="change-hover change-price" price="sale_price">в скидке ($)</th>
                    <th mission="change-all" change-all="date_from" style="width:70px" date="from" task="change-date-all" class="change-hover">Скидка от</th>
                    <th mission="change-all" change-all="date_to" style="width:70px" date="to" task="change-date-all" class="change-hover">Скидка до</th>
                    <th style="width: 50px">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="checkAll">
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr style="vertical-align: middle;">
                        <td>{{ (($page_number-1)*100) + ($loop->index+1) }}.</td>
                        <td>
                            <a href="{{ $product->permalink }}">
                                <img src="{{ $product->images[0]->src }}" alt="#" class="img-fluid rounded">
                            </a>
                        </td>
                        <td><input task="change" fix-value="{{ $product->name }}" class="form-control" type="text" name="name_{{ $product->id }}" value="{{ $product->name }}"></td>
                        <td><input change-all="regular_price" price="regular_price" task="change" fix-value="{{ $product->regular_price }}" class="form-control money" type="text" name="regular_price_{{ $product->id }}" value="{{ $product->regular_price }}"></td>
                        <td><input change-all="on_sale_price" price="sale_price" task="change" fix-value="{{ $product->sale_price }}" class="form-control money" type="text" name="sale_price_{{ $product->id }}" value="{{ $product->sale_price }}"></td>
                        <td><input change-all="date_from" task="change" fix-date="from" fix-value="{{ $product->date_on_sale_from !== null ? date_format( date_create($product->date_on_sale_from), 'Y-m-d') : '' }}" class="form-control" type="date" name="date_on_sale_from_{{ $product->id }}" value="{{ $product->date_on_sale_from !== null ? date_format( date_create($product->date_on_sale_from), 'Y-m-d') : '' }}"></td>
                        <td><input change-all="date_to" task="change" fix-date="to" fix-value="{{ $product->date_on_sale_to !== null ? date_format( date_create($product->date_on_sale_to), 'Y-m-d') : '' }}" class="form-control" type="date" name="date_on_sale_to_{{ $product->id }}" value="{{ $product->date_on_sale_to !== null ? date_format( date_create($product->date_on_sale_to), 'Y-m-d') : '' }}"></td> 
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input check" type="checkbox" role="switch" name="update[]" value="{{ $product->id }}">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</div>


    <!-- sale From modal -->
    <div class="modal fade" id="saleDate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="saleDateLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saleDateLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="date" class="form-control" id="sale-date">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрывать</button>
                    <button type="button" class="btn btn-primary" id="sale-date-confirm">Применять</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Price change modal -->
    <div class="modal fade" id="priceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="priceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="priceModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-9">
                            <label for="">Метод:</label>
                            <select name="" id="percentage_method" class="form-select w-100">
                                <option value="+percentage">Увеличение в процентах +%</option>
                                <option value="-percentage">Уменьшение в процентах -%</option>
                                <option value="+amount">Увеличение на определенную сумму ($)</option>
                                <option value="-amount">Уменьшение на определенную сумму ($)</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="">Значение:</label>
                            <input type="text" class="form-control money percent" id="percentage">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрывать</button>
                    <button type="button" class="btn btn-primary" id="price-confirm">Применять</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
    <style>
        .form-switch .form-check-input{
            width: 100%!important;
            height: 20px!important;
            margin-left: 0!important;
        }
        .form-switch {
            padding-left: 0!important;
        }
        .check:checked {
            background-color: #36c917!important;
            border-color: #36c917!important;
        }
        .checked-tr{
            background: #c5d4ef!important
        }
        .checked-tr:hover{
            background-color: #c5d4ef!important
        }
        .changed-input{
            background: #7794ff4a
        }
        .changed-input:focus{
            background: #7794ff4a
        }
        .form-select{
            width: auto;
        }
        .inputs{
            margin-right: 15px;
        }
        .input-group-wrapper{
            display: flex;
            width: 100%;
        }
        .filter-form{
            display: flex;
            align-items: flex-end;
            flex-wrap: wrap;
            width: 100%;
        }
        .pager-wrapper{
            display: flex!important;
            flex-wrap: wrap;
            flex-direction: column;
            align-content: flex-end;
            align-items: flex-end;
        }
        .page-input{
            border: none;
            pointer-events: none;
            width: 40px;
            text-align: center;
            user-select: none; /* supported by Chrome and Opera */
            -webkit-user-select: none; /* Safari */
            -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
        }
        .paginate-btn{
            font-weight: 700;
            font-family: cursive;
        }
        .disabled-div{
            filter: opacity(0.5)!important;
        }
        .change-hover:hover{
            background-color: #afc5eb75!important;
            border-radius: 10px!important;
        }
        .accordion-button{
            background-color: #7c8284!important;;
            color: white!important;
        }
        .accordion-item{
            background-color: #e1e1e114;
            border-radius: 10px;
        }
        .accordion{
            border-radius: 10px;
            overflow: hidden;
        }
        .rounded{
            border-radius: 50%!important;
            height: 40px;
            width: 40px;
        }
        .tr{
            cursor: inherit!important;
        }
    </style>
@endsection 
@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            // dataTable
            $('#table').DataTable({
                dom: ' r <"table-wrapper"t>',
                scrollX: true,
                paging: false,
                ordering: false
            });
            // regex for money format ( input recieves only numbers and . )
            $('.money').on('input', function () { 
                this.value = this.value.replace(/[^0-9\.]/g,'');
                if(this.value.split(".").length-1 >1){
                    this.value = this.value.slice(0, -1)  
                }
                if($(this).attr('price') == 'regular_price'){
                    if(this.value.length > 1 && this.value.charAt(0) == '0' ){
                        this.value = this.value.substring(1)
                    }
                    if(this.value == ''){
                        this.value = 0;
                    }
                }
            });
            $('body').on('input', '.percent', function () {
                let value = parseFloat(this.value).toFixed(2)
                if(value > 100){
                    this.value = 100;
                    alert("Максимальный процент должен быть равен или меньше 100")
                }
                if(value == 100){
                    if(this.value.toString().length > 3){
                        this.value = 100;
                        alert("Максимальный процент должен быть равен или меньше 100")
                    }
                }
            })
            // check all or remove check all
            $("#checkAll").change(function(){
                if($(this).is(':checked')){
                    $('input[name="update[]"]').prop('checked', true)
                    $('tbody tr').addClass('checked-tr')
                }else{
                    $('input[name="update[]"]').prop('checked', false)
                    $('tbody tr').removeClass('checked-tr')
                }  
            });
            // make checked checkAll input if all check inputs are checked
            $('input[name="update[]"]').click(function(){   
                let total_checkbox = $('input[name="update[]"]').length
                let total_checkbox_checked = $('input[name="update[]"]:checked').length
                if(total_checkbox == total_checkbox_checked){
                    $("#checkAll").prop('checked', true)
                }else{
                    $("#checkAll").prop('checked', false)
                }     
            });
            // highlight inputs that changed
            $('input[task="change"]').on( 'input', function(){
                let fix_value = $(this).attr('fix-value')
                let value = $(this).val()
                if( fix_value !== value ){
                   $( this ).addClass('changed-input') 
                }else{
                    $( this ).removeClass('changed-input')
                }
            })
            //  highlight table-tr if the checkbox checked
            $('input[name="update[]"]').on( 'click', function(){
                if($(this).is(':checked')){
                    $(this).parent().parent().parent().addClass('checked-tr')
                }else{
                    $(this).parent().parent().parent().removeClass('checked-tr')
                }    
            });        
            // disable save button if checkbox are not selected
            $('input').on('input', function(){   
                setTimeout(function() { 
                    let total_checkbox_checked = $('input[name="update[]"]:checked').length
                    if(total_checkbox_checked < 1){
                        $('#save-btn').addClass('disabled-div')
                    }else{
                        $('#save-btn').removeClass('disabled-div')
                    }     
                }, 3);
            });
            // BACK TO ORGINAL VALUE INPUT
            $('input[task="change"]').contextmenu(function() {
                let fix_value = $(this).attr('fix-value');
                $(this).val(fix_value)
                $( this ).removeClass('changed-input')
                return false;
            });
            // MAKE INPUT VALEU EMPTY ('')
            $('input[task="change"]').on('mousedown', function(e){
                if(e.which == 2){
                    // make 0 if the price is empty
                    if($(this).attr('price') == 'regular_price'){
                        $(this).val(0)
                        let fix_value = $(this).attr('fix-value')
                        let value = $(this).val()
                        if( fix_value !== value ){
                            $( this ).addClass('changed-input') 
                        }else{
                            $( this ).removeClass('changed-input')
                        }
                    }else{
                        $(this).val('')
                        let fix_value = $(this).attr('fix-value')
                        let value = $(this).val()
                        if( fix_value !== value ){
                            $( this ).addClass('changed-input') 
                        }else{
                            $( this ).removeClass('changed-input')
                        }
                    }
                    
                    return false;
                }
            });
            // MAKE ALL INPUT VALUE EMPTY ('') BY SELECTED COLUMN
            $('th[mission="change-all"]').on('mousedown', function(e){
                if(e.which == 2){
                    let column = $(this).attr('change-all')
                    let inputs = $('input[change-all="'+column+'"]')
                    if(column == 'regular_price'){
                        inputs.each(function(){
                            $(this).val(0)
                            let value = $(this).val()
                            let fix_value = $(this).attr('fix-value');
                                if( fix_value !== value ){
                            $( this ).addClass('changed-input') 
                            }else{
                                $( this ).removeClass('changed-input')
                            }
                        });
                    }else{
                        inputs.each(function(){
                            $(this).val('')
                            let value = $(this).val()
                            let fix_value = $(this).attr('fix-value');
                            if( fix_value !== value ){
                                $( this ).addClass('changed-input') 
                            }else{
                                $( this ).removeClass('changed-input')
                            }
                        });
                    }
                    return false;
                }
            });
            // BACK TO All ORGINAL VALUE INPUT BY SELECTED COLUMN
            $('th[mission="change-all"]').contextmenu(function() {
                let column = $(this).attr('change-all')
                let inputs = $('input[change-all="'+column+'"]')
                inputs.each(function(){
                    let fix_value = $(this).attr('fix-value');
                    $(this).val(fix_value)
                    $( this ).removeClass('changed-input')
                });
                return false;
            });
            // SET SALE DATE FROM ALL INPUT VALUE
            let date_check ='';
            let sale_from_label = 'Скидка начинается с:';
            let sale_to_label = 'Скидка заканчивается с:';
            $('th[task="change-date-all"]').on('click', function() {
                date_check = $(this).attr('date')
                if(date_check == 'from'){
                    $('#saleDateLabel').text(sale_from_label)
                }else {
                    $('#saleDateLabel').text(sale_to_label);
                }
                $('#saleDate').modal('show')
            });
            $('#sale-date-confirm').click(function(){
                let date = $('#sale-date').val();
                $('input[fix-date="'+date_check+'"]').val(date)
                $('#saleDate').modal('hide')
                // higlighting inputs changed
                $('input[fix-date="'+date_check+'"]').each(function(){
                    let fix_value = $(this).attr('fix-value')
                    let value = $(this).val()
                    if(fix_value !== value){
                        $( this ).addClass('changed-input') 
                    }else{
                        $( this ).removeClass('changed-input')
                    }
                });
            });
            // SET ALL PRICE AND SALE PRICE BY PERCENTAGE
            let price = '';
            let text_price_modal = '';
            $('.change-price').click(function(){               
                price = $(this).attr('price');
                // enable or disable discount + and - option and choose texts
                if(price == 'regular_price'){
                    text_price_modal = 'Цена ($)';
                    $('#percentage_method option[value="+percentage"]').prop('disabled', false)
                    $('#percentage_method option[value="+amount"]').prop('disabled', false)
                    $('#percentage_method').val("+percentage").change();
                }else if(price == 'sale_price'){
                    text_price_modal = 'Цена в скидке ($)';
                    $('#percentage_method option[value="+percentage"]').prop('disabled', true)
                    $('#percentage_method option[value="+amount"]').prop('disabled', true)
                    $('#percentage_method').val("-percentage").change();
                }
                $('#priceModalLabel').text(text_price_modal)
                $('#priceModal').modal('show')
            });
                // on change select method the price value type input should be changed
            $('#percentage_method').on('change', function(){
                if( this.value == '+percentage' || this.value == '-percentage' ){
                    $('#percentage').addClass('percent')
                    $('#percentage').val('')
                }else{
                    $('#percentage').removeClass('percent')
                    $('#percentage').val('')
                }
            });
                // confirmation 
            $('#price-confirm').click(function(){ 
                if($('#percentage').val() == ''){
                    alert('Пожалуйста, заполните процент!!!')
                    return;
                }
                let percentage = parseFloat($('#percentage').val())
                let percentage_method = $('#percentage_method').val()
                // if this is regular price
                if( price=='regular_price' ){
                    // change all regular_price by percentage
                    $('input[price="regular_price"]').each(function(){
                        value = parseFloat($(this).val());
                        if( isNaN(value) ){
                            result = 0;
                        }else{
                            if(percentage_method == '+percentage'){
                                result = value + (value/100*percentage) 
                                result = result.toFixed(3)
                                result = parseFloat(result)
                            }else if(percentage_method == '-percentage'){
                                division = (value/100*percentage).toFixed(5)
                                result = value - division;
                                result = result.toFixed(3)
                                result = parseFloat(result)
                                if(result < 0.01){
                                    result = 0;
                                }
                            }else if(percentage_method == '+amount'){
                                result = value + percentage;
                                result = result.toFixed(3)
                                result = parseFloat(result)
                                if(result < 0.01){
                                    result = 0;
                                }
                            }else if(percentage_method == '-amount'){
                                result = value - percentage;
                                result = result.toFixed(3)
                                result = parseFloat(result)
                                if(result < 0.01){
                                    result = 0;
                                }
                            }
                        }
                        $(this).val(result)
            
                        if( $(this).val() !== $(this).attr('fix-value') ){
                            $( this ).addClass('changed-input') 
                        }else{
                            $( this ).removeClass('changed-input') 
                        }
                    });
                }else if( price == 'sale_price' ){
                    // change all discount values by percentage
                    $('input[price="sale_price"]').each(function(){
                        value = $(this).closest( "tr" ).find('input[price="regular_price"]').val() 
                        value = parseFloat(value)
                        if( isNaN(value) ){
                            result = ''
                        }else{
                            if(percentage_method == '-percentage'){
                                division = (value/100*percentage).toFixed(5) 
                                result = value - division;
                                result = result.toFixed(3)
                                result = parseFloat(result)
                                if(result < 0.01){
                                    result = 0;
                                }
                            }else if(percentage_method == '-amount'){
                                result = (value - percentage)
                                result = parseFloat(result).toFixed(3)
                                result = parseFloat(result)
                                if(result < 0){
                                    result = 0;
                                }
                            }
                        }
                        $(this).val(result)
                        // highlight changed inputs
                        if( $(this).val() !== $(this).attr('fix-value') ){
                            $( this ).addClass('changed-input') 
                        }else{
                            $( this ).removeClass('changed-input') 
                        }   
                    });
                }
                $('#priceModal').modal('hide')
            });
        });
    </script>
@endsection