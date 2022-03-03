@extends('layout')
@section('title', "CRM")
@section('header-text', "CRM")

@section('content')
<div class="container">
    <p>Bugun:</p>
    <div class="box-wrapper">
        <div class="box">
            <p>
                So'rov: 
            </p>
            <p>
                + {{ $sales }}
            </p>
        </div>
        <div class="box">
            <p>
                Sotuv: 
            </p>
            <p>
                + {{ $funnels }}
            </p>
        </div>
    </div>

    {{-- Qo'shish --}}
    <p>Qo'shish:</p>
    <div class="box-wrapper">
        <a href="/client-base/create" class="box">
            <p>
                <i class="bi bi-person"></i> +
                <br> 
                Mijoz 
            </p>
        </a>
        <a href="/sales/create" class="box">
            <p>
                <i class="bi bi-bag"></i> +
                <br> 
                Sotuv
            </p>
        </a>
        <a href="/funnel/create" class="box">
            <p>
                <i class="bi bi-funnel"></i> +
                <br> 
                Voronka
            </p>
        </a>
        <a href="/products/create" class="box">
            <p>
                <i class="bi bi-box"></i> +
                <br> 
                Mahsulot
            </p>
        </a>
        <a href="/costs/create" class="box">
            <p>
                <i class="bi bi-wallet2"></i> +
                <br> 
                Xarajat
            </p>
        </a>
    </div>

    
    {{-- Sahifalar --}}
    <p>Sahifalar:</p>
    <div class="box-wrapper">
        <a href="/client-base" class="box">
            <p>
                <i class="bi bi-person"></i> 
                <br> 
                Mijoz
            </p>
        </a>
        <a href="/sales" class="box">
            <p>
                <i class="bi bi-bag-plus"></i>
                <br> 
                Sotuv
            </p>
        </a>
        <a href="/funnel" class="box">
            <p>
                <i class="bi bi-funnel"></i>
                <br> 
                Voronka
            </p>
        </a>
        <a href="/products" class="box">
            <p>
                <i class="bi bi-box"></i>
                <br> 
                Mahsulot
            </p>
        </a>
        <a href="/categories" class="box">
            <p>
                <i class="bi bi-box"></i>
                <br> 
                Mahsulot kategoryasi
            </p>
        </a>
        <a href="/brands" class="box">
            <p>
                <i class="bi bi-award"></i>
                <br> 
                Brend
            </p>
        </a>
        <a href="/masters-base" class="box">
            <p>
                <i class="bi bi-hammer"></i>
                <br> 
                Usta turi
            </p>
        </a>
        <a href="/companies-base" class="box">
            <p>
                <i class="bi bi-building"></i>
                <br> 
                Kompaniyalar
            </p>
        </a>
        <a href="/costs" class="box">
            <p>
                <i class="bi bi-wallet2"></i>
                <br> 
                Xarajat
            </p>
        </a>
        <a href="/cost-categories" class="box">
            <p>
                <i class="bi bi-wallet2"></i>
                <br> 
                Xarajat kategoryasi
            </p>
        </a>
        <a href="/finance" class="box">
            <p>
                <i class="bi bi-bank"></i>
                <br> 
                Moliya
            </p>
        </a>
        <a href="/currency" class="box">
            <p>
                <i class="bi bi-currency-exchange"></i>
                <br> 
                Kurs
            </p>
        </a>
        <a href="/tasks" class="box">
            <p>
                <i class="bi bi-check2-square"></i>
                <br> 
                Vazifalar
            </p>
        </a>
        <a href="/analytics" class="box">
            <p>
                <i class="bi bi-graph-down-arrow"></i>
                <br> 
                Tahlillar
            </p>
        </a>
    </div>

</div>



@endsection

@section('css')
    <style>
        .box-wrapper{
            display: flex;
        flex-wrap: wrap;
        }
        .box{
            color: white;
            font-weight: 400;
            border-radius: 4px;
            padding: 15px 25px;
            width: 140px;
            min-width: 140px;
            margin-right: 15px;
            margin-bottom: 15px;
            background-color: #34393ee0;
            transition:0.2s all linear;
            text-decoration:none;
        }
        .box:hover{
            cursor:pointer;
            background-color: #34393e75;
            color:white;
        }
        .box p {
            margin: 0;
        }
      
    
    </style>
@endsection