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
                <th class="text-center">#</th>
                <th style=" width: 35%; " class="text-center">Nombre</th>
                <th class="text-center">Proveedor</th>
                <th class="text-center">Presentación</th>
                <th class="text-center">Bultos</th>
                <th class="text-center">Cantidad</th>
            </tr>

            @php
            $total_kgrs = 0;
            @endphp

            @foreach ($session_products as $session_product)

            @php
            $total_kgrs += (float)$session_product->unit_weight * (float)$session_product->unit_package * (float)$session_product->quantity;
            @endphp

            <tr>
                <td class="text-center"> {{ $loop->iteration }}</td>
                <td>{{$session_product->cod_fenovo}} {{$session_product->name}}</td>
                <td class="text-center">{{$session_product->cod_proveedor }}</td>
                <td class="text-center">{{$session_product->unit_package}}</td>
                <td class="text-center">{{ (int)$session_product->quantity}}</td>
                <td class="text-center"> .............. </td>
            </tr>
            @endforeach

            <tr>
                <th colspan="6"><br></th>
            </tr>
            <tr class=" bg-info text-white">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th> {{ number_format($session_products->sum('quantity'),2) }} </th>
                <th> </th>
            </tr>
        </table>

    </div>
</div>

@include('admin.print.salidas-footer')
@endif


@endsection