@extends('layout')
@section('title', "Profile")
@section('header-text', "Profile")
@section('content')

<div class="container tbl" >
   {{ $user }}

</div>


@endsection
@section('css')

<style>
   
</style>
@endsection 
@section('script') 
    <script>
        $(document).ready(function(){
          

        });

    </script>
@endsection