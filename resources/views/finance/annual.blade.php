@extends('layout')
@section('title', "Yillik savdo")
@section('header-text', "Yillik savdo")
@section('content')

<div class="container mb-5" >
    <form action="/finance/annual" method="GET" >
        <p>Yilni tanlang:</p>
        @csrf
        <select class="form-select" style="width:130px" name="year" id="" onchange="this.form.submit()">
            @for ($i = 2022; $i <= now() -> format('Y'); $i++)
                @if( $i == $year)
                <option value="{{ $i }}" selected>{{ $i }}</option>
                @else 
                <option value="{{ $i }}" >{{ $i }}</option>
                @endif
            @endfor
        </select>
    </form>

    <div class="change-nav">
        <p class="change-nav-link change-nav-link-active" wrapper="annual-plan-wrapper">{{ $year }} yil</p>
        <p class="change-nav-link" wrapper="first-plan-wrapper" >1 - yarim yil</p>
        <p class="change-nav-link" wrapper="second-plan-wrapper">2 - yarim yil</p>
    </div>
    
    <!-------------------------------          annual plan         ------------------------>
    <div class="plan-wrapper annual-plan-wrapper">
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
        <h5 class="text-center">Tahlillar</h5>
        {{-- diagram for awareness --}}
       <div class="diagram-wrapper">
            <div class="diagram">
                <canvas id="awareness_annual"></canvas>
            </div>
            <div class="diagram">
                <canvas id="by_language"></canvas>
            </div>
            <div class="diagram">
                <canvas id="by_client_type"></canvas>
            </div>
       </div>
    </div>

    <!-------------------------------          first plan         ------------------------>

    <div class="plan-wrapper first-plan-wrapper hide-wrapper">
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
    </div>
    <!-------------------------------          second plan         ------------------------>

    <div class="plan-wrapper second-plan-wrapper hide-wrapper">
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

</div>


@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
<style>
    .change-nav{
        display: flex;
        margin: 30px 0 15px 0;
    }
    .change-nav p{
        margin-right: 30px;
        font-size: 14px;
        line-height: 17px;
        text-transform: uppercase;
        margin-bottom: 0;
        cursor: pointer;
        color:#ffffff;
        opacity: 0.5;
    }
    .change-nav-link-active{
        font-weight: 700;
        font-size: 14px;
        color: #F0F6FF;
        opacity: 1!important;
    }
    .hide-wrapper{
        height:0;
        overflow: hidden;
    }
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
        box-shadow: 3px 3px 3px 0px #00000042;
        transition: 0.2s all linear;
        background-color: #3e566c96;
    }
    .info-tablo:hover{
        box-shadow: 1px 1px 3px #00000042;
        cursor: pointer;
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
    .dataTables_wrapper{
        margin-bottom:100px
    }
    .diagram{
        background-color: #fff;
        border-radius: 5px;
        width: 49%;
        margin-top: 20px;
    }
    .diagram-wrapper{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
   
</style>
@endsection 
@section('script') 
<script src="{{ asset('js/chart.min.js') }}"></script>
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

            // nav change
            $('.change-nav p').click(function(){
                $('.change-nav-link').removeClass('change-nav-link-active');
                $(this).addClass('change-nav-link-active');
                $('.change-nav-link').addClass('.hide-wrapper');
                $('.plan-wrapper').hide();
                $( '.' + $(this).attr('wrapper') ).show();
                $( '.' + $(this).attr('wrapper') ).css('height','auto');
                
            });

            // pieChart yillik mijoz oqimi bo'yicha 
            const ctx = document.getElementById('awareness_annual').getContext('2d');
            const awareness_annual = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        @foreach($by_awareness as $key => $value)
                            '{{ $key }} - {{ number_format($value / array_sum($by_awareness) * 100, 1) }}%',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Sotuv voronkasi',
                        data: [
                            @foreach($by_awareness as $key => $value)
                                {{ $value }},
                            @endforeach
                        ],
                        backgroundColor: [
                            '#7FB3D5',
                            '#EC7063',
                            '#2874A6',
                            '#DC7633',
                            '#2874A6',
                            '#2ECC71',
                            '#196F3D',
                            '#16A085',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: "Oqim bo'yicha xarid",
                        }
                    }
                },
            });

            // pieChart mijoz tili bo'yicha bo'yicha 
            const language = document.getElementById('by_language').getContext('2d');
            const by_language = new Chart(language, {
                type: 'pie',
                data: {
                    labels: [
                        @foreach($by_language as $key => $value)
                            '{{ $key }} - {{ number_format($value / array_sum($by_language) * 100, 1) }}%',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Sotuv voronkasi',
                        data: [
                            @foreach($by_language as $key => $value)
                                {{ $value }},
                            @endforeach
                        ],
                        backgroundColor: [
                            '#16A085',
                            '#196F3D',
                            '#2874A6',
                            '#DC7633',
                            '#2874A6',
                            '#2ECC71',
                            '#196F3D',
                            '#16A085',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: "Mijoz muloqot tili bo'yicha xarid",
                        }
                    }
                },
            });
            // pieChart mijoz turi ' usta, uy egasi, korxona xodimi ' bo'yicha bo'yicha 
            const client_type = document.getElementById('by_client_type').getContext('2d');
            const by_client_type = new Chart(client_type, {
                type: 'pie',
                data: {
                    labels: [
                        @foreach($by_client_type as $key => $value)
                            '{{ $key }} - {{ number_format($value / array_sum($by_client_type) * 100, 1) }}%',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Sotuv voronkasi',
                        data: [
                            @foreach($by_client_type as $key => $value)
                                {{ $value }},
                            @endforeach
                        ],
                        backgroundColor: [
                            '#58508d',
                            '#a05195',
                            '#ffa600',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: "Mijoz turi bo'yicha xarid",
                        }
                    }
                },
            });

        });

    </script>
@endsection