@extends('layout')
@section('title', "$header")
@section('header-text', "$header")
@section('content')

<div class="container tbl" >
    
    <div class="task-nav">
        <p class="task-nav-active" id="task-current">{{ $header }}</p>
        <p id="task-history">Vazifalar tarixi</p>
    </div>

    <div class="w-100 current-table">
        <table class="table bg-white" style="width:100%;" id="c-table" data-page-length='10'>
            <thead>
                <tr>
                    <th class="px-4">№</th>
                    <th>Mavzu</th>
                    <th>Vazifa</th>
                    <th>Deadline</th>
                    <th>Qolgan vaqt</th>
                    <th>Buyurtmachi</th>
                    <th class="px-4">harakat</th>
                </tr>          
            </thead>
            <tbody> 
                @foreach($ongoing as $task)
                <tr>
                    <td class="px-4">{{ $loop -> index+1 }}</td>
                    <td style="font-weight: 600; font-size: 16px; line-height: 19px;">{{ $task -> task_header}}  <p class="created-at">{{ $task -> created_at -> format('d.m.Y')}}</p> </td>
                    <td>{{ $task -> task}}</td>
                    <td>{{ $task -> deadline_at ? $task -> deadline_at -> format('d.m.Y') : '-'}}</td>
                    <td class="timely {{ isset($task -> deadline_at)? now() > $task -> deadline_at ? 'time-over' : '' : ''}}">{{ isset($task -> deadline_at)? now() > $task -> deadline_at ? '-' : '' : ''}} {{ $task -> deadline_at ? now() -> diff( $task -> deadline_at, false ) -> format('%d kun %h soat %i daqiqa') : '-' }}</td>
                    <td>{{ $users -> find($task->tasker_id) -> name }}</td>
                    <td class="px-4 d-flex">
                        <form action="{{ route('tasks.update', $task -> id) }}" complete="{{ $task -> id }}"  method="post">
                            @method('PUT')
                            @csrf
                            <button type="button" class="btn btn-success completed-button complate-task" data-bs-toggle="modal" data-bs-target="#complete-confirm-modal">✓</button>
                        </form>
                        <form action="{{ route('tasks.destroy', $task -> id) }}" delete="{{ $task -> id }}"  method="post">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal">✕</button>
                        </form>
                    </td>    
                </tr>  
                @endforeach
            </tbody>
        </table>
    </div>



    <div class="w-100 history-table">
        <table class="table bg-white" style="width:100%;" id="b-table" data-page-length='10'>
            <thead>
                <tr>
                    <th class="px-4">№</th>
                    <th>Mavzusi</th>
                    <th>Vazifa</th>
                    <th>Deadline</th>
                    <th>Bajarildi</th>
                    <th>Buyurtmachi</th>
                    <th class="px-4">harakat</th>
                </tr>          
            </thead>
            <tbody> 
                @foreach($done as $task)
                <tr>
                    <td class="px-4">{{ $loop -> index+1 }}</td>
                    <td style="font-weight: 600; font-size: 16px; line-height: 19px;">{{ $task -> task_header}}  <p class="created-at">{{ $task -> created_at -> format('d.m.Y')}}</p> </td>
                    <td>{{ $task -> task}}</td>
                    <td>{{ $task -> deadline_at ? $task -> deadline_at -> format('d.m.Y') : '-'}}</td>
                    <td class="timely {{ isset($task -> deadline_at)? $task -> updated_at > $task -> deadline_at ? 'time-over' : '' : ''}}">{{ $task -> updated_at -> format('d.m.Y')  }}</td>
                    <td>{{ $users -> find($task->tasker_id) -> name }}</td>
                    <td class="px-4"> 
                        <button class="btn btn-secondary completed-button disabled" >Bajarildi</button>
                    </td>
                </tr>  
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- modal to complete task -->
<div class="modal fade" id="complete-confirm-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tasdiqlash:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Vazifa rostdan ham bajarildimi?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yo'q</button>
        <button type="button" class="btn btn-success confirm-complete" style="width:auto">Ha</button>
      </div>
    </div>
  </div>
</div>
<!-- end of modal to complete task -->

<!-- modal to complete task -->
<div class="modal fade" id="delete-confirm-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tasdiqlash:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Rostdan ham o'chirishni hohlaysizmi?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yo'q</button>
        <button type="button" class="btn btn-danger confirm-delete" style="width:auto">Ha</button>
      </div>
    </div>
  </div>
</div>
<!-- end of modal to complete task -->



@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
<style>
    
    .delete-button{
        border-radius: 50px;
        padding: 0px 13px;
        font-weight: 600;
        font-size: 11px;
        margin-left: 10px;
    }
    .completed-button{
        border-radius: 50px;
        font-weight: 600;
        font-size: 11px;
        padding: 0px 13px;
    }
    .history-table{
        height:0;
        overflow: hidden;
    }
    .task-nav{
        display: flex;
    }
    .task-nav p{
        margin-right: 30px;
        font-size: 14px;
        line-height: 17px;
        text-transform: uppercase;
        margin-bottom: 0;
        cursor: pointer;
        color:#ffffff;
        opacity: 0.5;
    }
    .task-nav-active{
        font-weight: 700;
        font-size: 14px;
        color: #F0F6FF;
        opacity: 1!important;
    }
    .timely{
        color:green;
    }
    .time-over{
        color:red;
    }
    .created-at{
        margin:8px 0 0 0;
        font-size: 12px;
        line-height: 15px;
    }
   
  
</style>
@endsection 
@section('script') 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            // complete task
            let complete_id = '';
            $('.complate-task').click(function(){
                complete_id = $(this).parent().attr('complete');
            });

            $('.confirm-complete').click(function(){
                $('form[complete="'+complete_id+'"]').submit()
                $('#complete-confirm-modal').modal('hide');
            });
            
            // delete task
            let delete_id = '';
            $('.delete-button').click(function(){
                delete_id = $(this).parent().attr('delete');
            });

            $('.confirm-delete').click(function(){
                $('form[delete="'+delete_id+'"]').submit()
                $('#delete-confirm-modal').modal('hide');
            });
            

            // nav change
            $('#task-current').click(function(){
                $('.history-table').hide();
                $('.current-table').show();
                $('#task-current').addClass('task-nav-active');
                $('#task-history').removeClass('task-nav-active');
            });
            $('#task-history').click(function(){
                $('.history-table').css('height','auto')
                $('.current-table').hide();
                $('.history-table').show();
                $('#task-history').addClass('task-nav-active');
                $('#task-current').removeClass('task-nav-active');
            });
            // first table
            $('#c-table').DataTable({
                dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                language: {
                    "lengthMenu": " _MENU_ tadan",
                    "zeroRecords": "Hechnarsa topilmadi",
                    "info": "_PAGES_ dan _PAGE_ ",
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

            //second-table
            $('#b-table').DataTable({
                dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
                language: {
                    "lengthMenu": " _MENU_ tadan",
                    "zeroRecords": "Hechnarsa topilmadi",
                    "info": "_PAGES_ dan _PAGE_ ",
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
        });

    </script>
@endsection