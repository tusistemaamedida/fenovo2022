@extends('layouts.app')

@section('content')

@inject('carbon', 'Carbon\Carbon')

<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">
                    Opciones de Impresión
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row mt-5">
                    <div class="col-lg-12 col-xl-6">
                        <h3 class="card-label mb-0 font-weight-bold text-body">
                            Salida de Mercadería
                        </h3>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-lg-12 col-xl-12">
                        &nbsp;
                    </div>
                </div>
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="row m-4 border-bottom-dark">
                        <div class="col-3">
                            <fieldset class="input-group form-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Desde</span>
                                </div>
                                <input type="date" name="salidaDesde" id="salidaDesde" value="{{ date('Y-m-d', strtotime($carbon::now()->subDays(2))) }}" class="form-control border-dark" autofocus>
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
                                    <span class="input-group-text">Tipo salida</span>
                                </div>
                                <select class="rounded form-control bg-transparent" name="tiposalida" id="tiposalida">
                                    <option value="">Seleccione un tipo ... </option>
                                    @foreach ($tiposalidas as $tiposalida)
                                    <option value="{{$tiposalida['type']}}">
                                        {{$tiposalida['type'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-3">
                            <a href="javascript:void(0)" onclick="entreFechas()"> <i class=" fa fa-print"></i> Imprimir</a>
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
    const entreFechas = ()=>{
        let desde = jQuery("#salidaDesde").val();
        let hasta = jQuery("#salidaHasta").val();
        let tipo = jQuery("#tiposalida").val();

        let url = "{{route('salidas.printEntreFechas', '')}}"+"?desde="+desde+"&hasta="+hasta+"&tipo="+tipo;
        window.location = url;
    }

</script>

@endsection