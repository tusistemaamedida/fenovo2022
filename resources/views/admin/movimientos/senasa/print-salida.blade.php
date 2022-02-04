@extends('layouts.app-pdf')

@section('title', 'Salida Senasa')

@section('content')

<table width="50%">
    <tr style="font-size:18px">
        <td>Habilitación Nro</td>
        <th>{{ $senasa->habilitacion_nro }}</th>
    </tr>
    <tr>
        <td>Patente Nro</td>
        <th>{{ $senasa->patente_nro }}</th>
    </tr>
    <tr>
        <td>Precintos</td>
        <th>{{ $senasa->precintos }}</th>
    </tr>
</table>

<div class="row m-2">
    <div class="col-12">
        &nbsp;
    </div>
</div>

<table class=" table table-bordered table-condensed">
    <thead>
        <tr>
            <th style="width: 5%; ">#</th>
            <th style="width: 10%; text-align: center">Cod</th>
            <th>Producto</th>
            <th>Senasa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($senasa->productos_senasa() as $movimiento)
        <tr>
            <td>{{ $loop->iteration  }}</td>
            <td style="width: 10%; text-align: center">{{ $movimiento->cod_fenovo }}</td>
            <td style="width: 30%;">{{ $movimiento->name }}</td>
            <td style="width: 30%;">{{ $movimiento->senasa }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">Cantidad de productos <strong> {{ count($senasa->productos_senasa()) }} </strong></td>
        </tr>
    </tfoot>
</table>

@endsection