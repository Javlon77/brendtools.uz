@extends('layout')
@section('header-text')
Sotuv voronkasi 
@endsection
@section('content')

<div class="container">
    <p class="text-end"><a href="{{ route('funnel.create') }}" class="add-new-link">Qo'shish +</a></p>
<div class="filter-by-date">
        <form action="{{ route('funnel.index') }}" class="filter-select">
        <p style="font-size:17px; margin-bottom:4px">Saralash:</p>
            <select name="order" class="form-select" id="order" onchange="this.form.submit()">
                <option value="today">Bugun</option>
                <option value="thisWeek" selected>Shu hafta</option>
                <option value="lastWeek">O'tkan hafta</option>
                <option value="thisMonth">Shu oy</option>
                <option value="lastMonth">O'tkan oy</option>
                <option value="thisYear">Shu yil</option>
                <option value="lastYear">O'tkan yil</option>
                <option value="all">Hammasi</option>
                @isset($filterFrom)
                    <option value="-" selected>-</option>
                @endisset
            </select>
        </form>
       <form action="" class="date-filter">
       <p style="font-size:17px; margin-bottom: 4px;">Vaqt oralig'i boyicha saralash:</p>
            @error('filterFrom')
                <div class="alert alert-danger py-1 mb-1">{{ $message }}</div>
            @enderror
            @error('filterTo')
                <div class="alert alert-danger py-1 mb-1">{{ $message }}</div>
            @enderror
       
        <div class="input-group">
            <input type="date" name="filterFrom" id="filterFrom" class="form-control form-control @error('filterFrom') is-invalid @enderror" value="{{ isset($filterFrom) ? $filterFrom : old('filterFrom') }}">
            <span class="input-group-text">⇆</span>
            <input type="date" name="filterTo" id="filterTo" class="form-control @error('filterTo') is-invalid @enderror" value="{{ isset($filterTo) ? $filterTo : old('filterTo') }}">
            <button type="submit" class="btn btn-secondary" >Saralash</button>    
        </div>
        </form>
    </div>

    <div class=" container f-container-shadow ">
        <div class="container f-container ">
            <div class="f-wrapper"> 
                <!-- Birinchi suhbat -->
                <div class="col-2 f-box f-sep-left sort-funnel droppable "  id="list">
                    <h6 class="f-header s-1"><p class="m-0">Birinchi suhbat</p> (<strong>{{ count($status1)? count($status1) : '0'  }}</strong>) </h6>
                    <p class="all-price"> {{ $status1->sum('price') }}</p>
                    @foreach($status1 as $s)
                        <div class="f-row" idx="{{$s->id}}">
                            <p class="f-texts"><i class="bi bi bi-hash" style="font-size:16px;color: #25ba64"> </i>{{$s->id}}</p>
                            <p class="f-texts"> <i class="bi bi-clock" style="font-size:16px;color: #25ba64"> </i>{{ \Carbon\Carbon::parse($s->updated_at)->format('Y.m.d   ') }} {{ $s->updated_at->dayName }}</p>                
                            <p class="f-texts "><i class="bi bi-person-fill" style="font-size:16px;color: #25ba64"> </i>{{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->name : ''}}</p>
                            <p class="f-texts p-number"><i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i> {{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->phone1 : ''}}</p>
                            <p class="f-texts p-number">{!! isset($clients->keyBy('id')[$s->client_id]->phone2)? '<i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i>'. $clients->keyBy('id')[$s->client_id]->phone2 : '' !!}</p>
                            <p class="f-texts"><i class="bi bi-search" style="font-size:16px;color: #25ba64"> </i> {{$s->awareness}}</p>
                            <p class="f-texts">{!! $s->product? '<i class="bi bi-cart4" style="font-size:16px;color: #25ba64"> </i> '.$s->product:'' !!}</p>
                            <p class="f-texts">{!! $s->additional? '<i class="bi bi-pin-angle-fill" style="font-size:16px;color: #25ba64"> </i> '.$s->additional:'' !!}</p>
                            <p class="f-texts f-price"> <i class="bi bi-wallet2" style="font-size:16px;color: #25ba64"> </i> {{$s->price? $s->price  : '0'}}</p>
                            <p class="f-texts f-button-group">
                                {!! isset($clients->keyBy('id')[$s->client_id])? '<a href="'.route('client-base.show',[$s->client_id]).'" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-eye-fill"></button></i></a>' : '' !!}
                                <a href="{{ route('funnel.edit',[$s->id]) }}" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-pencil-square"></button></i></a>
                                <button class="f-button f-delete" data-bs-toggle="modal" data-bs-target="#delete-funnel" idx="{{$s->id}}"><i class="bi bi-trash-fill "></i></button>
                            </p>
                        </div>
                    @endforeach
                </div>
                <!-- Ko'ndirish jarayoni-->
                <div class="col-2 f-box f-sep-left sort-funnel droppable"  id="list">
                    <h6 class="f-header s-2"><p class="m-0">Ko'ndirish jarayoni</p> (<strong>{{ count($status2)? count($status2) : '0'  }}</strong>) </h6>
                    <p class="all-price"> {{ $status2->sum('price') }}</p>
                    @foreach($status2 as $s)
                        <div class="f-row" idx="{{$s->id}}">
                            <p class="f-texts"><i class="bi bi bi-hash" style="font-size:16px;color: #25ba64"> </i>{{$s->id}}</p>
                            <p class="f-texts"> <i class="bi bi-clock" style="font-size:16px;color: #25ba64"> </i>{{ \Carbon\Carbon::parse($s->updated_at)->format('Y.m.d   ') }} {{ $s->updated_at->dayName }}</p>                
                            <p class="f-texts "><i class="bi bi-person-fill" style="font-size:16px;color: #25ba64"> </i>{{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->name : ''}}</p>
                            <p class="f-texts p-number"><i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i> {{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->phone1 : ''}}</p>
                            <p class="f-texts p-number">{!! isset($clients->keyBy('id')[$s->client_id]->phone2)? '<i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i>'. $clients->keyBy('id')[$s->client_id]->phone2 : '' !!}</p>
                            <p class="f-texts"><i class="bi bi-search" style="font-size:16px;color: #25ba64"> </i> {{$s->awareness}}</p>
                            <p class="f-texts">{!! $s->product? '<i class="bi bi-cart4" style="font-size:16px;color: #25ba64"> </i> '.$s->product:'' !!}</p>
                            <p class="f-texts">{!! $s->additional? '<i class="bi bi-pin-angle-fill" style="font-size:16px;color: #25ba64"> </i> '.$s->additional:'' !!}</p>
                            <p class="f-texts f-price"> <i class="bi bi-wallet2" style="font-size:16px;color: #25ba64"> </i> {{$s->price? $s->price  : '0'}}</p>
                            <p class="f-texts f-button-group">
                                {!! isset($clients->keyBy('id')[$s->client_id])? '<a href="'.route('client-base.show',[$s->client_id]).'" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-eye-fill"></button></i></a>' : '' !!}
                                <a href="{{ route('funnel.edit',[$s->id]) }}" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-pencil-square"></button></i></a>
                                <button class="f-button f-delete" data-bs-toggle="modal" data-bs-target="#delete-funnel" idx="{{$s->id}}"><i class="bi bi-trash-fill "></i></button>
                            </p>
                        </div>
                    @endforeach
                </div>
                <!-- Bitm tuzildi -->
                <div class="col-2 f-box f-sep-left sort-funnel droppable "  id="list">
                    <h6 class="f-header s-3"><p class="m-0">Bitm tuzildi</p> (<strong>{{ count($status3)? count($status3) : '0'  }}</strong>) </h6>
                    <p class="all-price"> {{ $status3->sum('price') }}</p>
                    @foreach($status3 as $s)
                        <div class="f-row" idx="{{$s->id}}">
                            <p class="f-texts"><i class="bi bi bi-hash" style="font-size:16px;color: #25ba64"> </i>{{$s->id}}</p>
                            <p class="f-texts"> <i class="bi bi-clock" style="font-size:16px;color: #25ba64"> </i>{{ \Carbon\Carbon::parse($s->updated_at)->format('Y.m.d   ') }} {{ $s->updated_at->dayName }}</p>                
                            <p class="f-texts "><i class="bi bi-person-fill" style="font-size:16px;color: #25ba64"> </i>{{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->name : ''}}</p>
                            <p class="f-texts p-number"><i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i> {{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->phone1 : ''}}</p>
                            <p class="f-texts p-number">{!! isset($clients->keyBy('id')[$s->client_id]->phone2)? '<i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i>'. $clients->keyBy('id')[$s->client_id]->phone2 : '' !!}</p>
                            <p class="f-texts"><i class="bi bi-search" style="font-size:16px;color: #25ba64"> </i> {{$s->awareness}}</p>
                            <p class="f-texts">{!! $s->product? '<i class="bi bi-cart4" style="font-size:16px;color: #25ba64"> </i> '.$s->product:'' !!}</p>
                            <p class="f-texts">{!! $s->additional? '<i class="bi bi-pin-angle-fill" style="font-size:16px;color: #25ba64"> </i> '.$s->additional:'' !!}</p>
                            <p class="f-texts f-price"> <i class="bi bi-wallet2" style="font-size:16px;color: #25ba64"> </i> {{$s->price? $s->price  : '0'}}</p>
                            <p class="f-texts f-button-group">
                                {!! isset($clients->keyBy('id')[$s->client_id])? '<a href="'.route('client-base.show',[$s->client_id]).'" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-eye-fill"></button></i></a>' : '' !!}
                                <a href="{{ route('funnel.edit',[$s->id]) }}" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-pencil-square"></button></i></a>
                                <button class="f-button f-delete" data-bs-toggle="modal" data-bs-target="#delete-funnel" idx="{{$s->id}}"><i class="bi bi-trash-fill "></i></button>
                            </p>
                        </div>
                    @endforeach
                </div>   
                <!-- To'lov qilindi -->
                <div class="col-2 f-box f-sep-left sort-funnel droppable "  id="list">
                    <h6 class="f-header s-4"><p class="m-0">To'lov qilindi</p> (<strong>{{ count($status4)? count($status4) : '0'  }}</strong>) </h6>
                    <p class="all-price"> {{ $status4->sum('price') }}</p>
                    @foreach($status4 as $s)
                        <div class="f-row" idx="{{$s->id}}">
                            <p class="f-texts"><i class="bi bi bi-hash" style="font-size:16px;color: #25ba64"> </i>{{$s->id}}</p>
                            <p class="f-texts"> <i class="bi bi-clock" style="font-size:16px;color: #25ba64"> </i>{{ \Carbon\Carbon::parse($s->updated_at)->format('Y.m.d   ') }} {{ $s->updated_at->dayName }}</p>                
                            <p class="f-texts "><i class="bi bi-person-fill" style="font-size:16px;color: #25ba64"> </i>{{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->name : ''}}</p>
                            <p class="f-texts p-number"><i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i> {{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->phone1 : ''}}</p>
                            <p class="f-texts p-number">{!! isset($clients->keyBy('id')[$s->client_id]->phone2)? '<i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i>'. $clients->keyBy('id')[$s->client_id]->phone2 : '' !!}</p>
                            <p class="f-texts"><i class="bi bi-search" style="font-size:16px;color: #25ba64"> </i> {{$s->awareness}}</p>
                            <p class="f-texts">{!! $s->product? '<i class="bi bi-cart4" style="font-size:16px;color: #25ba64"> </i> '.$s->product:'' !!}</p>
                            <p class="f-texts">{!! $s->additional? '<i class="bi bi-pin-angle-fill" style="font-size:16px;color: #25ba64"> </i> '.$s->additional:'' !!}</p>
                            <p class="f-texts f-price"> <i class="bi bi-wallet2" style="font-size:16px;color: #25ba64"> </i> {{$s->price? $s->price  : '0'}}</p>
                            <p class="f-texts f-button-group">
                                {!! isset($clients->keyBy('id')[$s->client_id])? '<a href="'.route('client-base.show',[$s->client_id]).'" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-eye-fill"></button></i></a>' : '' !!}
                                <a href="{{ route('funnel.edit',[$s->id]) }}" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-pencil-square"></button></i></a>
                                <button class="f-button f-delete" data-bs-toggle="modal" data-bs-target="#delete-funnel" idx="{{$s->id}}"><i class="bi bi-trash-fill "></i></button>
                            </p>
                        </div>
                    @endforeach
                </div>
                <!-- Yakunlandi -->
                <div class="col-2 f-box f-sep-left sort-funnel droppable "  id="list">
                    <h6 class="f-header s-5"><p class="m-0">Yakunlandi</p> (<strong>{{ count($status5)? count($status5) : '0'  }}</strong>) </h6>
                    <p class="all-price"> {{ $status5->sum('price') }}</p>
                    @foreach($status5 as $s)
                        <div class="f-row" idx="{{$s->id}}">
                            <p class="f-texts"><i class="bi bi bi-hash" style="font-size:16px;color: #25ba64"> </i>{{$s->id}}</p>
                            <p class="f-texts"> <i class="bi bi-clock" style="font-size:16px;color: #25ba64"> </i>{{ \Carbon\Carbon::parse($s->updated_at)->format('Y.m.d   ') }} {{ $s->updated_at->dayName }}</p>                
                            <p class="f-texts "><i class="bi bi-person-fill" style="font-size:16px;color: #25ba64"> </i>{{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->name : ''}}</p>
                            <p class="f-texts p-number"><i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i> {{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->phone1 : ''}}</p>
                            <p class="f-texts p-number">{!! isset($clients->keyBy('id')[$s->client_id]->phone2)? '<i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i>'. $clients->keyBy('id')[$s->client_id]->phone2 : '' !!}</p>
                            <p class="f-texts"><i class="bi bi-search" style="font-size:16px;color: #25ba64"> </i> {{$s->awareness}}</p>
                            <p class="f-texts">{!! $s->product? '<i class="bi bi-cart4" style="font-size:16px;color: #25ba64"> </i> '.$s->product:'' !!}</p>
                            <p class="f-texts">{!! $s->additional? '<i class="bi bi-pin-angle-fill" style="font-size:16px;color: #25ba64"> </i> '.$s->additional:'' !!}</p>
                            <p class="f-texts f-price"> <i class="bi bi-wallet2" style="font-size:16px;color: #25ba64"> </i> {{$s->price? $s->price  : '0'}}</p>
                            <p class="f-texts f-button-group">
                                {!! isset($clients->keyBy('id')[$s->client_id])? '<a href="'.route('client-base.show',[$s->client_id]).'" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-eye-fill"></button></i></a>' : '' !!}
                                <a href="{{ route('funnel.edit',[$s->id]) }}" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-pencil-square"></button></i></a>
                                <button class="f-button f-delete" data-bs-toggle="modal" data-bs-target="#delete-funnel" idx="{{$s->id}}"><i class="bi bi-trash-fill "></i></button>
                            </p>
                        </div>
                    @endforeach
                </div>
                <!-- Qaytarib berildi -->
                <div class="col-2 f-box f-sep-left sort-funnel droppable "  id="list">
                    <h6 class="f-header s-6"><p class="m-0">Qaytarib berildi</p> (<strong>{{ count($status6)? count($status6) : '0'  }}</strong>) </h6>
                    <p class="all-price"> {{ $status6->sum('price') }}</p>
                    @foreach($status6 as $s)
                        <div class="f-row" idx="{{$s->id}}">
                            <p class="f-texts"><i class="bi bi bi-hash" style="font-size:16px;color: #25ba64"> </i>{{$s->id}}</p>
                            <p class="f-texts"> <i class="bi bi-clock" style="font-size:16px;color: #25ba64"> </i>{{ \Carbon\Carbon::parse($s->updated_at)->format('Y.m.d   ') }} {{ $s->updated_at->dayName }}</p>                
                            <p class="f-texts "><i class="bi bi-person-fill" style="font-size:16px;color: #25ba64"> </i>{{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->name : ''}}</p>
                            <p class="f-texts p-number"><i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i> {{isset($clients->keyBy('id')[$s->client_id])? $clients->keyBy('id')[$s->client_id]->phone1 : ''}}</p>
                            <p class="f-texts p-number">{!! isset($clients->keyBy('id')[$s->client_id]->phone2)? '<i class="bi bi-telephone-fill" style="font-size:16px;color: #25ba64"> </i>'. $clients->keyBy('id')[$s->client_id]->phone2 : '' !!}</p>
                            <p class="f-texts"><i class="bi bi-search" style="font-size:16px;color: #25ba64"> </i> {{$s->awareness}}</p>
                            <p class="f-texts">{!! $s->product? '<i class="bi bi-cart4" style="font-size:16px;color: #25ba64"> </i> '.$s->product:'' !!}</p>
                            <p class="f-texts">{!! $s->additional? '<i class="bi bi-pin-angle-fill" style="font-size:16px;color: #25ba64"> </i> '.$s->additional:'' !!}</p>
                            <p class="f-texts f-price"> <i class="bi bi-wallet2" style="font-size:16px;color: #25ba64"> </i> {{$s->price? $s->price  : '0'}}</p>
                            <p class="f-texts f-button-group">
                                {!! isset($clients->keyBy('id')[$s->client_id])? '<a href="'.route('client-base.show',[$s->client_id]).'" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-eye-fill"></button></i></a>' : '' !!}
                                <a href="{{ route('funnel.edit',[$s->id]) }}" class="f-button f-edit px-2"><button class="border-0 m-0 p-0"><i class="bi bi-pencil-square"></button></i></a>
                                <button class="f-button f-delete" data-bs-toggle="modal" data-bs-target="#delete-funnel" idx="{{$s->id}}"><i class="bi bi-trash-fill "></i></button>
                            </p>
                        </div>
                    @endforeach
                </div>             
            </div>
        </div>
    </div>
