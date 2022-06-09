@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">Pedido pendiente</li>
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
                        <label>Fecha : <strong>{{ date('d-m-Y',strtotime($pedido->date)) }}</strong></label>
                    </div>
                    <div class="col-md-2 text-center">
                        <label>Nro pedido:<strong> {{ $pedido->voucher_number }} </strong></label>
                    </div>
                    <div class="col-md-8" style="float: right">
                        <a href="{{route('preparar.pedido',['id'=>$pedido->id,'nro'=>$pedido->voucher_number])}}" style="float: right"><span class="badge badge-primary p-2"><i class="fas fa-share"></i> Preparar</span></a>
                    </div>
                </div>

            </div>

            <div class="card gutter-b bg-white border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            @isset($pedido)
                            <div class="table-datapos">
                                <div class="table-responsive">
                                    <table class=" table table-hover table-sm text-center">
                                        <tr class=" bg-dark text-white">
                                            <th>#</th>
                                            <th>Cod fenovo</th>
                                            <th>Producto</th>
                                            <th>Unidad</th>
                                            <th>Kgrs</th>
                                            <th>Presentación</th>
                                            <th>Bultos</th>
                                            <th>Unidades</th>
                                        </tr>

                                        @php
                                            $total = 0;
                                        @endphp

                                        @foreach ($pedido->productos as $pedido)

                                        @php
                                            $total += $pedido->cost_fenovo*$pedido->unit_package*$pedido->bultos;
                                        @endphp
                                        <tr>
                                            <td> {{ $loop->iteration }}</td>
                                            <td> {{ $pedido->product->cod_fenovo }} </td>
                                            <td class=" text-left"> {{ $pedido->product->name }}</td>
                                            <td> {{ $pedido->unit_type }} </td>
                                            <td> {{ number_format($pedido->product->unit_weight*$pedido->unit_package*$pedido->bultos,2, ',', '.') }}</td>
                                            <td> {{ $pedido->unit_package }} </td>
                                            <td> {{ $pedido->bultos }}</td>
                                            <td> {{ number_format($pedido->unit_package * $pedido->bultos,0,'','') }} </td>
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
                                            <th></th>
                                            <th></th>
                                            <th> {{ $pedido->sum('bultos')}} </th>
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
    </div>
    @endsection

    @section('js')

    @endsection
