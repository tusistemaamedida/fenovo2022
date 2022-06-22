@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">Nota Débito -  Orden Nro #  <strong> {{ $movement->id }} </strong></li>
            </ol>
        </nav>
    </div>
</div>
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card gutter-b bg-white border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-body">Fecha</label>
                        <fieldset class="form-group mb-3">
                            <strong>{{ date('d-m-Y',strtotime($movement->date)) }}</strong>
                        </fieldset>
                    </div>
                    <div class="col-md-3">
                        <label class="text-body">Operación</label>
                        <fieldset class="form-group mb-3">
                            <strong>{{ $movement->type }}</strong>
                        </fieldset>
                    </div>
                    <div class="col-md-2">
                        <label class="text-body">Destino</label>
                        <fieldset class="form-group mb-3">
                            <strong>{{ $movement->origenData($movement->type) }}</strong>
                        </fieldset>
                    </div>
                    <div class="col-md-2 text-center">
                        <label class="text-dark">Factura Relacionada</label>
                        <fieldset class="form-group mb-3">
                            <strong>{{ $movement->voucher_number }}</strong>
                        </fieldset>
                    </div>
                    <div class="col-md-2 text-center">
                        <label class="text-dark">Número de ND</label>
                        <fieldset class="form-group mb-3">
                            <strong>@if($movement->invoice_fenovo()){{ $movement->invoice_fenovo()->voucher_number }}@else -- @endif</strong>
                        </fieldset>
                    </div>
                    <div class="col-md-1 text-center">

                    </div>
                    <div class="col-md-1 text-center">

                    </div>
                </div>
            </div>

            <div class="card gutter-b bg-white border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div id="dataConfirm">
                                @include('admin.movimientos.notas-credito.partials.detalleShow')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endsection

    @section('js')

    @endsection
