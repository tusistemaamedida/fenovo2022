@extends('layouts.app-pdf')

@section('title', 'Salida Senasa')

@section('css')
<style>
    header {
        line-height: 0.6cm;
        position: fixed;
        top: 0.7cm;
        left: 1.5cm;
        right: 1.5cm;
        height: 7cm;
    }

    footer {
        position: fixed;
        bottom: 0.7cm;
        left: 1cm;
        right: 1.5cm;
        height: 5cm;
    }

    .pagenum:before {
        content: counter(page);
    }
</style>
@endsection

@section('content')

@include('admin.movimientos.senasa.header-salida')

<div class="row mt-3">
    <div class="col-12">
        <br>
    </div>
</div>

<table style="width: 100%; ">
    <thead>
        <tr>
            <th class="text-center" style="width: 5%; ">Cant</th>
            <th class="text-center" style="width: 50%;">Descripción</th>
            <th class="text-center" style="width: 10%;">Peso Neto</th>
            <th class="text-center" style="width: 10%;">Peso Bruto</th>
            <th class="text-center" style="width: 5%;">UM</th>
        </tr>
    </thead>
    <tbody>
        @foreach($senasa->productos_senasa() as $movimiento)
        <tr>
            <td class="text-center">{{ $movimiento->bultos }}</td>
            <td>{{ $movimiento->name }}</td>
            <td class="text-center">{{ number_format($movimiento->peso,2) }}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">Totales</td>
            <td class="text-center"> <strong> {{ $senasa->total_senasa() }}</strong></td>
            <td></td>
            <td class="text-center"> Kg. </td>
        </tr>
    </tfoot>
</table>

@include('admin.movimientos.senasa.footer-salida')

@endsection