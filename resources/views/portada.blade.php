@extends('layouts.app')

@section('css')
<style>
    body,
    html {
        height: 100%;
        margin: 0;
        font: 400 15px/1.8 "Lato", sans-serif;
        color: #777;
    }

    .bgimg-1,
    .bgimg-2,
    .bgimg-3 {
        position: relative;
        opacity: 0.65;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;

    }

    .bgimg-1 {
        background-image: url("./assets/images/fondo.jpg");
        height: 100%;
    }

    .caption {
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        text-align: center;
        color: #000;
    }

    .caption span.border {
        background-color: #111;
        color: #fff;
        padding: 18px;
        font-size: 25px;
        letter-spacing: 10px;
    }

    h3 {
        letter-spacing: 5px;
        text-transform: uppercase;
        font: 20px "Lato", sans-serif;
        color: #111;
    }

    .active {
        color: #326ab2 !important;
        font-size: 18px
    }
</style>
@endsection

@section('content')

<div class="bgimg-1">
    <div class="subheader py-2 py-lg-6 subheader-solid">
        <div class="container-fluid">
            <nav aria-label="breadcrumb" style="display: inline-flex; float: right;">
                <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="http://frioteka.com.ar" target="_blank" rel="noopener noreferrer">Frioteka</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{asset('constancias.pdf')}}" target="_blank" rel="noopener noreferrer">Constancias</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="http://fenovo.ar/login" target="_blank" rel="noopener noreferrer">Intranet</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection