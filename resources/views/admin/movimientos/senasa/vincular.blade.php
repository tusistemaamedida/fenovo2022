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
                {!! Form::submit('actualizar', ['class' => 'link']) !!}
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <table class=" table table-hover table-striped table-light text-center">
                    <thead>
                        <tr class=" bg-light-dark">
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