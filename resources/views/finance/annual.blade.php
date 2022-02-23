@extends('layout')
@section('title', "Yillik savdo")
@section('header-text', "Yillik savdo")
@section('content')

<div class="container mb-5" >
    
    <form action="/finance/annual" method="GET" >
        <p>Yilni tanlang:</p>
        @csrf
        <select class="form-select" style="width:130px" name="year" id="" onchange="this.form.submit()">
            @for ($i = 2021; $i <= now() -> format('Y'); $i++)
                @if( $i == $year)
                <option value="{{ $i }}" selected>{{ $i }}</option>
                @else 
                <option value="{{ $i }}" >{{ $i }}</option>
                @endif
            @endfor
        </select>
    </form>
    
    <!-------------------------------          annual plan         ------------------------>

    <h6>Yillik</h6>
    <!-- annual tablo -->
    <div class="total-annual">
        <div class="info-tablo">
            <p>Plan:</p>
            <p class="seperator-uzs">{{ $plan -> annual_plan }}</p>
            <p class="percentage" style="display: contents;">{{ ( $sales -> sum('total_amount') / $plan -> annual_plan ) * 100  }}</p>
        </div>
        <div class="info-tablo">
            <p>Savdo:</p>
            <p class="seperator-uzs">{{ $sales -> sum('total_amount') }}</p>
            <p class="seperator-usd">{{ $sales -> sum('total_amount_usd') }}</p>
        </div>
        <div class="info-tablo">
            <p>Xaridlar soni: </p>
            <p class="seperator">{{ $sales -> count() }}</p>
        </div>
        <div class="info-tablo">
            <p>Mahsulotlar soni: </p>
            <p class="seperator">{{ $sales -> sum('total_quantity') }}</p>
        </div>
        <div class="info-tablo">
            <p>Xarajat:</p>
            <p class="seperator-uzs">{{ $sales -> sum('profit') - $sales -> sum('net_profit') + $annual_cost -> sum('cost') }}</p>
            <p class="seperator-usd">{{ $sales -> sum('profit_usd') - $sales -> sum('net_profit_usd') + $annual_cost -> sum('cost_usd') }}</p>
       
        </div>
        <div class="info-tablo">
            <p>Foyda:</p>
            <p class="seperator-uzs">{{ $sales -> sum('profit') }}</p>
            <p class="seperator-usd">{{ $sales -> sum('profit_usd') }}</p>
        </div>
        <div class="info-tablo">
            <p>Sof foyda:</p>
            <p class="seperator-uzs">{{ $sales -> sum('net_profit') - $annual_cost -> sum('cost') }}</p>
            <p class="seperator-usd">{{ $sales -> sum('net_profit_usd') - $annual_cost -> sum('cost_usd') }}</p>
        </div>
    </div>
    <!-- annual table -->
    <table class="table bg-white annual-table" style="width:100%;" id="annual-plan">
        <thead>
            <tr>
                <th>Oy</th>
                <th>Xarid</th>
                <th>Mahsulot</th>
                <th>Savdo</th>
                <th>Xarajat</th>
                <th>Foyda</th>
                <th>Sof-foyda</th>
                <th>Oylik</th>
                <th>Yillik</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 12; $i++)
                @if($i > 9)
                    <tr>
                        <td>{{ $month_name[$i] }}</td>
                        <td class="seperator">{{ $months[$i] -> count() }}</td>
                        <td class="seperator">{{ $months[$i] -> sum('total_quantity')}}</td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months[$i] -> sum('total_amount')}}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months[$i] -> sum('total_amount_usd')}}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months[$i] -> sum('profit') - $months[$i] -> sum('net_profit') + $costs[$i] -> sum('cost') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months[$i] -> sum('profit_usd') - $months[$i] -> sum('net_profit_usd') + $costs[$i] -> sum('cost_usd') }}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months[$i] -> sum('profit') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months[$i] -> sum('profit_usd') }}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months[$i] -> sum('net_profit') - $costs[$i] -> sum('cost') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months[$i] -> sum('net_profit_usd') - $costs[$i] -> sum('cost_usd') }}</p>
                        </td>
                        <td class="percentage">{{ ( $months[$i] -> sum('total_amount') / ($plan -> annual_plan /12) ) * 100  }}</td>
                        <td class="percentage">{{ ( $months[$i] -> sum('total_amount') / $plan -> annual_plan ) * 100  }}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $month_name[$i] }}</td>
                        <td class="seperator">{{ $months['0'.$i] -> count() }}</td>
                        <td class="seperator">{{ $months['0'.$i] -> sum('total_quantity')}}</td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months['0'.$i] -> sum('total_amount')}}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months['0'.$i] -> sum('total_amount_usd')}}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months['0'.$i] -> sum('profit') - $months['0'.$i] -> sum('net_profit') + $costs['0'.$i] -> sum('cost') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months['0'.$i] -> sum('profit_usd') - $months['0'.$i] -> sum('net_profit_usd') + $costs['0'.$i] -> sum('cost_usd') }}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months['0'.$i] -> sum('profit') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months['0'.$i] -> sum('profit_usd') }}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months['0'.$i] -> sum('net_profit') - $costs['0'.$i] -> sum('cost') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months['0'.$i] -> sum('net_profit_usd') - $costs['0'.$i] -> sum('cost_usd') }}</p>
                        </td>
                        <td class="percentage">{{ ( $months['0'.$i] -> sum('total_amount') / ($plan -> annual_plan /12) ) * 100  }}</td>
                        <td class="percentage">{{ ( $months['0'.$i] -> sum('total_amount') / $plan -> annual_plan ) * 100  }}</td>
                    </tr>
                @endif
            @endfor
           
        </tbody>
    </table>


    <!-------------------------------          first plan         ------------------------>

    
    <h6>1 - yarim yillik (1-6)</h6>
    <!-- tablo -->
    <div class="total-annual">
        <div class="info-tablo">
            <p>Plan:</p>
            <p class="seperator-uzs">{{ $plan -> first_plan }}</p>
            <p class="percentage" style="display: contents;">{{ ( $first_plan['total_amount'] / $plan -> first_plan ) * 100  }}</p>
        </div>
        <div class="info-tablo">
            <p>Savdo:</p>
            <p class="seperator-uzs">{{ $first_plan['total_amount'] }}</p>
            <p class="seperator-usd">{{ $first_plan['total_amount_usd'] }}</p>
        </div>
        <div class="info-tablo">
            <p>Xaridlar soni: </p>
            <p class="seperator">{{ $first_plan['sale'] }}</p>
        </div>
        <div class="info-tablo">
            <p>Mahsulotlar soni: </p>
            <p class="seperator">{{ $first_plan['product'] }}</p>
        </div>
        <div class="info-tablo">
            <p>Xarajat:</p>
            <p class="seperator-uzs">{{ $first_plan['cost'] }}</p>
            <p class="seperator-usd">{{ $first_plan['cost_usd'] }}</p>
       
        </div>
        <div class="info-tablo">
            <p>Foyda:</p>
            <p class="seperator-uzs">{{ $first_plan['profit'] }}</p>
            <p class="seperator-usd">{{ $first_plan['profit_usd'] }}</p>
        </div>
        <div class="info-tablo">
            <p>Sof foyda:</p>
            <p class="seperator-uzs">{{ $first_plan['profit'] - $first_plan['cost'] }}</p>
            <p class="seperator-usd">{{ $first_plan['profit_usd'] - $first_plan['cost_usd'] }}</p>
        </div>
    </div>
    <!-- firs_plan table -->
    <table class="table bg-white annual-table" style="width:100%;" id="first-plan">
        <thead>
            <tr>
                <th>Oy</th>
                <th>Xarid</th>
                <th>Mahsulot</th>
                <th>Savdo</th>
                <th>Xarajat</th>
                <th>Foyda</th>
                <th>Sof-foyda</th>
                <th>Oylik</th>
                <th>6 oylik</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 6; $i++)
                <tr>
                    <td>{{ $month_name[$i] }}</td>
                    <td class="seperator">{{ $months['0'.$i] -> count() }}</td>
                    <td class="seperator">{{ $months['0'.$i] -> sum('total_quantity')}}</td>
                    <td class="uzs-usd">
                        <p class="seperator-uzs">{{ $months['0'.$i] -> sum('total_amount')}}</p>
                        <hr style="margin:2px; color:#979797">
                        <p class="seperator-usd">{{ $months['0'.$i] -> sum('total_amount_usd')}}</p>
                    </td>
                    <td class="uzs-usd">
                        <p class="seperator-uzs">{{ $months['0'.$i] -> sum('profit') - $months['0'.$i] -> sum('net_profit') + $costs['0'.$i] -> sum('cost') }}</p>
                        <hr style="margin:2px; color:#979797">
                        <p class="seperator-usd">{{ $months['0'.$i] -> sum('profit_usd') - $months['0'.$i] -> sum('net_profit_usd') + $costs['0'.$i] -> sum('cost_usd') }}</p>
                    </td>
                    <td class="uzs-usd">
                        <p class="seperator-uzs">{{ $months['0'.$i] -> sum('profit') }}</p>
                        <hr style="margin:2px; color:#979797">
                        <p class="seperator-usd">{{ $months['0'.$i] -> sum('profit_usd') }}</p>
                    </td>
                    <td class="uzs-usd">
                        <p class="seperator-uzs">{{ $months['0'.$i] -> sum('net_profit') - $costs['0'.$i] -> sum('cost') }}</p>
                        <hr style="margin:2px; color:#979797">
                        <p class="seperator-usd">{{ $months['0'.$i] -> sum('net_profit_usd') - $costs['0'.$i] -> sum('cost_usd') }}</p>
                    </td>
                    <td class="percentage">{{ ( $months['0'.$i] -> sum('total_amount') / ($plan -> first_plan /6) ) * 100  }}</td>
                    <td class="percentage">{{ ( $months['0'.$i] -> sum('total_amount') / $plan -> first_plan ) * 100  }}</td>
                </tr>
            @endfor
           
        </tbody>
    </table>
   
    <!-------------------------------          second plan         ------------------------>

    
    <h6>2 - yarim yillik (7-12)</h6>
    <!-- tablo -->
    <div class="total-annual">
        <div class="info-tablo">
            <p>Plan:</p>
            <p class="seperator-uzs">{{ $plan -> second_plan }}</p>
            <p class="percentage" style="display: contents;">{{ ( $second_plan['total_amount'] / $plan -> second_plan ) * 100  }}</p>
        </div>
        <div class="info-tablo">
            <p>Savdo:</p>
            <p class="seperator-uzs">{{ $second_plan['total_amount'] }}</p>
            <p class="seperator-usd">{{ $second_plan['total_amount_usd'] }}</p>
        </div>
        <div class="info-tablo">
            <p>Xaridlar soni: </p>
            <p class="seperator">{{ $second_plan['sale'] }}</p>
        </div>
        <div class="info-tablo">
            <p>Mahsulotlar soni: </p>
            <p class="seperator">{{ $second_plan['product'] }}</p>
        </div>
        <div class="info-tablo">
            <p>Xarajat:</p>
            <p class="seperator-uzs">{{ $second_plan['cost'] }}</p>
            <p class="seperator-usd">{{ $second_plan['cost_usd'] }}</p>
       
        </div>
        <div class="info-tablo">
            <p>Foyda:</p>
            <p class="seperator-uzs">{{ $second_plan['profit'] }}</p>
            <p class="seperator-usd">{{ $second_plan['profit_usd'] }}</p>
        </div>
        <div class="info-tablo">
            <p>Sof foyda:</p>
            <p class="seperator-uzs">{{ $second_plan['profit'] - $second_plan['cost'] }}</p>
            <p class="seperator-usd">{{ $second_plan['profit_usd'] - $second_plan['cost_usd'] }}</p>
        </div>
    </div>

    <!-- second_plan table -->
    <table class="table bg-white annual-table" style="width:100%;" id="second-plan">
        <thead>
            <tr>
                <th>Oy</th>
                <th>Xarid</th>
                <th>Mahsulot</th>
                <th>Savdo</th>
                <th>Xarajat</th>
                <th>Foyda</th>
                <th>Sof-foyda</th>
                <th>Oylik</th>
                <th>6 oylik</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 7; $i <= 12; $i++)
                @if($i > 9)
                    <tr>
                        <td>{{ $month_name[$i] }}</td>
                        <td class="seperator">{{ $months[$i] -> count() }}</td>
                        <td class="seperator">{{ $months[$i] -> sum('total_quantity')}}</td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months[$i] -> sum('total_amount')}}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months[$i] -> sum('total_amount_usd')}}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months[$i] -> sum('profit') - $months[$i] -> sum('net_profit') + $costs[$i] -> sum('cost') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months[$i] -> sum('profit_usd') - $months[$i] -> sum('net_profit_usd') + $costs[$i] -> sum('cost_usd') }}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months[$i] -> sum('profit') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months[$i] -> sum('profit_usd') }}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months[$i] -> sum('net_profit') - $costs[$i] -> sum('cost') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months[$i] -> sum('net_profit_usd') - $costs[$i] -> sum('cost_usd') }}</p>
                        </td>
                        <td class="percentage">{{ ( $months[$i] -> sum('total_amount') / ($plan -> second_plan / 6) ) * 100  }}</td>
                        <td class="percentage">{{ ( $months[$i] -> sum('total_amount') / $plan -> second_plan ) * 100  }}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $month_name[$i] }}</td>
                        <td class="seperator">{{ $months['0'.$i] -> count() }}</td>
                        <td class="seperator">{{ $months['0'.$i] -> sum('total_quantity')}}</td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months['0'.$i] -> sum('total_amount')}}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months['0'.$i] -> sum('total_amount_usd')}}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months['0'.$i] -> sum('profit') - $months['0'.$i] -> sum('net_profit') + $costs['0'.$i] -> sum('cost') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months['0'.$i] -> sum('profit_usd') - $months['0'.$i] -> sum('net_profit_usd') + $costs['0'.$i] -> sum('cost_usd') }}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months['0'.$i] -> sum('profit') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months['0'.$i] -> sum('profit_usd') }}</p>
                        </td>
                        <td class="uzs-usd">
                            <p class="seperator-uzs">{{ $months['0'.$i] -> sum('net_profit') - $costs['0'.$i] -> sum('cost') }}</p>
                            <hr style="margin:2px; color:#979797">
                            <p class="seperator-usd">{{ $months['0'.$i] -> sum('net_profit_usd') - $costs['0'.$i] -> sum('cost_usd') }}</p>
                        </td>
                        <td class="percentage">{{ ( $months['0'.$i] -> sum('total_amount') / ($plan -> second_plan /6) ) * 100  }}</td>
                        <td class="percentage">{{ ( $months['0'.$i] -> sum('total_amount') / $plan -> second_plan ) * 100  }}</td>
                    </tr>
                @endif
            @endfor
           
        </tbody>
    </table>

