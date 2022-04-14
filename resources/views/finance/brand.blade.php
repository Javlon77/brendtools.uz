@extends('layout')
@section('title', "Brendlar bo'yicha savdo")
@section('header-text', "Brendlar bo'yicha savdo")
@section('content')

<div class="container pb-1 mb-5" >
    {{-- filter by date --}} 
    <div class="filter-by-date">
        <form action="/finance/brand" class="filter-select">
        <p style="font-size:17px; margin-bottom:4px">Saralash:</p>
            <select name="order" class="form-select" id="order" onchange="this.form.submit()">
                <option value="today">Bugun</option>
                <option value="this_week" selected>Shu hafta</option>
                <option value="last_week">O'tkan hafta</option>
                <option value="this_month">Shu oy</option>
                <option value="last_month">O'tkan oy</option>
                <option value="this_year">Shu yil</option>
                <option value="last_year">O'tkan yil</option>
                <option value="all">Hammasi</option>
            </select>
        </form>
        <form action="" class="date-filter">
            <p style="font-size:17px; margin-bottom: 4px;">Vaqt oralig'i boyicha saralash:</p>
            <div class="input-group">
                <input type="date" name="from" id="from" class="form-control form-control" value="{{ $from ?? '' }}">
                <span class="input-group-text">⇆</span>
                <input type="date" name="to" id="to" class="form-control" value="{{ $to ?? '' }}">
                <button type="submit" class="btn btn-secondary" >Saralash</button>    
            </div>
        </form>
    </div>

    {{-- Table show if not empty --}}
    @if($products -> isEmpty())
        <h5 class="my-0 mt-5">Ushbu Vaqt mobaynida savdo bo'lmagan!</h5>
    @else
        
        <table class="table bg-white" style="width: 100%;" id="table" data-page-length="20">
            <thead>
                <tr>
                    <th>Brend</th>
                    <th style="max-width: 50px">Soni</th>
                    <th>Savdo</th>
                    <th>Foyda</th> 
                    <th>O'rtacha chek</th>
                    <th>Rentabellik</th>
                    <th style="max-width: 160px">Foiz</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $brand_id => $product)
                    <tr href="{{ route('products-filter').'?filter_from='. $from . '&filter_to=' . $to. '&filter_brand='. $brand_id }}" class="open-page">
                        <td> {{ $brands -> find($brand_id) -> brand }} </td>
                        <td class="seperator"> {{ $product -> sum('quantity') }} </td>
                        <td class="seperator-uzs">
                            {{   $product -> sum(function($item){ return $item->selling_price * $item->quantity;  })  }}
                        </td>
                        <td class="seperator-uzs">
                            {{ $product -> sum(function($item){ return ($item->selling_price - $item->cost_price) * $item->quantity; }) }}
                        </td>
                        <td class="seperator-uzs">{{ $product -> sum(function($item){ return $item->selling_price * $item->quantity;  }) / $product -> sum('quantity') }}</td>
                        <td class="percentage">
                            {{ 
                                $product -> sum(function($item){ return ($item->selling_price - $item->cost_price) * $item->quantity; }) 
                                / 
                                $product -> sum(function($item){ return $item->selling_price * $item->quantity; }) * 100 
                            }}
                        </td>
                        <td class="percentage">{{ $product -> sum(function($item){ return $item->selling_price * $item->quantity; }) / $total_sale * 100 }}</td>
                    </tr>   
                @endforeach
            </tbody>
            <div>
                <tr class="fw-bold">
                    <td>Jami: {{ $products -> count() }} x</td>
                    <td class="seperator">{{ $total_product  }} </td>
                    <td class="seperator-uzs">{{ $total_sale }} </td>
                    <td class="seperator-uzs">{{ $total_profit }}</td>
                    <td class="seperator-uzs">{{ $total_sale /  $total_product  }}</td>
                    <td class="percentage">{{ $total_profit / $total_sale * 100 }}</td>
                    <td>100 %</td>
                </tr>
            </div>
        </table>
    @endif
    {{-- end of show table if not empty --}}
</div>


@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
<style>
     .filter-select{
        width:180px;
        margin-right:10px;
        margin-bottom: 6px;
    }
    .filter-by-date{
        display:flex;
        flex-wrap: wrap;
        margin-top:10px;
        margin-bottom: 30px;
    }
    tr{
        text-align: end;
    }
    tr:hover{
        cursor: pointer;
    }
    tr th:first-child, tr td:first-child{
        text-align: left;
    }
   
</style>
@endsection 
@section('script') 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            // set date range filter
            if( '{{ $check }}' !== '' ){
                $('#order option[value="{{ $check }}"]').prop('selected', true)
            } else {
                $('#order').append(' <option value="-" selected>-</option>')
            }
            // annual table
            $('#table').DataTable({
                dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                scrollX: true,
                paging: false,
                searching:false,
                info:false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]    
            });
            // seperator function
            function numberWithSpaces(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            }
            // uzs seperator
            for (let i=0; i < $('.seperator-uzs').length; i++ ) {     
                $(".seperator-uzs")[i].innerText=numberWithSpaces(parseInt($(".seperator-uzs")[i].innerText))+' UZS' ;
            }
            // usd seperator
            for (let i=0; i < $('.seperator-usd').length; i++ ) {     
                $(".seperator-usd")[i].innerText = parseFloat($(".seperator-usd")[i].textContent).toLocaleString('en-US', {style:"currency", currency:"USD"}) ;
            }
            // number-seperator
            for (let i=0; i < $('.seperator').length; i++ ) {     
                $(".seperator")[i].innerText = parseFloat($(".seperator")[i].textContent).toLocaleString() +' x';
            }
            // percentage
            for (let i=0; i < $('.percentage').length; i++ ) {     
                $(".percentage")[i].innerText = parseFloat($(".percentage")[i].textContent).toFixed(2) + ' %';
            }
            // open products page according to month
            $('.open-page').on('dblclick', function() {
                window.location.href = $(this).attr('href');
            });

        });

    </script>
@endsection