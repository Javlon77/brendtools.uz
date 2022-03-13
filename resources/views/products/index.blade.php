@extends('layout')
@section('title', "Mahsulotlar")
@section('header-text', "Mahsulotlar")
@section('content')
<div class="container tbl" >
    <p class="text-end"><a href="{{ route('products.create') }}" class="add-new-link">Qo'shish +</a></p>
    <!-- mahsulotlar bazasini ko'rish uchun -->
    <a href="" id="edit-client-link"></a>
    <table class="table bg-white" style="width: 100%;" id="c-table" data-page-length="10">
        <thead>
            <tr>
                <th>№</th>
                <th>Mahsulot</th>
                <th>Brend</th>
                <th>Kategorya</th>
                <th>Harakat</th>
            </tr>          
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr idx="{{ $product->id }}">
                <td>{{ $loop->index+1 }}</td>
                <td>@if($product -> link !== NULL ) <a class="link" href="{{ $product->link }}">{{ $product->product }}</a> @else {{ $product->product }} @endif </td>
             
                <td>{{ $categories->keyBy('id')[$product->category_id]->category }}</td>
                <td class="align-middle">
                    <div class="d-flex action-btn">
                    <a href="{{ route('products.edit',[$product->id])}}" class="btn btn-light edit-btn"><i class="bi bi-pencil-square"></i></a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="post"  product="{{ $product->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-light ms-2 delete-btn" data-bs-toggle="modal" data-bs-target="#delete-product-modal" product="{{ $product->id }}"><i class="bi bi-trash"></i> </button>
                    </form>
                    </div>
                </td>
            </tr>   
        @endforeach
        </tbody>
    </table>
</div>

<!-- modal to delete product -->
<div class="modal fade" id="delete-product-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tasdiqlash:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        - Siz rosdan ham ushbu mahsulotni o'chirib tashlashni hohlaysizmi?
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
<!-- end of modal to delete product -->

@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
<style>
    .link{
        text-decoration: none;
        color: #2820ab
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

            // delete-product
            let product = 0;
            $('.delete-btn').click(function(){
                product = $(this).attr('product')
             
            });

            $('.confirm-delete').click(function(){
                $('form[product="'+product+'"]').submit()
                $('#delete-product-modal').modal('hide');
            });

            // end of delete-product
        });

    </script>
@endsection