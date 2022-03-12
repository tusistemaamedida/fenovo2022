@extends('layouts.app-pdf')

@section('title', 'Print novedades')

@section('css')

@endsection

@section('content')

@include('admin.products.print.salidas-header')

<div class="table-datapos">
    <div class="table-responsive">

        <table class="table table-borderless">
            <tr>
                <td>Consulta x fechas </td>
                <td class=" text-center">Desde <strong> {{ date('d-m-Y H:m',strtotime($desde)) }} </strong> - hasta <strong> {{ date('d-m-Y H:m',strtotime($hasta)) }} </strong> </td>
                <td class=" text-right">Página :: <strong> <span class="pagenum"></span> </strong> </td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <td>#</td>
                <td>Cod Fenovo</td>
                <td>Nombre</td>
                <td>Precio</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @if (isset($productos))
            @foreach ($productos as $producto)
            <tr>
                <td>{{ $loop->iteration }}</th>
                <td>{{ $producto->cod_fenovo}}</td>
                <td>{{ $producto->name}}</td>
                <td>{{ $producto->p1tienda }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
            @endif

        </table>

    </div>
</div>

@endsection