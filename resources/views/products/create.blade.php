@extends('layout')
@section('title', "Mahsulot qo'shish")
@section('header-text', "Mahsulot qo'shish")
@section('content')

<div class="container container-bg">
    <form method="post" action="{{ route('products.store') }}">
        @csrf
        @include('products.form')
    </form>
</div>
@endsection
@section('script')
    @include('products.formScript')
@endsection