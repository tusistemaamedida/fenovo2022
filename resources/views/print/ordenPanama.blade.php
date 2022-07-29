@extends('layouts.app-pdf')

@section('title', 'Orden cerrada')

@section('css')

<style>
    #header {
        line-height: 0.6cm;
        position: fixed;
        top: 0.5cm;
        left: 1.5cm;
        right: 1.5cm;
    }
</style>

@endsection

@section('content')

<div id="header">
    <table style="width: 100%">
        <tr>
            <td style="width: 35%"> Página :: <strong> <span class="pagenum"></span> </strong> Orden cerrada (pan) </td>
            <td style="width: 35%; font-size:16px" class=" text-center">Fenovo S.A. </td>
            <td style="width: 30%" class=" text-right"> Fecha {{ date(now()) }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <hr />
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
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
        <td>Items <strong> {{ count($array_productos) }}</strong> </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3">Dirección : <strong> {{ $destino->address }} / {{ $destino->city }}</strong></td>
    </tr>
    <tr>
        <td colspan="3">DETALLE DE LA ORDEN (PAN) Nro <strong> {{ str_pad($orden, 8, '0', STR_PAD_LEFT) }} </strong></td>
    </tr>
</table>


<table style=" width:100%; font-size:9px">
    <tr>
        <td class="text-center">Bultos</td>
        <td class="text-center">Kgrs</td>
        <td class="text-center">Unidades</td>
        <td class="w-25">Nombre del producto</td>
        <td class="text-center">Presentación</td>
        <td class="text-center">Palet</td>
    </tr>
    @php
    $total_kgrs = 0;
    $total_bultos = 0;
    @endphp

    @foreach ($array_productos as $session_product)

    @php
    $total_kgrs += (float)$session_product->unit_weight * (float)$session_product->unit_package * (float)$session_product->quantity;
    $total_bultos += (float)$session_product->quantity;
    @endphp

    <tr>
        <td class="text-center">{{ (int)$session_product->quantity}}</td>
        <td class="text-center">{{ (float)$session_product->unit_weight * (float)$session_product->unit_package * (float)$session_product->quantity }} </td>
        <td class="text-center">{{ $session_product->unit_package * $session_product->quantity }} </td>
        <td>{{$session_product->name}}</td>
        <td class="text-center">{{$session_product->unit_package}}</td>
        <td class="text-center">{{$session_product->palet}}</td>
    </tr>

    @endforeach

    <tr>
        <th colspan="6"><br></th>
    </tr>
    <tr class=" bg-info text-white">
        <th> {{ number_format($total_bultos,2) }}</th>
        <th> {{ number_format($total_kgrs,2) }} </th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</table>

<footer>
    <table class="table table-borderless table-condensed table-sm">
        <tr>
            <td>
                Orden (Pan) Nro {{ str_pad($orden, 8, '0', STR_PAD_LEFT) }} - Página <strong> <span class="pagenum"></span> </strong>
            </td>
        </tr>
    </table>
</footer>


@endsection