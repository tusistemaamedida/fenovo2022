@extends('layouts.app-pdf')

@section('title', 'Remito')

@section('content')

    @include('print.remito_encabezado')

    @foreach ($array_productos as $p)
        <tr>
            <td class=" text-center">{{$p->cant}}</td>
            <td class=" text-center">#</td>
            <td class=" text-center">{{ $p->codigo }}</td>
            <td>{{ $p->name }}</td>
            <td class=" text-center">{{ $p->unity }}</td>
            <td class=" text-center">{{ $p->total_unit }}</td>
        </tr>

        <!-- Revisa si al imprimir el detalle, supera la linea 22 -->
        @if ($loop->iteration % 30 == 0)
            </table>
            <div class="page-break"></div>
            @include('print.remito_encabezado')
        @endif
        {{-- Fin revision --}}

    @endforeach

    </table>

    <table class="table table-borderless" style="margin-top: 1.5cm; ">
        <tr>
            <th>NETO:</td>
            <th>$ {{ number_format($neto, 2, ',', '.') }}</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

@endsection
