@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">Ajuste entre Depósitos</li>
            </ol>
        </nav>
    </div>
</div>
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">

        <div class="card gutter-b bg-white border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <label>Fecha</label>                                         
                    </div>
                    <div class="col-md-3">
                        <label>Origen</label>
                    </div>
                    <div class="col-md-3">
                        <label>Destino</label>
                    </div>
                    <div class="col-md-2 text-center">
                        <label>Comprobante</label>
                    </div>                    
                </div>
                <div class="row font-weight-bolder">
                    <div class="col-md-2">                
                        {{ date('d-m-Y',strtotime($movement->date)) }}                        
                    </div>
                    <div class="col-md-3">
                        {{ $movement->From($movement->type) }}
                    </div>
                    <div class="col-md-3">
                        {{ $movement->To($movement->type) }}
                    </div>
                    <div class="col-md-2 text-center">
                        {{ $movement->voucher_number }}
                    </div>                    
                </div>
            </div>
        </div>

        <div class="card gutter-b bg-white border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        @isset($movimientos)
                        <div class="table-datapos">
                            <div class="table-responsive">
                                <table class=" table table-hover table-sm text-center">
                                    <tr class=" bg-dark text-white">
                                        <th>#</th>
                                        <th>Cod fenovo</th>
                                        <th>Producto</th>
                                        <th>Medida</th>
                                        <th>Kgrs</th>
                                        <th>Presentación</th>
                                        <th>$_Costo </th>
                                        <th>Bultos</th>
                                        <th>$_Total</th>
                                        <th>Unidades</th>
                                    </tr>

                                    @php
                                    $total = 0;
                                    @endphp

                                    @foreach ($movimientos as $movimiento)

                                    @php
                                    $total += $movimiento->cost_fenovo*$movimiento->unit_package*$movimiento->bultos;
                                    @endphp
                                    <tr>
                                        <td> {{ $loop->iteration }}</td>
                                        <td> {{ $movimiento->product->cod_fenovo }} </td>
                                        <td class=" text-left"> {{ $movimiento->product->name }}</td>
                                        <td> {{ $movimiento->unit_type }} </td>
                                        <td> {{ number_format($movimiento->product->unit_weight*$movimiento->unit_package*$movimiento->bultos,2, ',', '.') }}</td>
                                        <td> {{ $movimiento->unit_package }} </td>
                                        <td> {{ $movimiento->cost_fenovo }}</td>
                                        <td> {{ $movimiento->bultos }}</td>
                                        <td> {{ number_format($movimiento->cost_fenovo*$movimiento->unit_package*$movimiento->bultos,2, ',', '.') }} </td>
                                        <td> {{ number_format($movimiento->unit_package * $movimiento->bultos,0,'','') }} </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="10">
                                            </hr>
                                        </th>
                                    </tr>
                                    <tr class=" bg-dark text-black-50">
                                        <th>Totales</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ number_format($movement->totalKgrs(),2, ',', '.') }}</th>
                                        <th></th>
                                        <th></th>
                                        <th> {{ $movimientos->sum('bultos')}} </th>
                                        <th> {{ number_format($total, 2,',', '.')}} </th>
                                        <th></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    @endsection

    @section('js')

    @endsection