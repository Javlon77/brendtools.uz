@extends('layout')
@section('title', "Usta turini tahrirlash")
@section('header-text', "Usta turini tahrirlash")

@section('content')

<div class="container container-bg">
    
    <form method="post" action="{{ route('masters-base.update', $master->id) }}">
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
            <div class="mb-3" id="masterName">
                <label for="master" class="form-label">Usta turi*</label>
                <input type="text" class="form-control" id="master" name="master" value="{{ old('master')?? old('master')? : $master->master }}">
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-success px-3 py-2 mt-3">Tahrirlash</button>
    </div>
    </form>
            
  

</div>

@endsection