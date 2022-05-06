@extends('layouts.app-pdf')

@section('title', 'Orden en trámite')

@section('css')

<style>
    #header {
        line-height: 0.6cm;
        position: fixed;
        top: 1.2cm;
        left: 1.5cm;
        right: 1.5cm;
        height: 3cm;
    }
</style>

@endsection

@section('content')

<div id="header">
    <table style="width: 100%">
        <tr>
            <td style="width: 35%"> Página :: <strong> <span class="pagenum"></span> </strong> Confección de la Orden </td>
            <td style="width: 35%; font-size:16px" class=" text-center">Fenovo S.A. </td>
            <td style="width: 30%" class=" text-right"> Fecha {{ date(now()) }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <hr />
            </td>
        </tr>
    </table>
</div>

<table class="table table-borderless" style="font-size:10px">
    <tr>
        <td colspan="3"><br></td>
    </tr>
    <tr>
        <td>Destino : (<strong> {{ str_pad($destino->cod_fenovo, 4, '0', STR_PAD_LEFT) }} </strong> ) - {{ $destino->razon_social}} - <strong> {{ $destino->cuit}} </strong> </td>
        <td>Items <strong> {{ count($session_products) }}</strong> </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3">Dirección : <strong> {{ $destino->address }} / {{ $destino->city }}</strong></td>
    </tr>
    <tr>
        <td colspan="3">DETALLE DE LA CONFECCION DE LA ORDEN</td>
    </tr>
</table>

<table class="table table-condensed table-sm">
    <tr class="">
        <tr class="">
            <th class="text-center">Bultos</th>
            <th class="text-center">Cantidad</th>
            <th style=" width: 30%; " class="text-center">Nombre</th>
            <th style="float: left;text-align:left">Proveedor</th>
            <th class="text-center">Presentación</th>
        </tr>
    </tr>

    @php
    $total_kgrs = 0;
    @endphp

    @foreach ($session_products as $session_product)

    @php
    $total_kgrs += (float)$session_product->unit_weight * (float)$session_product->unit_package * (float)$session_product->quantity;
    @endphp

    <tr>
        <td class="text-center">{{ (int)$session_product->quantity}}</td>
        <td class="text-center"> .............. </td>
        <td>{{$session_product->cod_fenovo}} {{$session_product->name}}</td>
        <td style="float: left;text-align:left">{{$session_product->cod_proveedor }}</td>
        <td class="text-center">{{$session_product->unit_package}}</td>
    </tr>
    @endforeach

    <tr>
        <th colspan="5"><br></th>
    </tr>
    <tr class=" bg-info text-white">
        <th>{{ number_format($session_products->sum('quantity'),2) }} </th>
        <th>{{ $total_kgrs }} Kgrs</th>
        <th></th>
        <th> </th>
        <th> </th>
    </tr>
</table>

<footer>
    <table class="table table-borderless table-condensed table-sm">
        <tr>
            <td>
                Página <strong> <span class="pagenum"></span> </strong>
            </td>
        </tr>
    </table>
</footer>

@endsection
