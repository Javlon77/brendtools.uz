@extends('layout')
@section('title', 'Brend tahrirlash')
@section('header-text', 'Brend tahrirlash')

@section('content')

<div class="container container-bg">
    
    <form method="post" action="{{ route('brands.update', $brand->id) }}">
        @method('PUT')
        @csrf
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
                <label for="brand" class="form-label">Brend nomi*</label>
                <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand')?? old('brand')? : $brand->brand }}">
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-success px-3 py-2 mt-3">Tahrirlash</button>
    </div>
    </form>
            
  

</div>

@endsection