@extends('layouts.app-pdf')

@section('title', 'Panama')

@section('css')

<style>
    #header {
        line-height: 0.6cm;
        position: fixed;
        top: 0.5cm;
        left: 1.5cm;
        right: 1.5cm;
    }
</style>

@endsection

@section('content')

<div id="header">
    <table style="width: 100%">
        <tr>
            <td style="width: 35%"> Página :: <strong> <span class="pagenum"></span> </strong> </td>
            <td style="width: 35%; font-size:16px" class=" text-center">Fenovo S.A. </td>
            <td style="width: 30%" class=" text-right"> Fecha {{ $fecha }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <hr />
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
            </td>
        </tr>
    </table>
</div>

<table class="table mb-5" style=" font-size: 12px  ">
    <tr>
        <td class="w-25"># {{$id_panama}} </td>
        <td class="text-left"> {{$destino}} </td>
    </tr>
</table>

<table class="table mt-5">
    <tr>
        <th>Bultos</th>
        <th>Cant</th>
        <th>U</th>
        <th>Palet</th>
        <th>Producto</th>
        <th>Precio </th>
        <th>Subtotal</th>
    </tr>

    @foreach ($array_productos as $p)
    <tr>
        <td class="text-center" style="width: 15px "> {{$p->bultos}} </td>
        <td class="text-center" style="width: 15px "> {{$p->total_unit}} </td>
        <td class="text-center" style="width: 15px "> {{$p->unidad}} </td>
        <td class="text-center" style="width: 15px "> {{$p->palet}} </td>
        <td class="text-left"> <strong> {{$p->cod_fenovo}}</strong> - {{$p->name}} </td>
        <td class="text-center"> {{$p->unit_price}} </td>
        <td class="text-center"> {{$p->subtotal}} </td>
    </tr>
    @endforeach

    <tr>
        <th colspan="4"></th>
        <th>Total</th>
        <th>${{number_format($neto, 2, ',', '.')}}</th>
    </tr>
</table>


<footer>
    <table class="table table-borderless table-condensed table-sm">
        <tr>
            <td>
                # {{ str_pad($id_panama, 8, '0', STR_PAD_LEFT) }} - Página <strong> <span class="pagenum"></span> </strong>
            </td>
        </tr>
    </table>
</footer>


@endsection
