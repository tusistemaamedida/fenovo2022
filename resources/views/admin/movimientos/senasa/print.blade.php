@extends('layouts.app-pdf')

@section('title', 'Salida Senasa')

@section('css')

@endsection

@section('content')

@include('admin.movimientos.senasa.encabezado')

    @foreach($movimientos as $movimiento)
    <tr>
        <td class="text-center">{{ $movimiento->bultos }}</td>
        <td>{{ $movimiento->name }}</td>
        <td class="text-center">{{ number_format($movimiento->kilos,2) }}</td>
        <td class="text-center"></td>
        <td class="text-center"></td>
    </tr>

        <!-- Revisa si al imprimir el detalle, supera la linea 27 -->
        @if ($loop->iteration % 26 == 0)

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
        <td class="text-center"> <strong> {{ number_format($movimientos->sum('kilos'),2) }} Kgrs</strong></td>
        <td class="text-center"> </td>
        <td class="text-center"> </td>
    </tr>
</table>

@include('admin.movimientos.senasa.footer-salida')

@endsection