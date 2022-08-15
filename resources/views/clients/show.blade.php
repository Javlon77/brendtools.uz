@extends('layout')
@section('title', 'Mijoz tarixi')
@section('header-text', 'Mijoz tarixi')

@section('content')

<div class="container mb-5">

    <div class="row h-wrapper">

        <div class="col-12 h-header">
            <a href="{{ url() -> previous() }}" class="back-link"><i class="bi bi-arrow-left"></i></a>
        </div>

        <hr class="hr-sperator">

        <div class="h-body">

            <!-- client box -->
            <div class="client-box ">
                <div class="c-name-wrapper">
                    <i class="bi bi-person-fill icons" style="font-size:20px;"> </i>
                    {{ $client -> language }}
                    <p class="c-name">{{ $client->name }} {{ $client->surname }}</p>
                </div>
                @isset($company)
                <p class="company-name">{{ $company }}</p>
                @endisset
                @isset($master)
                <p class="company-name">{{ $master }}</p>
                @endisset
                <hr style="color:lightgray">

                <div class="address-wrapper">
                    <i class="bi bi-geo-alt-fill icons" style="font-size:12px"></i>
                    <div class="adress">
                        <p class="region-name"> {{ $client->region }}</p>
                        <p class="address-name"> {{ $client->address }}</p>
                    </div>
                </div>

                <div class="phone-wrapper">
                    <div class="phone">
                        <i class="bi bi-telephone-fill icons" style="font-size:12px"> </i>
                        <p class="p-number tel" >{{ $client->phone1 }}</p>
                    </div>
                    @isset($client->phone2)
                    <div class="phone">
                        <i class="bi bi-telephone-fill icons" style="font-size:12px"> </i>
                        <p class="p-number tel">{{ $client->phone2 }}</p>
                    </div>
                    @endisset
                </div>

                <div class="info-wrapper">
                    <i class="bi bi-person-fill icons" style="font-size:13px"> </i>
                    <div class="info-wrapper-inside">
                        <p class="c-type">{{ $client->type }}</p>
                        <div class="wall"></div>
                        <p class="c-gender">{{ $client->gender }}</p>
                        @isset($client->dateOfBirth)
                        <div class="wall"></div>
                        <p class="c-gender">{{ Carbon\Carbon::parse($client->dateOfBirth)->format('d-m-Y') }}</p>
                        @endisset
                    </div>
                </div>

                @isset( $client->feedback)
                <div class="feedback-wrapper">
                    <i class="bi bi-chat icons" style="font-size:13px"></i>
                    <p class="feedback">{{ $client->feedback }}</p>
                </div>
                @endisset

                <hr style="color:lightgray">



                <div style="display: flex;flex-direction: column;align-items: flex-end;">
                    <small class="text-secondary">ID: {{ $client->id }}</small>
                    <div style="float:right;">
                        <i class="bi bi-gear" style="font-size:15px; color:darkgray"></i>
                        <a href="{{ $client->id }}/edit" style="font-size:13px">O'zgartirish</a>
                    </div>

                    <div style="float:right; display:flex">
                        <i class="bi bi-clock" style="font-size:13px; color:darkgray"></i>
                        <p style="font-size:13px; margin-left:5px">{{ Carbon\Carbon::parse($client->created_at)->format('d-m-Y') }}</p>
                        <p style="font-size:13px;color:lightgray; margin-left:5px">{{ Carbon\Carbon::parse($client->created_at)->format('H:i') }}</p>
                    </div>
                </div>

            </div>

            <!-- end of client box -->

            <!-- sales box -->

            <div class="sales-box ">        
                <div class="s-header justify-content-between">  
                    <div class="d-flex">
                        <i class="bi bi-list-ol icons" style="font-size:20px;"></i> 
                        <p class="s-header-text">Xaridlar tarixi</p> 
                    </div>
                    <span class="seperator-usd product-total-price"> {{ $sales->sum('total_amount_usd') }} </span>
                </div>  

                <hr style="color:lightgray">
                {{-- show sales if exist or message - No sales --}}
                @if($sales->count()>0)
                
                <div class="total-info-wrapper">
                    <p class="small-font"><i class="bi bi-cart4 icons" style="font-size:13px"></i> Xarid: <span class="seperator-quantity product-quantity-selling-price"> {{ $sales->count() }} </span></p>
                    <div class="wall"></div>
                    <p class="small-font"><i class="bi bi-box icons" style="font-size:13px"></i> Mahsulot: <span class="seperator-quantity product-quantity-selling-price"> {{ $sales->sum('total_quantity') }} </span></p>
                    <div class="wall"></div>
                    <p class="small-font">
                        <i class="bi bi-cash icons" style="font-size:13px"></i> 
                        Summa: 
                        <span class="product-total-price"> 
                            <span class="seperator-uzs product-total-price"> {{ $sales->sum('total_amount') }} </span> 
                        </span>
                    </p>
                    <div class="wall"></div>
                    <p class="small-font">
                        <i class="bi bi-credit-card icons" style="font-size:13px"></i> 
                        Foyda: 
                        <span class="product-total-price">
                            <span class="seperator-uzs product-total-price"> {{ $sales->sum('profit') }} </span>
                        </span> 
                    </p>
                    <div class="wall"></div>
                    <p class="small-font">
                        <i class="bi bi-credit-card-2-back icons" style="font-size:13px"></i> 
                        Sof foyda: 
                        <span class="product-total-price">
                            <span class="seperator-uzs product-total-price"> {{ $sales->sum('net_profit') }} </span>
                        </span> 
                    </p>
                    <div class="wall"></div>
                    <p class="small-font">
                        <i class="bi bi-credit-card-2-back icons" style="font-size:13px"></i> 
                        Birdaniga: 
                        <span class="product-total-price">
                            <span class="seperator-uzs product-total-price"> {{ $sales -> where('payment_method', 'completely') -> sum('total_amount') }} </span>
                        </span> 
                    </p>
                    <div class="wall"></div>
                    <p class="small-font">
                        <i class="bi bi-card-checklist icons" style="font-size:13px"></i> 
                        Oyma-oy: 
                        <span class="product-total-price">
                            <span class="seperator-uzs product-total-price"> {{ $sales -> where('payment_method', 'monthly') -> sum('total_amount') }} </span>
                        </span> 
                    </p>
                </div>

                <hr style="color:lightgray">

                @foreach($sales as $sale)
                <div class="sale">
                    <p class="order-number" order-number="{{ $sale -> id }}">№ {{ $loop->remaining +1 }} | ID: {{ $sale -> id }} </span></p>
                    <div class="icons-wrapper">
                        <i class="bi bi-clock" style="font-size:12px; color:darkgray; margin-right:5px"></i>
                        <span style="font-size:13px">{{ Carbon\Carbon::parse($sale->created_at)->format('d-m-Y') }}</span>
                        <span style="font-size:13px;color:gray;margin-left:2px">{{ Carbon\Carbon::parse($sale->created_at)->format('H:i') }}</span>
                        <i class="bi bi-gear" style="font-size:15px; color:darkgray; margin-left:15px"></i>
                        <a href="{{ route('sales.edit',[$sale->id]) }}" style="font-size:13px;margin-left:5px">O'zgartirish</a>
                        <form onsubmit="return confirm('Rostdan ham ochirishni hohlaysizmi?')" action="{{ route('sales.destroy',[$sale->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-icon"><i class="bi bi-trash-fill "></i></button>
                        </form>
                    </div>
                </div>

                <div class="s-body">
                    @foreach($saleProducts as $saleProduct)
                    @if($sale->id==$saleProduct->sale_id)
                    <div class="product-wrapper">
                        <div class="product-wrapper-box">
                            <div class="product-info">
                                <p class="category-name">
                                    {{ $brands -> keyBy('id')[$products->keyBy('id')[$saleProduct->product_id]->brand_id ?? '' ]->brand ?? "Brand topilmadi!"    }}
                                </p>
                                <p class="product-name">{{ $products->keyBy('id')[$saleProduct->product_id]->product ?? "mahsulot topilmadi"}}
                                </p>
                                <p class="category-name">
                                    {{ $categories->keyBy('id')[$products->keyBy('id')[$saleProduct->product_id]->category_id ?? '' ]->category ?? "Kategorya topilmadi!"    }}
                                </p>
                            </div>
                            <div class="product-quantity">
                                <p class="product-quantity-text">{{ $saleProduct->quantity }}</p>
                                <p style="color:gray; font-size:12px;margin:0 2px;">x</p>
                                <p class="product-quantity-selling-price seperator-uzs">{{ $saleProduct->selling_price }}</p>
                                <p class="product-quantity-cost-price seperator-uzs">{{ $saleProduct->cost_price }}</p>
                            </div>
                            <div class="product-total">
                                <p class="product-total-price seperator-uzs">{{ $saleProduct->selling_price * $saleProduct->quantity }}</p>
                                <p class="product-quantity-cost-price seperator-uzs">{{ $saleProduct->cost_price * $saleProduct->quantity }}</p>
                            </div>
                        </div>
                    </div>

                    @endif
                    @endforeach
                    <div class="product-wrapper-box" style="padding: 10px 0;">
                        <div class="product-info">
                            <div class="d-flex">
                                <i class="bi bi-wallet-fill icons" style="font-size:15px"></i> 
                                <p class="category-name mx-1">To'lash usuli:</p>
                                <p class="category-name text-dark" style="font-weight: 600; ">
                                    @switch($sale -> payment_method )
                                        @case('completely') Birdaniga @break
                                        @case('monthly') Oyma-oy @break
                                    @endswitch 
                                </p>
                            </div>
                            <div class="d-flex">
                                <i class="bi bi-credit-card icons" style="font-size:15px"></i> 
                                <p class="category-name mx-1">To'lov:</p>
                                <p class="category-name text-dark" style="font-weight: 600; ">
                                    @switch($sale -> payment)
                                        @case('cash') Naqd pul @break
                                        @case('transfer') Pul o'tkazmasi @break
                                    @endswitch 
                                </p>
                            </div>
                            <div class="d-flex">
                                <i class="bi bi-truck icons" style="font-size:15px"></i>
                                <p class="category-name mx-1">
                                    @switch($sale -> delivery_method )
                                        @case('delivery') Yetkazib berish 
                                        <p class="category-name seperator-uzs text-dark" style="font-weight: 600; ">{{ $sale -> delivery_price }}</p>
                                        @break
                                        @case('parcel') Pochta @break
                                        @case('pickup') Olib ketish @break
                                    @endswitch 
                                </p>
                            </div>
                            @if( $sale -> client_delivery_payment !== NULL )
                                <div class="d-flex">
                                    <i class="bi bi-truck icons" style="font-size:15px"></i>
                                    <p class="category-name mx-1">Mijoz to'ladi: </p>
                                    <p class="category-name seperator-uzs text-dark" style="font-weight: 600; ">{{ $sale -> client_delivery_payment }}</p>
                                </div>
                            @endif
                            @if( $sale -> additional_cost !== NULL )
                                <div class="d-flex">
                                    <i class="bi bi-credit-card-fill icons" style="font-size:15px"></i>
                                    <p class="category-name mx-1">Qo'shimcha xarajatlar: </p>
                                    <p class="category-name seperator-uzs text-dark" style="font-weight: 600; ">{{ $sale -> additional_cost }}</p>
                                </div>
                            @endif
                            @if( $sale->additional !== NULL )
                                <div class="d-flex">
                                    <i class="bi bi-chat icons" style="font-size:15px"> </i>
                                    <p class="category-name mx-1"> {{ $sale->additional }}</p>
                                </div>
                            @endif
                            @if( $sale->awareness !== NULL )
                                <div class="d-flex">
                                    <i class="bi bi-search icons" style="font-size:15px"> </i>
                                    <p class="category-name mx-1"> {{ $sale->awareness }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="product-quantity" style="justify-content: end;">
                            <p class="product-quantity-total">jami: </p>
                            <p class="product-quantity-selling-price seperator-quantity">{{ $sale->total_quantity }}</p>
                        </div>
                        <div class="product-total product-total-last">
                            <p style="font-size:11px;margin:5px 0 0 0; line-height: 1; color:#808080;">Umumiy summa:</p>
                            <p class="product-total-price seperator-uzs">{{ $sale -> total_amount }}</p>
                            <p style="font-size:11px;margin:5px 0 0 0; line-height: 1; color:#808080;">Foyda:</p>
                            <p class="product-total-price seperator-uzs">{{ $sale -> profit }}</p>
                            <p style="font-size:11px;margin:5px 0 0 0; line-height: 1; color:#808080;">Sof foyda:</p>
                            <p class="product-total-price seperator-uzs">{{ $sale -> net_profit }}</p>
                        </div>
                    </div>

                </div>
                @endforeach
                @else
                <p class="no-sales">Xaridlar mavjud emas!</p>
                @endif

            </div>
            <!-- end of sales box -->

            <div class="funnel-box ">
                <div class="s-header">
                    <i class="bi bi-bookmark icons" style="font-size:20px;"></i>
                    <p class="s-header-text">Status</p>
                </div>
                <hr style="color:lightgray">
              

                <div class="accordion" id="accordionExample">
                    @if(!$funnels -> isNotEmpty())
                        <p class="no-sales">Status mavjud emas!</p>
                    @else
                        @foreach ($funnels as $funnel)
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $funnel -> id }}" aria-expanded="true" aria-controls="collapse{{ $funnel -> id }}">
                                    <span class="funnel-circle {{ $funnel -> status }}"></span>
                                    <div>
                                        <p class="funnel-stage"> {{ $funnel -> status }} </p>
                                        <div class="icons-wrapper mt-1">
                                            <i class="bi bi-clock" style="font-size:12px; margin-right:5px"></i>
                                            <span style="font-size:12px"></span>
                                            <span style="font-size:12px;margin-left:2px">{{ $funnel -> updated_at -> format('d-m-Y') }}</span>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $funnel -> id }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="icon-text">
                                        <i class="bi bi-search icons" style="font-size:12px"> </i>
                                        <p class="p-number">{{ $funnel -> awareness }}</p>
                                    </div>
                                    @if($funnel -> price !== NULL)
                                    <div class="icon-text">
                                        <i class="bi bi-wallet2 icons" style="font-size:12px"> </i>
                                        <p class="p-number">{{ $funnel -> price }}</p>
                                    </div>
                                    @endif
                                    @if($funnel -> product !== NULL)
                                        <div class="icon-text">
                                            <i class="bi bi-cart4 icons" style="font-size:12px"> </i>
                                            <p class="p-number">{{ $funnel -> product }}</p>
                                        </div>
                                    @endif
                                    @if($funnel -> additional !== NULL)
                                        <div class="icon-text">
                                            <i class="bi bi-pin-angle-fill icons" style="font-size:12px"> </i>
                                            <p class="p-number">{{ $funnel -> additional }}</p>
                                        </div>
                                    @endif
                                    <div style="display: flex;flex-direction: column;align-items: flex-end;">
                                        <div style="float:right;">
                                            <i class="bi bi-gear" style="font-size:15px; color:darkgray"></i>
                                            <a href="{{ route('funnel.edit',[$funnel -> id]) }}" style="font-size:13px">O'zgartirish</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif

                </div>
                {{-- end of accordion --}}
            </div>
        </div>
    </div>
    
