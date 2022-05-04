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
                            Menú :: Setting Sistema
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
                        <div class="col-2">
                            <fieldset class="input-group form-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Desde</span>
                                </div>
                                <input type="date" name="salidaDesde" id="salidaDesde" value="{{ date('Y-m-d', strtotime($carbon::now())) }}" class="form-control border-dark" autofocus>
                            </fieldset>
                        </div>
                        <div class="col-2">
                            <fieldset class="input-group form-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Hasta</span>
                                </div>
                                <input type="date" name="salidaHasta" id="salidaHasta" value="{{ date('Y-m-d', strtotime($carbon::now())) }}" class="form-control border-dark">
                            </fieldset>
                        </div>

                        <div class="col-2">
                            <a href="javascript:void(0)" onclick="printMovimientos()"> <i class=" fa fa-print"></i> Imprimir</a>
                        </div>

                        <div class="col-2">
                            <a href="javascript:void(0)" onclick="exportarMovimientosCSV()"> <i class=" fa fa-file-csv"></i> Exportar</a>
                        </div>

                        <div class="col-2">

                        </div>

                    </div>
                </div>                

            </div>
        </div>
    </div>

    @endsection

    @section('js')

    <script>
        

    </script>

    @endsection
