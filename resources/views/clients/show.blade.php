@extends('layout')
@section('title', 'Mijoz tarixi')
@section('header-text', 'Mijoz tarixi')

@section('content')

<div class="container">


    <div class="row h-wrapper">

        <div class="col-12 h-header">
            <a href="" class="back-link"><i class="bi bi-arrow-left"></i></a>
        </div>

        <hr class="hr-sperator">

        <div class="h-body">

            <!-- client box -->

            <div class="client-box ">

                <div class="c-name-wrapper">
                    <i class="bi bi-person-fill icons" style="font-size:20px;"> </i>
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
                        <p class="p-number">{{ $client->phone1 }}</p>
                    </div>
                    @isset($client->phone2)
                    <div class="phone">
                        <i class="bi bi-telephone-fill icons" style="font-size:12px"> </i>
                        <p class="p-number">{{ $client->phone1 }}</p>
                    </div>
                    @endisset
                </div>

                <div class="info-wrapper">
                    <i class="bi bi-person icons" style="font-size:13px"> </i>
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
                    <div style="float:right;">
                        <i class="bi bi-gear" style="font-size:15px; color:darkgray"></i>
                        <a href="{{ $client->id }}/edit" style="font-size:13px">O'zgartirish</a>
                    </div>


                    <div style="float:right">
                        <i class="bi bi-clock" style="font-size:13px; color:darkgray"></i>
                        <text
                            style="font-size:13px">{{ Carbon\Carbon::parse($client->created_at)->format('d-m-Y') }}</text>
                        <text
                            style="font-size:13px;color:lightgray">{{ Carbon\Carbon::parse($client->created_at)->format('H:i') }}</text>
                    </div>
                </div>

            </div>

            <!-- end of client box -->

            <!-- sales box -->


            <div class="sales-box ">
                <div class="s-header">
                    <i class="bi bi-list-ol icons" style="font-size:20px;"></i>
                    <p class="s-header-text">Xaridlar tarixi</p>
                </div>
                @if($sales->count()>0)
                @foreach($sales as $sale)
                <div class="sale">
                    <p class="order-number">№ {{ $loop->index+1 }}</p>
                    <div class="icons-wrapper">
                        <i class="bi bi-clock" style="font-size:12px; color:darkgray; margin-right:5px"></i>
                        <text
                            style="font-size:13px">{{ Carbon\Carbon::parse($sale->created_at)->format('d-m-Y') }}</text>
                        <text
                            style="font-size:13px;color:gray;margin-left:2px">{{ Carbon\Carbon::parse($sale->created_at)->format('H:i') }}</text>
                        <!-- <a href="/sales/{{ $sale->id }}/edit" style="font-size:13px; margin-left:10px">O'zgartirish</a> -->
                        <form action="{{ route('sales.destroy',[$sale->id]) }}" method="post">
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
                                    {{ $brands->keyBy('id')[$products->keyBy('id')[$saleProduct->product_id]->category_id ?? '' ]->brand ?? "Brand topilmadi!"    }}
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
                                <p class="product-quantity-selling-price seperator">{{ $saleProduct->selling_price }}
                                </p>
                                <p class="product-quantity-cost-price seperator">{{ $saleProduct->cost_price }}</p>
                            </div>
                            <div class="product-total">
                                <p class="product-total-price seperator">
                                    {{ $saleProduct->selling_price*$saleProduct->quantity }}</p>
                            </div>
                        </div>
                    </div>



                    @endif
                    @endforeach
                    <div class="product-wrapper-box" style="padding: 10px 0;">
                        <div class="product-info">
                            <p class="category-name">{{ $sale->additional }}</p>
                        </div>
                        <div class="product-quantity" style="justify-content: end;">
                            <p class="product-quantity-total">jami: </p>
                            <p class="product-quantity-selling-price seperator-quantity">{{ $sale->total_quantity }}</p>

                        </div>
                        <div class="product-total">
                            <p style="font-size:11px;margin:0;line-height: 0.4;">Umumiy summa:</p>
                            <p class="product-total-price seperator">{{ $sale->total_amount }}</p>
                        </div>
                    </div>

                </div>
                @endforeach
                @else
                <p class="no-sales">Xaridlar mavjud emas!</p>
                @endif

            </div>
            <!-- end of sales box -->

            <div class="funnel-box ">asd</div>
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

    for (let i = 0; i < $('.seperator').length; i++) {
        $(".seperator")[i].innerText = numberWithSpaces($(".seperator")[i].innerText) + " so'm";
    }
    for (let i = 0; i < $('.seperator-quantity').length; i++) {
        $(".seperator-quantity")[i].innerText = numberWithSpaces($(".seperator-quantity")[i].innerText) + " ta";
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