@extends('layouts.app-pdf')

@section('title', 'Salida Senasa')

@section('css')

@endsection

@section('content')

@include('admin.movimientos.senasa.header-salida')

<div class="body-senasa">
    <table style="width:100%; font-size: 9px ">
        <tr>
            <td style="width: 50%">&nbsp;</td>
            <td class=" text-center" style="width: 5%">&nbsp;</td>
            <td class=" text-center" style="width: 5%">&nbsp;</td>
            <td class=" text-center" style="width: 5%">&nbsp;</td>
            <td class=" text-center" style="width: 10%">&nbsp;</td>
            <td class=" text-center" style="width: 5%">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <th class=" text-center">{{ date('d', strtotime($senasa->fecha_salida)) }}</th>
            <th class=" text-center">{{ date('m', strtotime($senasa->fecha_salida)) }}</th>
            <th class=" text-center">{{ date('Y', strtotime($senasa->fecha_salida)) }}</th>
            <th class=" text-center">{{ $senasa->hora_salida }}</th>
            <th class=" text-center">-18 ºC</th>
        </tr>
    </table>

    <div style="height: 5cm">
        &nbsp;
    </div>

    <table style="width:100%; font-size: 8px ">
        <tr>
            <th class="text-center" style="width: 10%; ">&nbsp;</th>
            <th class="text-center" style="width: 50%;">&nbsp;</th>
            <th class="text-center" style="width: 10%;">&nbsp;</th>
            <th class="text-center" style="width: 5%;">&nbsp;</th>
            <th class="text-center" style="width: 5%;">&nbsp;</th>
        </tr>
        @foreach($movimientos as $movimiento)
        <tr>
            <td class="text-center">{{ $movimiento->bultos }}</td>
            <td>{{ $movimiento->name }}</td>
            <td class="text-center">{{ number_format($movimiento->kilos,2) }}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5">
                &nbsp;
            </td>
        </tr>
        <tr>
            <th class="text-center"> {{ number_format($movimientos->sum('bultos')) }}</strong> </th>
            <td>&nbsp;</td>
            <td class="text-center"> <strong> {{ number_format($movimientos->sum('kilos'),2) }} Kgrs</strong></td>
            <td class="text-center"> </td>
            <td class="text-center"> </td>
        </tr>
    </table>
</div>

@include('admin.movimientos.senasa.footer-salida')

@endsection