@extends('layout')
@section('content')
@section('header-text', "Sotuv voronkasini yaratish")
    <div class="container container-bg">
        <form method="post" action="{{ route('funnel.store') }}">
            @csrf 
            @include('funnel.form')
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success px-3 py-2 mt-3">Yaratish</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    @include('funnel.js')
@endsection