</div>


@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
<style>
    .total-annual{
        display: flex;
        flex-wrap: wrap;
    }
    .total-annual .info-tablo{
        color: white;
        font-weight: 400;
        border-radius: 4px;
        padding: 10px 20px;
        width: 180px;
        min-width: 180px;
        margin-right: 15px;
        margin-bottom: 15px;
        box-shadow: 5px 5px 3px #00000042;
        transition:0.2s all linear;
    }
    .info-tablo:hover{
        box-shadow: 1px 1px 3px #00000042;
        cursor: pointer;
    }
    .info-tablo:nth-child(1){
        background-color: #9a9a3b;
    }
    .info-tablo:nth-child(2){
        background-color: #373a6d;
    }
    .info-tablo:nth-child(3){
        background-color: #5b4387;
    }
    .info-tablo:nth-child(4){
        background-color: #3b6a83;
    }
    .info-tablo:nth-child(5){
        background-color: #6a3737;
    }
    .info-tablo:nth-child(6){
        background-color: #457245;
    }
    .info-tablo:nth-child(7){
        background-color: #1d671d;
    }
    .total-annual .info-tablo p{
        margin: 0;
        
    }
    .uzs-usd .seperator-uzs{
        color: #00259f;
        margin: 0;
    }
    .uzs-usd .seperator-usd{
        color: #0baa0b;
        margin: 0;
    }
    .fw-600{
        font-weight: 600;
    }
    .percentage{
        max-width: 70px;
    }
    h6{
        font-size: 16px;
        text-align: center;
        margin: 0 auto 31px auto;
        border-bottom: 1px solid;
        padding-bottom: 10px;
        width: 200px;
    }
    .dataTables_wrapper{
        margin-bottom:100px
    }
   
</style>
@endsection 
@section('script') 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
    <script>
        $(document).ready(function(){

            // annual table
            $('#annual-plan').DataTable({
                dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                scrollX: true,
                paging: false,
                searching:false,
                sorting:false,
                info:false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]    
            });

            // first_plan table
            $('#first-plan').DataTable({
                dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                scrollX: true,
                paging: false,
                searching:false,
                sorting:false,
                info:false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ] 
            });
            // cost table
            $('#second-plan').DataTable({
                dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                scrollX: true,
                paging: false,
                searching:false,
                sorting:false,
                info:false,
            });

            // seperator function
            function numberWithSpaces(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            }
            // uzs seperator
            for (let i=0; i < $('.seperator-uzs').length; i++ ) {     
                $(".seperator-uzs")[i].innerText=numberWithSpaces($(".seperator-uzs")[i].innerText)+' UZS' ;
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
     

        });

    </script>
@endsection