</div>


<!-- Modal delete funnel -->
<div class="modal fade text-dark" id="delete-funnel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rostan ham o'chirishni hohlaysizmi?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      - Siz rosdan ham ushbu savdo varonkasini o'chirib tashlashni hohlaysizmi?
        <br><br>
        - Bu tizimda ma'lum bir muammolarga sabab bo'lishi mumkin!!!
        <br><br>
        - O'chirmaslik tavsiya etiladi!!!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        <button type="button" class="btn btn-danger f-felete-accepted">O'chirish</button>
      </div>
    </div>
  </div>
</div>
<!-- end of modal delete funnel -->

@endsection
@section('script')
    <script src="/js/drag.min.js"></script> 
    <script >
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        // saralash
        @isset($date)
            $('#order option[value="{{ $date }}"]').attr("selected","selected")
        @endisset
        //scroll
        jQuery.fn.hasScrollBar = function(direction) {
            if (direction == 'vertical')
            {
            return this.get(0).scrollHeight > this.innerHeight();
            }
            else if (direction == 'horizontal')
            {
            return this.get(0).scrollWidth > this.innerWidth();
            }
            return false;
        }

        if($('.f-container').hasScrollBar('horizontal')==true){
            $('.f-container-shadow').addClass('f-container-shadow-right')
        };

        $('.f-container').scroll(function(){
            var maxScrollLeft = $('.f-container')[0].scrollWidth - $('.f-container')[0].clientWidth;
            if($('.f-container').scrollLeft()>1){
                $('.f-container-shadow').addClass('f-container-shadow-left')
            }
            else  {
                $('.f-container-shadow').removeClass('f-container-shadow-left')
            }
            if($('.f-container').scrollLeft()<maxScrollLeft){
                $('.f-container-shadow').addClass('f-container-shadow-right')
            }
            else  {
                $('.f-container-shadow').removeClass('f-container-shadow-right')
            } 
        });
        //end of scroll

        // sort funnel stages
      
        let beforeChange = '';
        let beforeChangeCount = 0;
        $('.sort-funnel').sortable({
            accept:'*',
            activeClass:'',
            cancel:'input, textarea, button, select, option',
            connectWith: '.droppable',
            disabled:false,
            forcePlaceholderSize:true,
            handle:false,
            initialized:false,
            items:'li, div',
            placeholder:'placeholder',
            placeholderTag:null,
            receiveHandler:null 
        })
        .on('sortable:start',function(e, ui){
            if (this === ui.item.parent()[0]) {
                beforeChange=ui['item'].parent()[0].childNodes[1].childNodes[0].innerText;
                beforeChangeCount =ui['item'].parent()[0].childNodes[1].childNodes[2].innerText
                countbefore = ui['item'].parent()[0].childNodes[1].childNodes[2].innerText;
                countafter = ui['item'].parent()[0].childNodes[1].childNodes[2].innerText = countbefore-1;
            }
        })
        .on('sortable:update',function(e, ui){
            let a =ui['item'].parent()[0].childNodes[1];
            if (this === ui.item.parent()[0]  ) {
                let changeCount = ui['item'].parent()[0].childNodes[1].childNodes[2];
                let parse = parseInt(changeCount.innerText);
                let result = parse+1;
                changeCount.innerText= result;
                if(beforeChange!==a.childNodes[0].innerText){
                    let status = a.childNodes[0].innerText;
                    let token = $('meta[name=token]').attr('content');
                    let id = ui['item'].attr('idx');
                    // header setup                  
                    $.ajax({
                        method:'PUT',
                        url:'/api/funnel/update',
                        headers:{ "Authorization" : token},
                        dataType:'json',
                        data:{
                            'id': id,
                            'status': status
                        },
                        success: function(res){
                            setTimeout(function () {
                                location.reload(true);
                            }, 100);
                        },
                        error: function (res) {
                            alert('Serverda hatolik yuz berdi: \n'+ res.responseJSON.message)
                            location.reload();
                        }
                    });
                }
            }
            // window.setTimeout(function(){location.reload()},100)
        })

        // end sort funnel stages

        //delete client sales funnel
        let delteFunnel = '';
        $('.f-delete').click(function(){
            delteFunnel= $(this).attr('idx');
        });
        $('.f-felete-accepted').click(function(){
            let token = $('meta[name=token]').attr('content');
            let id = delteFunnel;
            $.ajax({
                method:'PUT',
                url:"http://bt-crm.loc/api/funnel/"+id,
                headers:{ "Authorization" : token},
                success: function(res){
                    $('#delete-funnel').modal('hide');
                    $('.f-row[idx="'+id+'"]').hide()
                },
                error: function (res) {
                    alert('Serverda hatolik yuz berdi: \n'+ res.responseJSON.message)
                    location.reload();
                }
            });
        });
        //end of delete funnel

        //number seperator to money format
        function numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
        for (let i=0; i < $('.f-price').length; i++ ) {     
            $(".f-price")[i].childNodes[2].textContent = numberWithSpaces($(".f-price")[i].childNodes[2].textContent) + ' UZS'
        }

        for (let i=0; i < $('.all-price').length; i++ ) {
            let a= parseInt($(".all-price")[i].textContent);
            $(".all-price")[i].textContent = numberWithSpaces(a)+ ' UZS';
        }
        for (let i=0; i < $('.p-number').length; i++ ) {
            if( $('.p-number')[i].childNodes[1] !== undefined){
                let a = $('.p-number')[i].childNodes[1].textContent.replace(/\s+/g, "");
                let phoneSeperator= a.slice(0, 2) + ' '+ a.slice(2, 5) + '-' + a.slice(5, 7) + '-' + a.slice(7, 9)
                $('.p-number')[i].childNodes[1].textContent=phoneSeperator
            }
        }
    });
    </script>
