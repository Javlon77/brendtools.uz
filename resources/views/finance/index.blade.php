@extends('layout')
@section('title', "Moliya")
@section('header-text', "Moliya")
@section('content')

<div class="container" >
    {{ $sales -> last() }}
    <!-- Yillik -->
    <h6 class="mb-0 mt-5">Yillik Xisobot</h6>
    <table class="table bg-white" style="width:100%;" id="cost">
        <thead>
            <tr>
                <th>Oy</th>
                <th>Xarid</th>
                <th>Mahsulot</th>
                <th>Savdo</th>
                <th>Xarajat</th>
                <th>Foyda</th>
                <th>Sof-foyda</th>
                <th>Foiz</th>
            </tr>          
        </thead>
        <tbody> 
            <tr>
                <td>Yanvar</td>
                <td>Xarid</td>
                <td>Mahsulot</td>
                <td>Savdo</td>
                <td>Xarajat</td>
                <td>Foyda</td>
                <td>Sof-foyda</td>
                <td>Foiz</td>
            </tr>   
            
        </tbody>
    </table>
    <!-- overall -->
    <h6 class="mb-0 mt-5">Umumiy</h6>
    <table class="table bg-white" style="width:100%;" id="overall">
        <thead>
            <tr>
                <th>Valyuta</th>
                <th>Savdo</th>
                <th>Xarajatlar</th>
                <th>Foyda</th>
                <th>Sof foyda</th>
            </tr>          
        </thead>
        <tbody> 
            <tr class="fw-600">
                <th>UZS</th>
                <td class="seperator-uzs">{{ $sales -> sum('total_amount') }}</td>
                <td class="seperator-uzs">{{ $sales -> sum('profit')- $sales -> sum('net_profit') + $costs -> sum('cost') }}</td>
                <td class="seperator-uzs">{{ $sales -> sum('profit') }}</td>
                <td class="seperator-uzs">{{ $sales -> sum('net_profit') - $costs -> sum('cost')}}</td>
            </tr>   
            <tr class="fw-600">
                <th>USD</th>
                <td class="seperator-usd">{{ $sales -> sum('total_amount_usd') }}</td>
                <td class="seperator-usd">{{ $sales -> sum('profit_usd')- $sales -> sum('net_profit_usd') + $costs -> sum('cost_usd') }}</td>
                <td class="seperator-usd">{{ $sales -> sum('profit_usd') }}</td>
                <td class="seperator-usd">{{ $sales -> sum('net_profit_usd') - $costs -> sum('cost_usd')}}</td>
            </tr> 
        </tbody>
    </table>

    <!-- Sale -->
    <h6 class="mb-0 mt-5">Savdo</h6>
    <table class="table bg-white" style="width:100%;" id="sale">
        <thead>
            <tr>
                <th>Valyuta</th>
                <th>Xarid</th>
                <th>Mahsulot</th>
                <th>Savdo</th>
                <th>Xarajat(yetkazish)</th> 
                <th>Foyda</th>
                <th>Sof foyda</th>
            </tr>          
        </thead>
        <tbody> 
            <tr class="fw-600">
                <th style="width:70px">UZS</th>
                <td style="width:70px" class="seperator">{{ $sales -> count() }}</td>
                <td style="width:100px" class="seperator">{{ $sales -> sum('total_quantity') }}</td>
                <td class="seperator-uzs">{{ $sales -> sum('total_amount') }}</td>
                <td class="seperator-uzs ">{{ $sales -> sum('profit')- $sales -> sum('net_profit') }}</td>
                <td class="seperator-uzs ">{{ $sales -> sum('profit') }}</td>
                <td class="seperator-uzs ">{{ $sales -> sum('net_profit') }}</td>
            </tr>   
            <tr class="fw-600">
                <th>USD</th>
                <td class="seperator">{{ $sales -> count() }}</td>
                <td class="seperator">{{ $sales -> sum('total_quantity') }}</td>
                <td class="seperator-usd">{{ $sales -> sum('total_amount_usd') }}</td>
                <td class="seperator-usd">{{ $sales -> sum('profit_usd')- $sales -> sum('net_profit_usd') }}</td>
                <td class="seperator-usd">{{ $sales -> sum('profit_usd') }}</td>
                <td class="seperator-usd">{{ $sales -> sum('net_profit_usd') }}</td>
            </tr> 
        </tbody>
    </table>

    <!-- COSTS -->
    <h6 class="mb-0 mt-5">Xarajatlar</h6>
    <table class="table bg-white" style="width:100%;" id="cost">
        <thead>
            <tr>
                <th>Maqsad</th>
                <th>UZS</th>
                <th>USD</th>
            </tr>          
        </thead>
        <tbody> 
            <tr>
                <td>Reklama</td>
                <td class="seperator-uzs">{{ $costs -> where('reason', 'Reklama') -> sum('cost')}}</td>
                <td class="seperator-usd">{{ $costs -> where('reason', 'Reklama') -> sum('cost_usd')}}</td>
            </tr>   
            <tr>
                <td>Aktiv</td>
                <td class="seperator-uzs">{{ $costs -> where('reason', 'Aktiv') -> sum('cost')}}</td>
                <td class="seperator-usd">{{ $costs -> where('reason', 'Aktiv') -> sum('cost_usd')}}</td>
            </tr> 
            <tr>
                <td>Boshqalar</td>
                <td class="seperator-uzs">{{ $costs -> where('reason', 'Boshqalar') -> sum('cost')}}</td>
                <td class="seperator-usd">{{ $costs -> where('reason', 'Boshqalar') -> sum('cost_usd')}}</td>
            </tr>
            <tr class="fw-bolder">
                <td>jami</td>
                <td class="seperator-uzs">{{ $costs -> sum('cost') }}</td>
                <td class="seperator-usd">{{ $costs -> sum('cost_usd') }}</td>
            </tr>
        </tbody>
    </table>
 

   

</div>


@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
<style>
    .fw-600{
        font-weight: 600;
    }
</style>
@endsection 
@section('script') 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
    <script>
        $(document).ready(function(){

            // overall
            $('#overall').DataTable({
                dom: '<"make-excel"> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                scrollX: true,
                paging: false,
                searching:false,
                sorting:false,
                info:false,       
            });

            // sale table
            $('#sale').DataTable({
                dom: '<"make-excel"> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                dom: '<"make-excel"> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                scrollX: true,
                paging: false,
                searching:false,
                sorting:false,
                info:false,
            });
            // cost table
            $('#cost').DataTable({
                dom: '<"make-excel"> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                dom: '<"make-excel"> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
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
     

        });

    </script>
@endsection