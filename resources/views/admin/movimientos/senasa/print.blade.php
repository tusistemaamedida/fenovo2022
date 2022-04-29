@extends('layouts.app-pdf')

@section('title', 'Salida Senasa')

@section('css')

@endsection

@section('content')

<table style="width:100%; margin-top:1.7cm; font-size: 9px ">
    <tr>
        <td colspan="6">
            <strong style="margin-left: 9cm">
                {{ date('d', strtotime($senasa->fecha_salida)) }}
            </strong>
            <strong style="margin-left: 1cm">
                {{ date('m', strtotime($senasa->fecha_salida)) }}
            </strong>
            <strong style="margin-left: 0.5cm">
                {{ date('Y', strtotime($senasa->fecha_salida)) }}
            </strong>
            <strong style="margin-left: 2cm">
                {{ date('H:i', strtotime($senasa->hora_salida)) }}
            </strong>
            <strong style="margin-left: 1cm">
                -18
            </strong>
        </td>
    </tr>
</table>

<table style="width:100%; margin-top: 7cm; font-size: 9px ">
    <tr>
        <th class="text-center" style="width: 10%; ">&nbsp;</th>
        <th class="text-center" style="width: 55%;">&nbsp;</th>
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

@include('admin.movimientos.senasa.footer-salida')

@endsection