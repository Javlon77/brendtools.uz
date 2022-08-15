@extends('layout')
@section('title', "Sotuv tahrirlash")
@section('header-text', "Sotuv tahrirlash")
@section('content')
{{-- to return previuos page after update --}}
{{ session(['previous' => url() -> previous() ]) }}
    <div class="container container-bg">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <form method="post" action="{{ route('feedbacks.update', [$feedback->id]) }}">
            @method('PUT')
            @csrf
            <div class="j-row">
                <div class="mb-3 input-width">
                    <label for="" class="form-label">Baho</label>
                    <select name="rank" id="" class="form-select">
                        @for( $i = 1; $i < 11; $i++ )
                            <option value="{{ $i }}" {{ $feedback ->rank == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3 input-width">
                    <label for="" class="form-label">Sharh qoldirdimi?</label>
                    <select id="reviewed" name="reviewed" class="form-select">
                        <option value="0">Yo'q</option>
                        <option value="1" {{ $feedback ->reviewed == 1 ? 'selected' : '' }} >Ha</option>
                    </select>
                </div>
                <div class="mb-3 input-width reviewed_by_client disabled-div">
                    <label for="" class="form-label">Sharh kim tomonidan qoldirildi?</label>
                    <select name="reviewed_by_client" class="form-select" id="reviewed_by_client">
                        <option value="1">Xaridor</option>
                        <option value="0" {{ $feedback ->reviewed_by_client == 0 ? 'selected' : '' }}>Menejer</option>
                    </select>
                </div>
                <div class="mb-3 w-100">
                    <label for="" class="form-label">Qo'shimcha</label>
                    <textarea name="comment" rows="5" maxlength="599" class="form-control">{{ $feedback ->comment }}</textarea>
                </div>
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
            if( $('#reviewed').val() == '1' ){
                $('.reviewed_by_client').removeClass('disabled-div')
                $('#reviewed_by_client').prop('disabled', false)
            }else{
                $('.reviewed_by_client').addClass('disabled-div')
                $('#reviewed_by_client').prop('disabled', true)
            }
            $('#reviewed').on('change', () => {
                if( $('#reviewed').val() == '1' ){
                    $('.reviewed_by_client').removeClass('disabled-div')
                    $('#reviewed_by_client').prop('disabled', false)
                }else{
                    $('.reviewed_by_client').addClass('disabled-div')
                    $('#reviewed_by_client').prop('disabled', true)
                }
            });
        });
    </script>
@endsection