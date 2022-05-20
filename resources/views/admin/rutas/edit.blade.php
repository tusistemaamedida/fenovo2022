@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                            <div class="card-header align-items-center  border-bottom-dark px-0">
                                <div class="card-title mb-0">
                                    <h4 class="card-label mb-0 font-weight-bold text-body">
                                        Editar ruta
                                    </h4>
                                </div>
                                <div class="icons d-flex">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">

                                {!! Form::model($ruta, ['route' => ['rutas.update', $ruta->id], 'method' => 'POST']) !!}

                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            {!! Form::label('nombre', 'Nombre') !!}
                                            {!! Form::text('nombre', null, ['class' => 'form-control', 'required', 'placeholder' => 'Nombre ruta']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" @if (isset($ruta) && $ruta->active) checked="" @endif name="active" id="active" value='1'>
                                        <label class="custom-control-label" for="active">Activo</label>
                                    </div>
                                </div>

                                <div class="row mb-3 mt-3">
                                    <div class="col-12">
                                        <hr />
                                    </div>
                                </div>

                                <div class="row mb-5 mt-3">
                                    <div class="col-6">
                                        <p>Localidades</p>
                                        <fieldset class="form-group mb-3">
                                            <select class="js-example-basic-single js-states form-control bg-transparent" name="localidades[]" id="localidades" multiple="multiple" size=10>
                                                @foreach ( $localidades as $localidad )
                                                <option value="{{$localidad->id}}" @if (isset($ruta) && in_array($localidad->id, $ruta->localidades->pluck('id')->toArray() )) selected @endif>
                                                    {{$localidad->nombre}} - {{$localidad->provincia }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>

                                    <div class="col-6">
                                        <p>Transportistas</p>
                                        <fieldset class="form-group mb-3">
                                            <select class="js-example-placeholder-multiple js-states form-control" multiple="multiple" name="transportistas[]" id="transportistas" size=5>
                                                <option value="" disabled>Seleccione ...</option>
                                                @foreach ( $transportistas as $transportista )
                                                <option value="{{$transportista->id}}" @if (isset($ruta) && in_array($transportista->id, $ruta->transportistas->pluck('id')->toArray() )) selected @endif>
                                                    {{$transportista->nombre}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>

                                <input type="hidden" name="ruta_id" value="{{$ruta->id}}" />

                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Actualizar</button>
                                </div>

                                {{ Form::close() }}

                            </div>
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
    jQuery(".js-example-placeholder-multiple").select2({
        placeholder: "Seleccione transportista"
    });
</script>

@endsection