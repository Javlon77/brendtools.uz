@extends('layout')
@section('title', "Valyuta kursi")
@section('header-text', "Valyuta kursi")
@section('content')

<div class="container tbl" >
    <p style="color: #29c127">
        * Ushbu valyuta kursi brandtools.uz savdo sahifasi uchun ham amal qiladi!
    </p>
    {{-- messages from controller--}}
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
   <div class="currency-tablo-wrapper">
       <!-- currency-tablo -->
       <div class="currency-tablo-wrapper d-block">
            <p>Kurs: </p>    
            <div class="currency-tablo">
                    <p class="seperator" style=""> {{ $last_currency->currency ?? '-' }} </p>
            </div>
       </div>
       
       <!-- end of currency-tablo -->

       <!-- Form to create cuurency -->
       <form method="post" action="{{ route('currency.store') }}">
           @csrf
           <p>O'zgartrish: </p>
           <div class="input-group flex-nowrap " style="width:300px">
            <span class="input-group-text" id="addon-wrapping">$ = </span>
            <input type="text" class="form-control @if($errors->has('currency')) is-invalid @endif" placeholder="UZS" aria-label="UZS" aria-describedby="addon-wrapping" id="currency" name="currency">
            <button class="btn btn-success" type="submit" id="button-addon2" style="width: auto;">saqlash</button>
        </div>
    </form>
    <!-- end of form to create cuurency -->

   </div>
    <!-- tablitsa istorya kursa -->
    <h5 class="my-0 mt-5">Valyutalar tarixi</h5>
    <table class="table bg-white" style="width: 100%;" id="c-table" data-page-length="20">
        <thead>
            <tr>
                <th>№</th>
                <th>Kurs</th>
                <th>Belgilangan sana</th>
                <th>Bekor qilingan sana</th>
            </tr>
        </thead>
        <tbody>
        @foreach($currencies as $currency)
            <tr idx="{{ $currency->id }}">
                <td>{{ $loop->index+1 }}</td>
                <td class="seperator">{{ $currency->currency }}</td>
                <td>{{ \Carbon\carbon::parse($currency->created_at)->format('d.m.Y - H:i:s') }}</td>
                @if( $last_currency ->id == $currency ->id )
                    <td>-</td>
                @else
                    <td>{{ \Carbon\carbon::parse($currency->updated_at)->format('d.m.Y - H:i:s') }}</td>
                @endif
            </tr>   
        @endforeach
        </tbody>
    </table>
    <!-- end  tablitsa istorya kursa -->

</div>

@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
<style>
    .currency-tablo{
        display: flex;
        justify-content: center;
        align-items: center;
        width: auto;
        background-color: #224283;
        border-radius: 5px;
        padding: 7px 15px;
        margin-right: 15px;
    }
    .currency-tablo p{
        margin: 0;
    }
    .currency-tablo-wrapper{
        display: flex;
        justify-content: flex-start;
        align-content: flex-start;
        align-items: flex-end;
    }
</style>
@endsection 
@section('script') 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
<script>
    $(document).ready(function(){
        //number seperator to money format
        function numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
        for (let i=0; i < $('.seperator').length; i++ ) {     
            $(".seperator")[i].innerText=numberWithSpaces($(".seperator")[i].innerText)+' UZS' ;
        }
        //number seperator to money format in input
        $("#currency").on('input', function(e){
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
        // end of number seperator to money format

        // table 

        $('#c-table').DataTable({
            dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
            language: {
                "lengthMenu": " _MENU_ tadan",
                "zeroRecords": "Hechnarsa topilmadi",
                "info": "_START_ -  _END_ (Jami: _TOTAL_)",
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
        // end of table
    });

</script>
@endsection