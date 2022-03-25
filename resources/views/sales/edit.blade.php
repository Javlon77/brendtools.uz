@extends('layout')
@section('title', "Sotuv tahrirlash")
@section('header-text', "Sotuv tahrirlash")
@section('content')
    <div class="container container-bg">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <form method="post" action="{{ route('sales.update', $sale->id) }}">
            @method('PUT')
            @csrf
            @include('sales.form')
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success px-3 py-2 mt-3">Tahrirlash</button>
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