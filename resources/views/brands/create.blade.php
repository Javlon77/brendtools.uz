@extends('layout') 
@section('title', "Brend qo'shish")
@section('header-text', "Brend qo'shish")
@section('content')
<div class="container container-bg">
    <form method="post" action="{{ route('brands.store') }}">
        @csrf
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="mb-3" id="brandName">
                <label for="brand" class="form-label">Brend nomi <strong style="color:red">*</strong></label>
                <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand')}}">
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success px-3 py-2 mt-3">Qo'shish</button>
            </div> 
    </form>
</div>


@endsection

