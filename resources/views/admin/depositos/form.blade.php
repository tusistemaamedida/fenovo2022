@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/api/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <div class="card card-custom gutter-b bg-white border-0 mt-5">

        <div class="card-header align-items-center  border-0">
            <div class="card-title mb-0">
                <h4 class="card-label mb-0 font-weight-bold text-body"> </h4>
            </div>
        </div>

        @if (isset($store))
            {!! Form::model($store, ['route' => ['depositos.update',['store_id' =>$store->id]], 'method' => 'POST']) !!}
        @else
            {!! Form::open(['route' => 'depositos.store', 'method' => 'POST']) !!}
        @endif

        <div class="card-body">

            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="font-size-h4 font-weight-bold m-0">
                        {{ isset($store) ? 'Editar' : 'Agregar' }} depósito</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-2">
                    <label class="text-dark">Cod Fenovo</label>
                    <input type="text" id="cod_fenovo" name="cod_fenovo"
                        @if (isset($store)) value="{{ $store->cod_fenovo }}" @else value="{{$code_fenovo}}" @endif
                        class="form-control" required>
                </div>

                <div class="col-xs-12 col-md-4">
                    <label class="text-dark">Nombre Depósito</label>
                    <input type="text" id="description" name="description"
                        @if (isset($store)) value="{{ $store->description }}" @else value="" @endif
                        class="form-control" autofocus required>
                </div>

                <div class="col-xs-12 col-md-2">
                    <label class="text-dark">Abrev.</label>
                    <input type="text" id="razon_social" name="razon_social"
                        @if (isset($store)) value="{{ $store->razon_social }}" @else value="" @endif
                        class="form-control" required>
                </div>

                <div class="col-4">
                    <label class="text-dark">Responsable</label>
                    <input type="text" id="responsable" name="responsable"
                        @if (isset($store)) value="{{ $store->responsable }}" @else value="" @endif
                        class="form-control">
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-dark"><i class="fa fa-save"></i>
                        Guardar
                    </button>
                </div>
            </div>

        </div>

        {{ Form::close() }}

    </div>
@endsection
