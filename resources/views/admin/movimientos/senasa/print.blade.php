@extends('layouts.app-pdf')

@section('title', 'Salida Senasa')

@section('css')

@endsection

@section('content')

@include('admin.movimientos.senasa.header-salida')

<div class="body-senasa">
    <table style="width:100%; font-size: 11px ">
        <tr>
            <td style="width: 30%">LUGAR DE EMISION</td>
            <td class=" text-center" style="width: 10%">DIA</td>
            <td class=" text-center" style="width: 10%">MES</td>
            <td class=" text-center" style="width: 10%">AÑO</td>
            <td class=" text-center" style="width: 15%">H.SALIDA</td>
            <td class=" text-center" style="width: 5%">TEMP</td>
        </tr>
        <tr>
            <td><strong>PARANA - ENTRE RIOS</strong></td>
            <th class=" text-center">{{ date('d', strtotime($senasa->fecha_salida)) }}</th>
            <th class=" text-center">{{ date('m', strtotime($senasa->fecha_salida)) }}</th>
            <th class=" text-center">{{ date('Y', strtotime($senasa->fecha_salida)) }}</th>
            <th class=" text-center">{{ $senasa->hora_salida }}</th>
            <th class=" text-center">-18 ºC</th>
        </tr>
        <tr>
            <td colspan="6">
                <br />
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <br />
            </td>
        </tr>
        <tr>
            <td colspan="6">
                Autorízase al estableciento Nro Oficial <strong> 5241 FENOVO S.A.</strong> a transportar los siguientes productos inspeccionados
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <br />
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <br />
            </td>
        </tr>
    </table>

    <table style="width:100%; font-size: 11px ">
        <tr>
            <th class="text-center" style="width: 5%; ">Cant</th>
            <th class="text-center" style="width: 50%;">Descripción</th>
            <th class="text-center" style="width: 10%;">P.Neto</th>
            <th class="text-center" style="width: 10%;">P.Bruto</th>
            <th class="text-center" style="width: 5%;">UM</th>
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
                <hr>
            </td>
        </tr>
        <tr>
            <th class="text-center"> {{ number_format($movimientos->sum('bultos')) }}</strong> </th>
            <td>Total de bultos</td>
            <td class="text-center"> <strong> {{ number_format($movimientos->sum('kilos'),2) }} Kgrs</strong></td>
            <td class="text-center"> </td>
            <td class="text-center"> </td>
        </tr>
    </table>
</div>

@include('admin.movimientos.senasa.footer-salida')

@endsection