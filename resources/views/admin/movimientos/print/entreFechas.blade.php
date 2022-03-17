@extends('layouts.app-pdf')

@section('title', 'Print salida')

@section('css')

@endsection

@section('content')

@include('admin.movimientos.print.salidas-header')

<div class="table-datapos">
    <div class="table-responsive">

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
                <td>Origen</td>
                <td>Destino</td>
                <td>Tipo</td>
                <td>Comprobante</td>
                <td>Kgrs</td>
            </tr>
            @if (isset($salidas))
            @foreach ($salidas as $salida)
            <tr>
                <td>{{$salida->id}}</th>
                <td>{{ date('d-m-Y',strtotime($salida->date)) }}</td>
                @if ( in_array($salida->type, ['DEVOLUCION', 'DEVOLUCIONCLIENTE']) )
                    <td>
                        {{ $salida->To($salida->type); }}        
                    </td>
                    <td>
                        {{ $salida->From($salida->type); }}
                    </td>                
                @else
                    <td>
                        {{ $salida->From($salida->type); }}        
                    </td>
                    <td>
                        {{ $salida->To($salida->type); }}
                    </td>                    
                @endif                
                <td>
                    {{ $salida->type }}
                </td>
                <td>{{ $salida->voucher_number }}</td>
                <td>{{ $salida->totalKgrs() }}</td>
            </tr>
            @endforeach
            @endif

        </table>

    </div>
</div>

@endsection