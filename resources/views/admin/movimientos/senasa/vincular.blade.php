@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">

        {!! Form::model($senasa, ['route' => ['senasa.vincularStore'], 'method' => 'POST']) !!}

        {!! Form::hidden('id', $senasa->id) !!}

        <div class="row mb-5">
            <div class="col-12">
                <h4>Vincular habilitación con salidas</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class=" table">
                    <tr>
                        <th class="w-25">
                            <h4> Nro habilitación </h4>
                        </th>
                        <th>
                            <h4> {{ $senasa->habilitacion_nro }} </h4>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Patente
                        </th>
                        <th>
                            {{ $senasa->patente_nro }}
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Precintos
                        </th>
                        <th>
                            {{ $senasa->precintos }}
                        </th>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row text-center mt-4">
            <div class="col-9">

            </div>
            <div class="col-3">
                {!! Form::submit('actualizar', ['class' => 'btn btn-dark']) !!}
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">

                <div class="table-datapos">
                    <div class="table-responsive">
                        <table class=" table table-hover table-striped table-light text-center">
                            <thead>
                                <tr class=" bg-dark text-white-50">
                                    <td class="col-1">
                                        Fecha
                                    </td>
                                    <td class="col-1">
                                        Tipo movimiento
                                    </td>
                                    <td class="col-1">
                                        Comprobante nro
                                    </td>
                                    <td class="col-1">
                                        Vincular
                                    </td>
                                </tr>
                            </thead>
                            @foreach ($movements as $movements)
                            <tr>
                                <td class="col-1">
                                    {{ date('d-m-Y', strtotime($movements->date)) }}
                                </td>
                                <td class="col-1">
                                    {{ $movements->type }}
                                </td>
                                <td class="col-1">
                                    {{ $movements->voucher_number }}
                                </td>
                                <td class="col-1">
                                    <label class="checkbox-inline">
                                        {{ Form::checkbox('movements[]', $movements->id, null) }}
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="row text-center mt-4">
            <div class="col-9">

            </div>
            <div class="col-3">
                {!! Form::submit('actualizar', ['class' => 'btn btn-dark']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

</div>

@endsection