@extends('layout')
@section('title', "Baholangan")
@section('header-text', "Baholangan")
@section('content')

<div class="container tbl" >
    <p style="color: #29c127">
        * Ushbu sahifada biznig hizmatni 1-10 gacha baholagan mijozlar saqlanadi. Agar ular keyingi etapka o'tsalar bu joyda ko'rinmaydi!
    </p>
    <!-- open show link -->
    <a href="" id="open-show-link"></a>

    <table class="table bg-white" style="width:100%;" id="c-table" data-page-length="10">
        <thead>
            <tr>
                <th>№</th>
                <th>Mijoz</th>
                <th>Kim</th>
                <th style="color:#29c127">Baho</th>
                <th>To'lash usuli</th>
                <th>Summa</th>
                <th>Qo'shimcha fikr</th>
                <th>Xarid sanasi</th>
                <th>Harakat</th>
            </tr>          
        </thead>
        <tbody>
            @foreach($feedbacks as $feedback)
            <tr idx="{{ $feedback ->client_id .'#' .$feedback ->sale_id }}">
               <td style="width:10px">{{ $loop ->index+1 }}</td>
               <td>{{ $feedback ->client ->name }}</td>
               <td>{{ $feedback ->client ->type }}</td>
               <td style="color:#29c127">{{ $feedback ->rank }}</td>
               <td>{{ $feedback ->sale ->payment_method == 'monthly' ? 'Oyma-oy' : 'Birdaniga' }}</td>
               <td class="seperator">{{ $feedback ->sale ->total_amount }}</td>
               <td>{{ $feedback ->comment ?? '-' }}</td>
               <td>{{ $feedback ->sale_date }}</td>
               <td class="align-middle">
                    <div class="d-flex ">
                        <a href="{{ route('feedbacks.edit',[$feedback->id]) }}" class="btn btn-light edit-btn">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('feedbacks.set',[$feedback->id]) }}" method="post" feedback-form="{{ $feedback->id }}">
                            @csrf
                            @method('PUT')
                            <button type="button" class="btn btn-light ms-2 delete-btn" data-bs-toggle="modal" data-bs-target="#will-not-review-modal" feedback="{{ $feedback->id }}">
                                <i class="bi bi-arrow-90deg-right"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- modal to set client wont mark -->
<div class="modal fade" id="will-not-review-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tasdiqlash:</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Ushbu mijoz rostdan ham Sharh qoldirmaydimi?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="button" class="btn btn-danger confirm-set">Qoldirmaydi</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end of modal to set client wont mark -->

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

                // set client as will not review
                let feedback_id = 0;
                $('.delete-btn').click(function(){
                    feedback_id = $(this).attr('feedback')
                });

                $('.confirm-set').click(function(){
                    $('form[feedback-form="'+feedback_id+'"]').submit()
                    console.log(1)
                    $('#will-not-review-modal').modal('hide');
                });
            });
    
        </script>
    @endsection
    @section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
    @endsection 
@endsection