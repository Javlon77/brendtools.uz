@extends('layout')
@section('title', 'Tahlil')
@section('header-text', "Tahlil")
@section('content')

    <div class="container" >
        <div class="box-wrapper">
            <a href="/analytics/funnel" class="box">
                <p>
                    <i class="bi bi-funnel"></i>
                    <br> 
                    Sotuv voronkasi 
                </p>
            </a>
        </div>
    </div>

@section('script')

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





@endsection