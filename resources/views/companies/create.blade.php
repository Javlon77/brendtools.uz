@extends('layout')
@section('title', "Kompaniya qo'shish")
@section('header-text', "Kompaniya qo'shish")

@section('content')

<div class="container container-bg">
    
    <form method="post" action="{{ route('companies-base.store') }}">
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
            <div class="mb-3" id="companyName">
                <label for="company" class="form-label">Kompaniya nomi*</label>
                <input type="text" class="form-control" id="company" name="company" value="{{ old('company')}}">
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success px-3 py-2 mt-3">Qo'shish</button>
            </div> 
    </form>
            


</div>

@endsection