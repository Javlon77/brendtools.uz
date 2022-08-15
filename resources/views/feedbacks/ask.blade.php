@extends('layout')
@section('title', "So'ralishi kerak")
@section('header-text', "So'ralishi kerak")
@section('content')

<div class="container tbl" >
    <p style="color: #29c127">
        * Ushbu sahifa har bir xarid qilgan mijozlarni fikrini bilish uchun va hamma ko'rsatilgan xaridlar 7 kundan o'tkanini bildiradi. Siz mijoz bilan qayta aloqa o'rnatganingizdan so'ng uning fikrlarini formalarga kiritishingiz kerak! 
    </p>
    <!-- open show link -->
    <a href="" id="open-show-link"></a>

    <table class="table bg-white" style="width:100%;" id="c-table" data-page-length="10">
        <thead>
            <tr>
                <th>№</th>
                <th>Mijoz</th>
                <th>Kim</th>
                <th>Viloyat</th>
                <th>To'lash usuli</th>
                <th>Summa</th>
                <th>Xarid sanasi</th>
                <th>Tahrirlash</th>
            </tr>          
        </thead>
        <tbody>
            @foreach($feedbacks as $feedback)
            <tr idx="{{ $feedback ->client_id .'#' .$feedback ->sale_id }}">
               <td style="width:10px">{{ $loop ->index+1 }}</td>
               <td>{{ $feedback ->client ->name }}</td>
               <td>{{ $feedback ->client ->type }}</td>
               <td>{{ $feedback ->client ->region }}</td>
               <td>{{ $feedback ->sale ->payment_method == 'monthly' ? 'Oyma-oy' : 'Birdaniga' }}</td>
               <td class="seperator">{{ $feedback ->sale ->total_amount }}</td>
               <td style="color: red;">{{ $feedback ->sale_date }}</td>
               <td style="width:10px">
                    <div class="d-flex">
                        <a href="{{ route('feedbacks.edit',[$feedback->id]) }}" class="btn btn-light edit-btn"><i class="bi bi-pencil-square"></i></a>
                    </div>
                </td>
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
            // delete-sale
            let sale_id = 0;
            $('.delete-btn').click(function(){
                sale_id = $(this).attr('sale')
            });

            $('.confirm-delete').click(function(){
                $('form[sale="'+sale_id+'"]').submit()
                $('#delete-sale-modal').modal('hide');
            });
            // end of delete-sale

            //number seperator to money format
            function numberWithSpaces(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            }
            for (let i=0; i < $('.seperator').length; i++ ) {     
                $(".seperator")[i].innerText=numberWithSpaces($(".seperator")[i].innerText)+' UZS' ;
            }
            // end of number seperator to money format
            $("body").on('input' , '.seperator', function(e){
                if(this.value!==''){
                    let a = $(this).val().replace(/\s/g, '')
                    let p = parseInt(a)
                    if(isNaN(p)){
                        $(this).val('')
                    }
                    else{
                        $(this).val(numberWithSpaces(p))
                    }
                }
            });   

            $('#c-table').DataTable({
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
            $('.table').on('dblclick', 'tr', function(){
                if($(this).attr('idx')!==undefined){
                    let link = '/client-base/'+$(this).attr('idx');
                    $('#open-show-link').attr('href', link);
                    $('#open-show-link')[0].click();   
                }
            })
        });
 
    </script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
@endsection 
@endsection