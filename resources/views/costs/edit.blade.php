@extends('layout') 
@section('title', "Xarajatni tahrirlash")
@section('header-text', "Xarajatni tahrirlash")
@section('content') 
<div class="container container-bg"> 
    <form method="post" action="{{ route('costs.update', $cost -> id) }}">
        @csrf
        @method('PUT')
        @if(session()->has('message'))
        <div class="alert alert-success"> 
            {{ session()->get('message') }}
        </div>
        @endif
        <div class="j-row">
            {{-- created_at --}}
            <div class="input-width mb-3">
                <label for="" class="form-label j-label">Vaqt </label>
                <input type="date" class="form-control" name="created_at" value="{{ $cost -> created_at -> format('Y-m-d') }}">
            </div>
            <!-- bo'lim -->         
            <div class="input-width">
                <label class="form-label">Maqsad</label>
                <div class="input-group">
                    <select name="reason" class="form-select" aria-label="Default select example" aria-describedby="button-addon2">
                        <option value="Reklama">Reklama</option>
                        <option value="Aktiv">Aktiv</option>
                        <option value="Boshqalar">Boshqalar</option>
                    </select>
                </div> 
            </div>
            <!-- bo'lim --> 

            <!-- category-->         
            <div class="input-width">
                <label class="form-label">Kategorya</label>
                <div class="input-group">
                    <select name="category_id" class="form-select" aria-label="Default select example" aria-describedby="button-addon2">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>  
            </div>
            <!--end of category-->  

            <!-- cost -->
            <div class="mb-3 input-width">
                <label class="form-label">Xarajat summasi <strong class="text-danger">*</strong></label>
                <div class="input-group">
                    <input type="text" class="form-control text-end input-seperator" name="cost" id="cost" value="{{ $cost -> cost }}" autocomplete="off" required>
                    <span class="input-group-text">So'm</span>
                </div>
            </div> 
            <!-- end of cost -->

            <!-- additional -->
            <div class="mb-3 input-width" style="width:66%">
                <label class="form-label">Qo'shimcha</label>
                <div class="input-group">
                    <textarea name="additional" id="additional" cols="30" rows="1" class="form-control">{{ $cost -> additional }}</textarea>
                </div>
            </div> 
            <!-- additional -->
            

        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-success px-3 py-2 mt-3">Tahrirlash</button>
        </div>
    </form>             
</div>




@endsection

@section('script')
<script>

$(document).ready(function(){

    //number seperator to money format
    function numberWithSpaces(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }
    for (let i=0; i < $('.seperator').length; i++ ) {     
        $(".seperator")[i].innerText=numberWithSpaces($(".seperator")[i].innerText)+' UZS' ;
    }
    $(".input-seperator").val(numberWithSpaces($(".input-seperator").val()))
    //number seperator to money format in input
    $("#cost").on('input', function(e){
        if (this.value !== '') {
            let a = $(this).val().replace(/\s/g, '')
            let p = parseInt(a)
            if (isNaN(p)) {
                $(this).val('')
            } else {
                $(this).val(numberWithSpaces(p))
            }
        }
    });
    // end of number seperator to money format
    // select options 
    $('select[name=reason] option[value={{ $cost->reason ?? '' }}]').prop('selected', true)
    $('select[name=category_id] option[value={{ $cost->category_id ?? '' }}]').prop('selected', true)
    
  
});
</script>
@endsection

@section('css')

<style>

</style>

@endsection