@endsection
@section('css')
<style>
    body{
        padding-bottom:1rem
    }
    .container{
        width:100%;
        max-width:1600px;
       
    }
    .f-container-shadow{
        position:relative;
        padding: 0;
    }
    .f-container-shadow-left::before{
        content: '';
        position: absolute;
        left: -7px;
        top: -3px;
        width: 1px;
        height: 100%;
        padding: 0;
        box-shadow: 8px 0 5px 1px #2c2c2c;
        box-sizing: border-box;
        z-index: 1;
        pointer-events: none;
    }
    .f-container-shadow-right:after{
        content: '';
        position: absolute;
        right: 7px;
        top: 0;
        width: 1px;
        height: 100%;
        padding: 0;
        box-shadow: 8px 0 5px 1px #2c2c2c;
        box-sizing: border-box;
        z-index: 1;
        pointer-events: none;
    }
    .f-container{
        overflow-x: auto;
    }
   
    .f-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    .f-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 5px;
    }
    .f-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 5px;
    }
    .f-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    .f-wrapper{
        min-width:1400px;
        min-height:500px;
        display: flex;
        flex-wrap: wrap;
        --bs-gutter-x: 1.5rem;
        --bs-gutter-y: 0;
        display: flex;
        flex-wrap: wrap;
        margin-top: calc(-1 * var(--bs-gutter-y));
        margin-right: calc(-.5 * var(--bs-gutter-x));
        margin-left: calc(-.5 * var(--bs-gutter-x));
        
    }
    .f-box{
        padding: 0 8px 0 0;
    }
    .f-sep-left{
        border-left: 1px dashed rgba(255,255,255,.55);
        border-top-left-radius: 5px;
    }
    .f-header{
        background-color: #39a8ef;
        border-radius: 3px 2px 2px 3px;
        padding: 0px 10px;
        font-size: 16px;
        position: relative;
        height: 30px;
        margin-left: -1px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
    }
    .f-header::after{
        content: '';
        display: block;
        position: absolute;
        width: 0;
        height: 0;
        border: 14px solid transparent;
        border-right: 0px;
        border-left: 4px solid #39a8ef;
        border-radius: 0px;
        right: -4px;
        top: 2px;
    }
    .f-row{
        width: 99%;
        background-color: white;
        color: black;
        padding: 5px 5px;
        margin: 4px -1px;
        border-left: 4px solid #aeaeff;
        font-size: 14px;
        border-radius: 4px;
        transition: box-shadow 0.2s linear;
        cursor: grab;
    }
    .f-row:hover{
        box-shadow: -4px 0px 0px #0036e45c inset;
    }
    .f-row:active{
        cursor: grab!important;
    }
    .all-price{
        margin: 0 auto;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        background-color: #ffffff14;
        padding: 4px;
        border-radius: 2px;
        margin-bottom: 3px;
    }
    .f-texts{
        margin: 0 0 3px 0;
        /* background-color: #0036d51a; */
        padding: 0 0 0 7px;
        border-radius: 5px;
    }
    .f-button-group{
        display: flex;
        justify-items: center;
        justify-content: space-around;
        margin-top:10px;
    }
    .f-button{
        font-size:16px;
        color:grey;
        cursor:pointer;
        border: none;
        border-radius: 5px;
        background-color: #f9f9f9d1;
    }
    .f-show:hover{
        color:black
    }
    .f-edit button:hover{
        color:#ebca0f;
        background-color:transparent;
    }
    .f-edit button{
        background-color:transparent;
    }
    .f-delete:hover{
        color:red
    }
    .f-price{
        font-weight: 500;
    }
    .s-1{
        background:#34568B;
    }
    .s-1::after{
        border-left: 4px solid #34568B;
    }
    .s-2{
        background: #EFC050;
    }
    .s-2::after{
        border-left: 4px solid #EFC050;
    }
    .s-3{
        background: #45B8AC;
    }
    .s-3::after{
        border-left: 4px solid #45B8AC;
    }
    .s-4{
        background: #009B77;
    }
    .s-4::after{
        border-left: 4px solid #009B77;
    }
    .s-5{
        background: #5B5EA6;
    }
    .s-5::after{
        border-left: 4px solid #5B5EA6;
    }
    .s-6{
        background: #9B2335;
    }
    .s-6::after{
        border-left: 4px solid #9B2335;
    }
    .f-wrapper::before{
        content:'dasdsa';
        position: absolute;
    }
    .filter-select{
        width:180px;
        margin-right:10px;
        margin-bottom: 6px;
    }
    .date-filter{
        width:500px;
    }
    .filter-by-date{
        display:flex;
        flex-wrap: wrap;
        margin-top:10px;
        margin-bottom: 30px;
    }
    @media (max-width:447px){
        .date-filter{
        width:100%;
    }
    }

</style>
@endsection