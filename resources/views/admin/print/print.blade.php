@extends('layouts.app')

@section('content')

@inject('carbon', 'Carbon\Carbon')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row mt-5">
                    <div class="col-lg-12 col-xl-6">
                        <h4 class="card-label mb-0 font-weight-bold text-body">
                            Menú :: Impresión | Exportación
                        </h4>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-xl-12 col-lg-12 ">
                        &nbsp;
                    </div>
                </div>
                <div class="card card-body gutter-b bg-white border-0">

                    <div class="row mt-3 ml-3 mb-4 font-weight-bolder">
                        <div class="col-12">
                            Movimientos
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-3">
                            <fieldset class="input-group form-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Desde</span>
                                </div>
                                <input type="date" name="salidaDesde" id="salidaDesde" value="{{ date('Y-m-d', strtotime($carbon::now())) }}" class="form-control border-dark" autofocus>
                            </fieldset>
                        </div>
                        <div class="col-3">
                            <fieldset class="input-group form-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Hasta</span>
                                </div>
                                <input type="date" name="salidaHasta" id="salidaHasta" value="{{ date('Y-m-d', strtotime($carbon::now())) }}" class="form-control border-dark">
                            </fieldset>
                        </div>
                        <div class="col-2">
                            <fieldset class="input-group form-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Movim</span>
                                </div>
                                <select class="rounded form-control bg-transparent" name="tiposalida" id="tiposalida">
                                    <option value="">TODOS</option>
                                    @foreach ($tiposalidas as $tiposalida)
                                    <option value="{{$tiposalida['type']}}">
                                        {{$tiposalida['type'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-2">
                            <a href="javascript:void(0)" onclick="printMovimientos()"> <i class=" fa fa-print"></i> Imprimir</a>
                        </div>

                        <div class="col-2">
                            <a href="javascript:void(0)" onclick="exportarMovimientosCSV()"> <i class=" fa fa-file-csv"></i> Exportar</a>
                        </div>

                    </div>
                </div>

                <div class="card card-body gutter-b bg-white border-0">
                    <div class="row mt-3 ml-3 mb-4 font-weight-bolder">
                        <div class="col-12">
                            Exportación Diaria Fenovo
                        </div>
                    </div>
                    <div class="row mb-5 ml-2 border-bottom-dark">
                        <div class="col-2">
                            <a href="{{route('products.exportCSV')}}" title="Exportar todos los productos" class="mt-1 mr-3">
                                <i class=" fa fa-file-csv"></i> Productos
                            </a>
                        </div>
                        <div class="col-2">
                            <a href="{{route('products.exportPresentacionesCSV')}}" title="Exportar presentaciones" class="mt-1 mr-3">
                                <i class=" fa fa-file-csv"></i> Presentaciones
                            </a>
                        </div>

                        <div class="col-2">
                            <a href="{{route('products.exportDescuentosCSV')}}" title="Exportar descuentos" class="mt-1 mr-3">
                                <i class=" fa fa-file-csv"></i> Descuentos
                            </a>
                        </div>

                        <div class="col-2">
                            <a href="{{ route('oferta.exportCSV') }}">
                                <i class=" fa fa-file-csv"></i> Ofertas
                            </a>
                        </div>

                        <div class="col-2">
                            <a href="{{ route('oferta.excepciones.exportCSV') }}">
                                <i class=" fa fa-file-csv"></i> Excepciones
                            </a>
                        </div>

                    </div>

                    <div class="row mb-5 ml-2 border-bottom-dark">
                        <div class="col-2">
                            <a href="{{ route('actualizacion.exportCSVM1') }}" class="ml-2 mr-2">
                                <i class=" fa fa-file-csv"></i> Actualiz. precio lista 1
                            </a>
                        </div>
                        <div class="col-2">
                            <a href="{{ route('actualizacion.exportCSVM2') }}" class="ml-2 mr-2">
                                <i class=" fa fa-file-csv"></i> Actualiz. precio lista 2
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @section('js')

    <script>
        let desde;
    let hasta;
    let tipo;

    const leerDatos = ()=>{
        desde = jQuery("#salidaDesde").val();
        hasta = jQuery("#salidaHasta").val();
        tipo = jQuery("#tiposalida").val();
    }

    const exportarMovimientosCSV = ()=>{
        leerDatos();
        let url = "{{route('movement.exportCSV', '')}}"+"?desde="+desde+"&hasta="+hasta+"&tipo="+tipo;
        window.location = url;
    }

    const printMovimientos= ()=>{
        leerDatos();
        let url = "{{route('movement.printPDF', '')}}"+"?desde="+desde+"&hasta="+hasta+"&tipo="+tipo;
        window.location = url;
    }

    </script>

    @endsection