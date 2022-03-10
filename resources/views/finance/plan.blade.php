@extends('layout')
@section('title', "Plan")
@section('header-text', "Plan")
@section('content') 

<div class="container tbl" >
   <div class="container  container-bg">
        <form method="post" action="/finance/plan">
            @csrf
            @error('year')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="j-row">
                <div class="mb-3 input-width">
                    <label class="form-label">Yilni tanlang</label>
                    <div class="input-group">
                        <select name="year" class="form-select">
                            <option value="{{ now() -> year }}">{{ now() -> year }}</option>
                            <option value="{{ now() -> year +1 }}">{{ now() -> year +1 }}</option>
                        </select>
                    </div>
                </div> 
                <div class="mb-3 input-width">
                    <label class="form-label">Birinchi yarim yillik plan <strong class="text-danger">*</strong></label>
                    <div class="input-group">
                        <Input name="first_plan" id="first-semiannual" class="text-end seperator-input form-control" value="" required>
                        <span class="input-group-text">UZS</span>
                    </div>
                </div> 
                <div class="mb-3 input-width">
                    <label class="form-label">Ikkinchi yarim yillik plan <strong class="text-danger">*</strong></label>
                    <div class="input-group">
                        <Input name="second_plan" id="second-semiannual" class="text-end seperator-input form-control" value="">
                        <span class="input-group-text">UZS</span>
                    </div>
                </div>
                <div class="mb-3 input-width">
                    <label class="form-label">Yillik plan</label>
                    <div class="input-group">
                        <Input name="annual_plan" id="annual" class="text-end seperator-input form-control" value="" >
                        <span class="input-group-text">UZS</span>
                    </div>
                </div>  
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success px-3 py-2 mt-3">Qo'shish</button>
            </div>
        </form>  
   </div>

   <h5 class="my-0 mt-5">Planlar tarixi</h5>
    <table class="table bg-white" style="width: 100%;" id="c-table" data-page-length="20">
        <thead>
            <tr>
                <th>Yil</th>
                <th>Yillik plan</th>
                <th>Birinchi yarim yillik plan</th>
                <th>Ikkinchi yarim yillik plan</th>
                <th>O'chirish</th>
            </tr>
        </thead>
        <tbody>
        @foreach($plans as $plan)
            <tr>
                <td>{{ $plan -> year }}</td>
                <td class="seperator">{{ $plan -> annual_plan }}</td>
                <td class="seperator">{{ $plan -> first_plan }}</td>
                <td class="seperator">{{ $plan -> second_plan }}</td>
                <td class="align-middle">
                    <div class="d-flex action-btn">
                    <form action="/finance/plan/{{$plan->id}}" method="post" plan="{{ $plan->id }}"> 
                        @csrf 
                        @method('DELETE') 
                        <button type="button" class="btn btn-light ms-2 delete-btn" data-bs-toggle="modal" data-bs-target="#delete-plan-modal" plan="{{ $plan->id }}" @if(now() -> year > $plan -> year) disabled @endif>
                            <i class="bi bi-trash"></i> 
                        </button>
                    </form>
                    </div>
                </td>
            </tr>   
        @endforeach
        </tbody>
    </table>
</div>

<!-- modal to delete plan -->
<div class="modal fade" id="delete-plan-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tasdiqlash:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        - Siz rosdan ham ushbu planni o'chirib tashlashni hohlaysizmi?
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
<!-- end of modal to delete plan -->

@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/>
<style>
    .j-row .input-width{
        min-width: 200px;
        max-width: 23%;
    }
    #annual{
        pointer-events: none;
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
        $(".seperator-input").on('input', function(e){
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
        // first-semiannual
        $('#first-semiannual').on('input', function(){
            let a = 0;
            let b = 0;
            if( $('#first-semiannual').val() !== '' ){
                a = parseInt($('#first-semiannual').val().replace(/\s/g, ''));
            }
            if( $('#second-semiannual').val() !== '' ){
                b = parseInt($('#second-semiannual').val().replace(/\s/g, ''));
            }
            $('#annual').val(numberWithSpaces(a+b))  
        });
        $('#second-semiannual').on('input', function(){
            let a = 0;
            let b = 0;
            if( $('#first-semiannual').val() !== '' ){
                a = parseInt($('#first-semiannual').val().replace(/\s/g, ''));
            }
            if( $('#second-semiannual').val() !== '' ){
                b = parseInt($('#second-semiannual').val().replace(/\s/g, ''));
            }
            $('#annual').val(numberWithSpaces(a+b))  
        });
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
        // delete-plan
        let plan = 0;
            $('.delete-btn').click(function(){
                plan = $(this).attr('plan')
             
            });

            $('.confirm-delete').click(function(){
                $('form[plan="'+plan+'"]').submit()
                $('#delete-plan-modal').modal('hide');
            });
    });

</script>
@endsection