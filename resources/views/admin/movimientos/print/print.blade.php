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
                <div class="card card-custom gutter-b bg-white border-0">

                    <div class="row mt-3 ml-3 font-weight-bolder">
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
                        <div class="col-3">
                            <fieldset class="input-group form-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Movimiento</span>
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
                        <div class="col-3">
                        </div>
                    </div>
                    <div class="row mb-5 ml-2 border-bottom-dark">
                        <div class="col-3">
                            <a href="javascript:void(0)" onclick="exportarMovimientosCSV()"> <i class=" fa fa-file-csv"></i> Exportar</a>
                        </div>
                        <div class="col-3">
                            <a href="javascript:void(0)" onclick="printMovimientos()"> <i class=" fa fa-print"></i> Imprimir</a>
                        </div>
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