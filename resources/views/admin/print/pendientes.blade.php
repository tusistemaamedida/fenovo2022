@extends('layouts.app-pdf')

@section('title', 'Print salida')

@section('css')

@endsection

@section('content')

@include('admin.print.salidas-header')

@if (isset($session_products))


<div class="table-datapos">
    <div class="table-responsive">

        <table class="table table-borderless">
            <tr>
                <td>Destino : <strong> {{ $destino->description }} </strong></td>
                <td>Items <strong> {{ $session_products->count('id') }}</strong> - Bultos <strong> {{ $session_products->sum('quantity') }}</strong></td>
                <td>Página :: <strong> <span class="pagenum"></span> </strong>
                </td>
            </tr>
        </table>

        <table class="table table-condensed table-sm">
            <tr class="">
                <th class="text-center">Bultos</th>
                <th class="text-center">Cantidad</th>
                <th style=" width: 30%; " class="text-center">Nombre</th>
                <th style="float: left;text-align:left">Proveedor</th>
                <th class="text-center">Presentación</th>
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
                <th></th>
                <th></th>
                <th> </th>
                <th> </th>
            </tr>
        </table>

    </div>
</div>

@include('admin.print.salidas-footer')
@endif


@endsection
