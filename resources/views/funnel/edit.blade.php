@extends('layout')
@section('title', "Sotuv voronkasini tahrirlash")
@section('header-text', "Sotuv voronkasini tahrirlash")
@section('content')
    {{ session(['previous' => url() -> previous() ]) }}
    <div class="container container-bg">
        <form method="post" action="{{ route('funnel.update', $funnel) }}">
            @method('PUT')
            @csrf
            @include('funnel.form')
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success px-3 py-2 mt-3">Tahrirlash</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    @include('funnel.js')
@endsection