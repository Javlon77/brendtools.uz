@extends('layout')
@section('title', 'Xarajatlar')
@section('header-text', "Xarajatlar")
@section('content')
<div class="container tbl" >
    <p class="text-end"><a href="{{ route('costs.create') }}" class="add-new-link">Qo'shish +</a></p>
    <table class="table bg-white" style="width:100%;" id="c-table" data-page-length="10">
        <thead>
            <tr>
                <th>№</th>
                <th>Maqsad</th>
                <th>Kategorya</th>
                <th class="text-end">UZS</th>
                <th class="text-end">USD</th>
                <th>Qo'shimcha</th>
                <th>Harakat</th>
            </tr>          
        </thead>
        <tbody> 
        @foreach($costs as $cost)
            <tr>
                <td>{{ $loop -> index + 1 }}</td>
                <td>{{ $cost -> reason }}</td>
                <td>{{ $categories -> find($cost -> category_id) -> category ?? '-'}}</td>
                <td class= "seperator text-end">{{ $cost -> cost }}</td>
                <td class= "seperator-usd text-end" >{{ $cost -> cost_usd }}</td>
                <td>{{ $cost -> additional ?? '-' }}</td>
                <td>
                    <div class="d-flex action-btn">
                        <a href="{{ route('costs.edit',[$cost -> id])}}" class="btn btn-light edit-btn"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{ route('costs.destroy', $cost -> id) }}" method="post" cost="{{ $cost -> id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-light ms-2 delete-btn" data-bs-toggle="modal" data-bs-target="#delete-cost-modal" cost="{{ $cost->id }}"><i class="bi bi-trash"></i> </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- modal to delete cost -->
<div class="modal fade" id="delete-cost-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tasdiqlash:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        - Siz rosdan ham ushbu xarajatni o'chirib tashlashni hohlaysizmi?
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
<!-- end of modal to delete cost -->

@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            //number seperator to money format UZS
            function numberWithSpaces(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            }
            for (let i=0; i < $('.seperator').length; i++ ) {     
                $(".seperator")[i].innerText=numberWithSpaces($(".seperator")[i].innerText)+' UZS' ;
            }
            // end of number seperator to money format

            //number seperator to money format $
            for (let i=0; i < $('.seperator-usd').length; i++ ) {     
                $(".seperator-usd")[i].innerText = parseFloat($(".seperator-usd")[i].textContent).toLocaleString() +' $'  ;
            }
            // end of number seperator to money format
            
            // table
            $('#c-table').DataTable({
                dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                language: {
                    "lengthMenu": " _MENU_ tadan",
                    "zeroRecords": "Hechnarsa topilmadi",
                    "info": "_PAGES_ - _PAGE_",
                    "infoEmpty": "",
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

            // delete-cost
            let cost = 0;
            $('.delete-btn').click(function(){
                cost = $(this).attr('cost')
             
            });

            $('.confirm-delete').click(function(){
                $('form[cost="'+cost+'"]').submit()
                $('#delete-cost-modal').modal('hide');
            });

            // end of delete-cost
        });
    </script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
<style>
    
</style>
@endsection 





@endsection