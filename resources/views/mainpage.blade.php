@extends('layout')
@section('title', 'welcome')

@section('content')

<div class="container">

<h1 class="text-center"> Brandtools CRM</h1>

<div style="display:flex; justify-content: space-around;flex-wrap: wrap;">

<a href="{{ route('client-base.create') }}" class="boxx text-center"><p>Mijoz yaratish</p><i class="bi bi-clipboard-plus" style="font-size:40px" ></i></a>

<a href="{{ route('client-base.index') }}" class="boxx text-center"><p>Mijozlar bazasi</p><i class="bi bi-clipboard-plus" style="font-size:40px" ></i></a>

<a class="boxx text-center"><p>Mahsulot qo'shish</p><i class="bi bi-clipboard-plus" style="font-size:40px" ></i></a>

<a class="boxx text-center"><p>Xaridorni tekshirish</p><i class="bi bi-clipboard-plus" style="font-size:40px" ></i></a>

<a class="boxx text-center"><p>Xarajatlar</p><i class="bi bi-clipboard-plus" style="font-size:40px" ></i></a>

<a class="boxx text-center"><p>Analitika</p><i class="bi bi-clipboard-plus" style="font-size:40px" ></i></a>
</div>

</div>







@endsection