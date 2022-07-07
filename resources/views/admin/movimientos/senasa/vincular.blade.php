@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">

        {!! Form::model($senasa, ['route' => ['senasa.vincularStore'], 'method' => 'POST']) !!}

        {!! Form::hidden('id', $senasa->id) !!}

        <div class="row mt-5 mb-3">
            <div class="col-12">
                <h4>Vincular habilitación con salidas</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class=" table">
                    <tr>
                        <th class="w-25">
                            Nro habilitación
                        </th>
                        <th>
                            {{ $senasa->habilitacion_nro }}
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

        <div class="row mt-3">
            <div class="col-12">

                <div class="table-datapos">
                    <div class="table-responsive">
                        <table class=" table table-hover table-striped table-light text-center yajra-datatable">
                            <thead>
                                <tr class=" bg-dark text-white-50">
                                    <td>Fecha   </td>
                                    <td>Destino </td>
                                    <td>Tipo movimiento </td>
                                    <td>Comprobante nro </td>
                                    <td>Vincular </td>
                                </tr>
                            </thead>
                            @foreach ($movements as $movement)

                            <tr>

                                <td> {{ date('d-m-Y', strtotime($movement->date)) }}  </td>
                                <td class="text-left"> {{ $movement->origenData($movement->type);}}     </td>
                                <td> {{ $movement->type }}                            </td>
                                <td> {{ $movement->voucher_number }}                  </td>
                                <td> 
                                    <label class="checkbox-inline" >
                                        {{ Form::checkbox('movements[]', $movement->id, null) }}
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
                {!! Form::submit('Vincular', ['class' => 'btn btn-dark']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

</div>

@endsection

@section('js')
<script>

    var dataTable = jQuery(".yajra-datatable").DataTable({
        ordering: false,
        scrollY: 300,
        paging: false,
    })

</script>
@endsection