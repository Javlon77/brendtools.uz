@extends('layout')
@section('title', "Sotuv qo'shish")
@section('header-text', "Sotuv qo'shish")
@section('content')
<div class="container container-bg">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="post" action="{{ route('sales.store') }}">
        @csrf
        @include('sales.form')
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-success px-3 py-2 mt-3">Qo'shish</button>
        </div>
    </form>
</div>
@endsection
@section('script')
    @include('sales.js')
@endsection

@section('css')
    @include('sales.css')
@endsection