</div>

@section('script')
<script>
$(document).ready(function() {
    //number seperator to money format
    function numberWithSpaces(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }
    // uzs seperator
    for (let i = 0; i < $('.seperator-uzs').length; i++) {
        $(".seperator-uzs")[i].innerText = numberWithSpaces($(".seperator-uzs")[i].innerText) + " so'm";
    }
    // usd seperator
    for (let i=0; i < $('.seperator-usd').length; i++ ) {     
                $(".seperator-usd")[i].innerText = parseFloat($(".seperator-usd")[i].textContent).toLocaleString('en-US', {style:"currency", currency:"USD"}) ;
            }
    for (let i = 0; i < $('.seperator-quantity').length; i++) {
        $(".seperator-quantity")[i].innerText = numberWithSpaces($(".seperator-quantity")[i].innerText) + " ta";
    }
    // match the sale id
    let hash = location.hash.substring(1);
    if( hash !== '' ){
        let element = $('p[order-number='+hash+']');
        if( element.length > 0 ){
            element.parent().css('background-color', 'rgb(89 179 86 / 33%)');
            element.parent().next('.s-body').css('border-color', 'rgb(89 179 86 / 33%)');
            $('body, html').animate({
            scrollTop: element.offset().top-50
        });
        }
       
    }

});
</script>
@endsection
@section('css')
<link href="/css/clientHistory.css" rel="stylesheet">
<style>

</style>
@endsection





@endsection