@extends('layouts.app-pdf')

@section('title', 'Print salida')

@section('css')

@endsection

@section('content')

@include('admin.print.salidas-header')

<div class="table-datapos">
    <div class="table-responsive">

        <table class="table table-borderless">
            <tr>
                <td>Consulta x fechas </td>
                <td class=" text-center">Desde <strong> {{ date('d-m-Y',strtotime($desde)) }} </strong> - hasta <strong> {{ date('d-m-Y',strtotime($hasta)) }} </strong> </td>
                <td class=" text-right">Página :: <strong> <span class="pagenum"></span> </strong> </td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <td>origen </td>
                <td>id </td>
                <td>fecha </td>
                <td>tipo </td>
                <td>codtienda </td>
                <td>codproducto </td>
                <td>cantidad </td>
            </tr>
            @if (isset($arrMovements))
                @foreach ($arrMovements as $salida)
                <tr>
                    <td>{{ $salida->origen      }}</td>
                    <td>{{ $salida->id          }}</td>
                    <td>{{ $salida->fecha       }}</td>
                    <td>{{ $salida->tipo        }}</td>
                    <td>{{ $salida->codtienda   }}</td>
                    <td>{{ $salida->codproducto }}</td>
                    <td>{{ $salida->cantidad    }}</td>
                </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>

@endsection