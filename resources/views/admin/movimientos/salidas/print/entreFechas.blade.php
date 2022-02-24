@extends('layouts.app-pdf')

@section('title', 'Print salida')

@section('css')

@endsection

@section('content')

@include('admin.movimientos.salidas.print.salidas-header')

<table class="table table-borderless">
    <tr>
        <td>Consulta x fechas </td>
        <td class=" text-center">Desde <strong> {{ date('d-m-Y',strtotime($desde)) }} </strong> - hasta <strong> {{ date('d-m-Y',strtotime($desde)) }} </strong> </td>
        <td class=" text-right">Página :: <strong> <span class="pagenum"></span> </strong> </td>
    </tr>
</table>

<table class="table">
    <tr>
        <td>#</td>
        <td>Fecha</td>
        <td>Destino</td>
        <td>Tipo</td>
        <td>Comprobante Nro</td>
        <td>Movimientos</td>
        <td>Kgrs</td>
    </tr>
    @if (isset($salidas))
    @foreach ($salidas as $salida)
    <tr>
        <td>{{$loop->iteration}}</th>
        <td>{{ date('d-m-Y',strtotime($salida->date)) }}</td>
        <td>{{ $salida->origenData($salida->type); }}</td>
        <td>{{ $salida->type }}</td>
        <td>{{ $salida->voucher_number }}</td>
        <td>{{ count($salida->movement_salida_products) }}</td>
        <td>{{ $salida->totalKgrs($salida->id) }}</td>
    </tr>

    @endforeach
    @endif

</table>

@endsection