@extends('layout')
@section('title', 'Mijozlar')
@section('header-text', "Mijozlar")
@section('content')
<div class="container tbl" >
    <!-- klientlani bazasini ko'rish uchun -->
    <a href="" id="edit-client-link"></a>
    <p style="color: #29c127">* Mijoz haqida to'liq ma'lumotlarni ko'rish uchun ikki marta bosing!</p>
    <table class="table bg-white" style="width:100%;" id="c-table" data-page-length='10'>
        <thead>
            <tr>
                <th>№</th>
                <th>Ism</th>
                <th>Familiya</th>
                <th>Kim</th>
                <th>Kompaniya</th>
                <th>Usta</th>
                <th>Telefon</th>
                <th>Telefon 2</th>
                <th>Viloyat</th>
                <th>Manzil</th>
                <th>fikr</th>
                <th>Harakat</th>
            </tr>          
        </thead>
        <tbody> 
        @foreach($clients as $client)
            <tr idx="{{ $client->id }}">
                <td>{{ $loop->index+1 }}</td> 
                <td>{{ $client->name }}</td>
                <td>{{ $client->surname }}</td>
                <td>{{ $client->type }}</td>
                <td>{{ $companies->keyBy('id')[$client->company_code]->company ?? '-' }}</td>
                <td>{{ $masters->keyBy('id')[$client->master_code]->master ?? '-' }}</td>
                <td>{{ $client->phone1 }}</td>
                <td>{{ $client->phone2 ?? '-' }}</td>
                <td>{{ $client->region }}</td>
                <td>{{ $client->address ?? '-' }}</td>
                <td>{{ $client->feedback ?? '-' }}</td>
                <td class="align-middle">
                    <div class="d-flex ">
                        <a href="{{ route('client-base.edit',[$client->id])}}" class="btn btn-light edit-btn"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{ route('client-base.destroy',['client_base' => $client->id]) }}" method="post" client-form="{{ $client->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-light ms-2 delete-btn" data-bs-toggle="modal" data-bs-target="#delete-client-modal" client="{{ $client->id }}"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>   
        @endforeach
        </tbody>
    </table>
 

</div>

<!-- modal to delete client -->
<div class="modal fade" id="delete-client-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tasdiqlash:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        - Siz rosdan ham ushbu mijozni o'chirib tashlashni hohlaysizmi?
        <br><br>
        - Bu tizimda ma'lum bir muammolarga sabab bo'lishi mumkin!!!
        <br><br>
        - O'chirmaslik tavsiya etiladi!!!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        <button type="button" class="btn btn-danger confirm-delete">O'chirish</button>
      </div>
    </div>
  </div>
</div>
<!-- end of modal to delete client -->

@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#c-table').DataTable({
                dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                language: {
                    "lengthMenu": " _MENU_ tadan",
                    "zeroRecords": "Hechnarsa topilmadi",
                    "info": "_PAGES_ - _PAGE_ ",
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
                    $('#edit-client-link').attr('href', link);
                    $('#edit-client-link')[0].click();   
                }
            })
        });

        // delete-client
            let client_id = 0;
            $('.delete-btn').click(function(){
                client_id = $(this).attr('client')
             
            });

            $('.confirm-delete').click(function(){
                $('form[client-form="'+client_id+'"]').submit()
                $('#delete-client-modal').modal('hide');
            });

        // end of delete-client

        
    </script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
<style>
    tr{
        cursor: pointer;
        -webkit-touch-callout: none; 
        -webkit-user-select: none; 
        -khtml-user-select: none; 
        -moz-user-select: none; 
        -ms-user-select: none; 
        user-select: none; 
    }
    tr:hover{
        background-color: #dae5f7!important;
    }
    
</style>
@endsection 





@endsection