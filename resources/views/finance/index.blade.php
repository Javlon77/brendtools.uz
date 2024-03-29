@extends('layout')
@section('title', "Moliya")
@section('header-text', "Moliya")
@section('content')

<div class="container" >
    <div class="box-wrapper">
        <a href="/finance/plan" class="box">
            <p>
                <i class="bi bi-currency-dollar"></i>
                <br> 
                Plan
            </p>
        </a>
        <a href="/finance/annual" class="box">
            <p>
                <i class="bi bi-clipboard-data"></i>
                <br> 
                Yillik savdo
            </p>
        </a>
        <a href="/finance/brand" class="box">
            <p>
                <i class="bi bi-award"></i>
                <br> 
                Brendlar bo'yicha savdo
            </p>
        </a>
        <a href="/finance/category" class="box">
            <p>
                <i class="bi bi-box"></i>
                <br> 
                Kategoryalar bo'yicha savdo
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
            width: 180px;
            min-width: 140px;
            margin-right: 15px;
            margin-bottom: 15px;
            background-color: #0000004d;
            transition:0.2s all linear;
            text-decoration:none;
        }
        .box:hover{
            cursor:pointer;
            background-color: #92938c3b;
            color:white;
        }
        .box p {
            margin: 0;
        }
    </style>
@endsection 
@section('script') 

@endsection