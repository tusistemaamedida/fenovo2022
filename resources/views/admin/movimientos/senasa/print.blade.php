@extends('layouts.app-pdf')

@section('title', 'Salida Senasa')

@section('css')

@endsection

@section('content')

@include('admin.movimientos.senasa.encabezado')


@php
$total_k = 0;
$total_ku = 0;
@endphp

@foreach($movimientos as $movimiento)

@php
if($movimiento->unit_type == 'K'){
$total_k += $movimiento->kilos;
}else{
$total_ku += $movimiento->egress*$movimiento->unit_weight;
}
@endphp


<tr>
    <td class="text-center">{{ $movimiento->bultos }}</td>
    <td>{{ $movimiento->name }}</td>
    <td class="text-center">
        @if ($movimiento->unit_type == 'K')
        {{ number_format($movimiento->kilos,2) }}
        @else
        {{ number_format($movimiento->egress*$movimiento->unit_weight,2) }}
        @endif
    </td>
    <td class="text-center"></td>
    <td class="text-center"></td>
</tr>

<!-- Revisa si al imprimir el detalle, supera la linea 28 -->
@if ($loop->iteration % 30 == 0)

</table>

<div class="page-break"></div>

@include('admin.movimientos.senasa.encabezado')


@endif


@endforeach
<tr>
    <td colspan="5">
        &nbsp;
    </td>
</tr>
<tr>
    <th class="text-center"> {{ number_format($movimientos->sum('bultos')) }}</strong> </th>
    <td>&nbsp;</td>
    <td class="text-center"> <strong> {{ number_format($total_k+$total_ku,2) }} Kgrs</strong></td>
    <td class="text-center"> </td>
    <td class="text-center"> </td>
</tr>
</table>

@include('admin.movimientos.senasa.footer-salida')

@endsection