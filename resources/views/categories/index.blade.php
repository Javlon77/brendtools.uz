@extends('layout')
@section('title', 'Kategoryalar')
@section('header-text', "Kategoryalar")
@section('content')
<div class="container tbl" >
     <!-- klientlani bazasini ko'rish uchun -->
     <a href="" id="edit-client-link"></a>
    <table class="table bg-white" style="width:100%;" id="c-table" data-page-length='10'>
        <thead> 
            <tr>
                <th>№</th>
                <th>Kategorya</th>
                <th>Harakat</th>
            </tr>          
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr idx="{{ $category->id }}">
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $category->category }}</td>
                <td class="align-middle">
                    <div class="d-flex action-btn">
                    <a href="{{ route('categories.edit',[$category->id])}}" class="btn btn-light edit-btn"><i class="bi bi-pencil-square"></i></a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="post" category="{{ $category->id }}"> @csrf @method('DELETE') 
                        <button type="button" class="btn btn-light ms-2 delete-btn" data-bs-toggle="modal" data-bs-target="#delete-category-modal" category="{{ $category->id }}"><i class="bi bi-trash"></i> </button>
                    </form>
                    </div>
                </td>
            </tr>   
        @endforeach
        </tbody>
    </table> 

</div>

<!-- modal to delete category -->
<div class="modal fade" id="delete-category-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tasdiqlash:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        - Siz rosdan ham ushbu kategoryani o'chirib tashlashni hohlaysizmi?
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
<!-- end of modal to delete category -->
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
<style>
    #c-table_wrapper{
        width: 600px;
        margin:0 auto;
    }
</style>
@endsection 
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
                    "info": "_PAGES_ -   _PAGE_ ",
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

             // delete-category
             let category = 0;
            $('.delete-btn').click(function(){
                category = $(this).attr('category')
             
            });

            $('.confirm-delete').click(function(){
                $('form[category="'+category+'"]').submit()
                $('#delete-category-modal').modal('hide');
            });

            // end of delete-category
        });
    </script>
@endsection