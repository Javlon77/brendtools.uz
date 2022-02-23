@extends('layout')
@section('title', "Vazifalar")
@section('header-text', "Vazifalar")
@section('content')

<div class="container" >
    <!-- xodimlar -->
    <h5>Xodimlar</h5>   
    <div class="wrapper ">    
    <a href="/tasks/{{ $myprofile->id }}" class="container-bg  box ">
        Mening profilim 
        <br> 
        ({{ App\Models\Task::where('user_id',$myprofile->id) -> where('status', 0)->count() }})
    </a>

    <a href="/tasks/0" class="container-bg  box ">
        Umumiy 
        <br> 
        ({{ App\Models\Task::where('user_id', 0) -> where('status', 0)->count() }})
    </a>

    @foreach($users as $user)
    @if($myprofile->id !== $user->id)
    <a href="/tasks/{{ $user->id }}" class="container-bg  box">
     {{ $user->name }}  
     <br> 
     ({{ App\Models\Task::where('user_id',$user->id) -> where('status', 0)->count() }})
    </a>
    @endif
    @endforeach    
    </div>
    <!-- umumiy vazifalar -->
    <h5 style="margin-top:2rem">Vazifa qo'shish</h5>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
        {{ session('success') }}
        </div>
    @endif

    <div class="w-100 container-bg mt-0">
        <form method="post" action="{{ route('tasks.store') }}">
            @csrf
            <div class="j-row">
                <div class="input-width">
                <label for="" class="form-label j-label">Kimga </label>
                    <select name="user_id" id="" class="form-select" >
                        <option value="0" selected>Umumiy</option>
                        @foreach($users as $user)
                            @if($user->id==$myprofile->id)
                                <option value="{{ $myprofile->id }}">Men</option>
                            @else
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                
                <div class="input-width">
                    <label for="" class="form-label j-label">Vazifa bajarish muddati</label>
                    <input type="date" class="form-control" name="deadline_at">
                </div>

                <div class="input-width">
                    <label for="" class="form-label j-label">Mavzu <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" required maxlength="50" name="task_header">
                </div>

                <div class="input-width w-100">
                        <label for="" class="form-label j-label mt-3">Vazifa <strong class="text-danger">*</strong></label>
                        <textarea name="task" id="" cols="30" rows="5" class="form-control" maxlength="1000" required></textarea>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success px-3 py-2 mt-3">Qo'shish</button>
            </div>
        </form>
    </div>

</div>

</div>


@endsection
@section('css')

<style>
    .wrapper{
        display: flex;
        flex-wrap: wrap;
        width: 100%;

    }
   .box{
       padding: 10px!important;
       margin: 0!important;
       width: 210px!important;
       height: 100px!important;
       border-radius: 10px!important;
       display: flex;
       align-items: center;
       justify-content: center;
       text-align: center;
       color:white;
       text-decoration:none;
       transition:all 0.1s linear;
       margin: 15px 15px 0 0!important;
   }
   .box:hover{
       cursor:pointer;
       background-color: #92938c3b;
       color:white;
   }

</style>
@endsection 
@section('script') 
    <script>
        $(document).ready(function(){

            //set min value for input - deadline_at

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;

            $('input[name="deadline_at"]').attr('min',today)

        });

    </script>
@endsection