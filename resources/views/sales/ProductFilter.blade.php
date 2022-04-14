@extends('layout')
@section('title', 'Mahsulot sotuvi')
@section('header-text', "Mahsulot sotuvi")
@section('content')

<div class="container tbl">

    <table class="table bg-white" style="width:100%;" id="product-table" data-page-length="10">
        <thead>
            <tr>
                <th>№</th>
                <th>Mahsulot</th>
                <th>Soni</th>
                <th>Jami</th>
                <th>Foyda</th>
                <th>Tushgan narx</th>
                <th>Sotilgan narx</th>
                <th>Sana</th>
            </tr>          
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr href="{{ route('client-base.show',$product->sale->client_id) }}" class="open-link">
                    <td>{{$loop->index+1}}</td>
                    <td>{{$product->product->product}}</td>
                    <td class="qty" data-order="{{ $product->quantity}}">{{$product->quantity}}</td>
                    <td class="uzs" data-order="{{ $product->quantity * $product ->selling_price }}">{{ $product->quantity * $product ->selling_price }}</td>
                    <td class="uzs" data-order="{{ $product->quantity*($product->selling_price-$product->cost_price)}}">{{$product->quantity*($product->selling_price-$product->cost_price)}}</td>
                    <td class="uzs" data-order="{{ $product->cost_price}}">{{$product->cost_price}}</td>
                    <td class="uzs" data-order="{{ $product->selling_price}}">{{$product->selling_price}}</td>
                    <td style="width:10px" data-order="{{ $product->created_at->format('Y.m.d') }}">{{$product->created_at->format('d.m.Y')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            // number seperators
            function numberWithSpaces(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            }
            for (let i=0; i < $('.uzs').length; i++ ) {     
                $(".uzs")[i].innerText=numberWithSpaces($(".uzs")[i].innerText)+' UZS' ;
            }
            for (let i=0; i < $('.qty').length; i++ ) {     
                $(".qty")[i].innerText=numberWithSpaces($(".qty")[i].innerText)+' x' ;
            }
            // Datatable
            $('#product-table').DataTable({
                dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                language: {
                    "lengthMenu": " _MENU_ tadan",
                    "zeroRecords": "Hechnarsa topilmadi",
                    "info": "_START_ -  _END_ (Jami: _TOTAL_)",
                    "ordering" : true,
                    "infoEmpty": "No records available",
                    "infoFiltered": "(Umumiy _MAX_ qayddan filtrlandi)",
                    "search":"Qidirish:",
                    "Next":"dsa",
                    "paginate": {
                        "previous": "<",
                        "next":">"
                    }
                },
                scrollX: true,
                paging: true,
                "lengthMenu": [10,20,40,60,100,200],
                "order":[],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            // open client.show page by id on dblclick
            $('.open-link').on('dblclick', function(){
                window.location.href = $(this).attr('href')
            })
        });
    </script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
<style>
    tr{
        cursor:pointer;
    }
</style>
@endsection 





@endsection