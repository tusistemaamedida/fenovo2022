@extends('layouts.app-pdf')

@section('title', 'Print salida')

@section('css')

@endsection

@section('content')

@include('admin.movimientos.print.salidas-header')

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
                <th class="text-center">Nombre</th>
                <th class="text-center">Presentación</th>
                <th class="text-center">Bultos</th>
                <th class="text-center">Kgrs.</th>
                <th class="text-center">Cantidad</th>
            </tr>

            @php
            $total_kgrs = 0;
            @endphp

            @foreach ($session_products as $session_product)

            @php
            $total_kgrs += $session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity;
            @endphp

            <tr>
                <td class="text-center"> {{ $loop->iteration }}</td>
                <td>{{$session_product->producto->cod_fenovo}} {{$session_product->producto->name}}</td>
                <td class="text-center">{{number_format($session_product->unit_package,2)}}</td>
                <td class="text-center">{{$session_product->quantity}}</td>
                <td class="text-center">{{number_format($session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity,2) }}</td>
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
                <th> {{ number_format($session_products->sum('quantity'),2) }} </th>
                <th> {{ number_format($total_kgrs,2, ',', '.') }} </th>
                <th></th>
            </tr>
        </table>

    </div>
</div>

@include('admin.movimientos.print.salidas-footer')
@endif


@endsection