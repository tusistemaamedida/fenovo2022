@extends('layouts.app')

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Vincular movimientos - senasa</li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">


        {!! Form::model($senasa, ['route' => ['senasa.vincularStore'], 'method' => 'POST']) !!}

        {!! Form::hidden('id', $senasa->id) !!}

        <div class="row mb-5">
            <div class="col-12">
                <table class=" table text-center">
                    <tr class=" bg-primary">
                        <td class="col-1"> Habilitación nro </td>
                        <td class="col-1"> Patente </td>
                        <td class="col-1"> Precintos </td>
                        <td class="col-1"> </td>
                    </tr>
                    <tr>
                        <th> {{ $senasa->habilitacion_nro }} </th>
                        <th> {{ $senasa->patente_nro }} </th>
                        <th> {{ $senasa->precintos }} </th>
                        <th> {!! Form::submit('actualizar', ['class' => 'link']) !!} </th>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class=" table table-hover table-striped  table-dark text-center">
                    <thead>
                        <tr>
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
                                vincular
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

        <div class="row text-center mt-4">
            <div class="col-9">

            </div>
            <div class="col-3">
                {!! Form::submit('actualizar', ['class' => 'link']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

</div>

@endsection