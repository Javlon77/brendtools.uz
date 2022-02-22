@extends('layout')
@section('title', "Mahsulotni tahrirlash")
@section('header-text', "Mahsulotni tahrirlash")

@section('content')
<div class="container container-bg">    
    <form method="post" action="{{ route('products.update', $product->id) }}">
        @method('PUT')
        @csrf
        @include('products.form')
    </form>
</div>
@endsection
@section('script')
    @include('products.formScript')
@endsection