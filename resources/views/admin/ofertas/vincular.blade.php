@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">

        {!! Form::model($oferta, ['route' => ['oferta.vincular.tienda.update'], 'method' => 'POST']) !!}

        {!! Form::hidden('id', $oferta->id) !!}

        <div class="row mt-3 mb-5">
            <div class="col-md-6">
                <h4>{{ $oferta->product->cod_fenovo }} - {{ $oferta->product->name }} </h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <p>Oferta desde</p>
                <fieldset class="form-group mb-3">
                    <input type="date" id="fechadesde" name="fechadesde" value="{{ isset($oferta->fechadesde)?$oferta->fechadesde:null }}" class="form-control" required>
                </fieldset>
            </div>   
        
            <div class="col-md-3">
                <p>hasta</p>
                <fieldset class="form-group mb-3">
                    <input type="date" id="fechahasta" name="fechahasta" value="{{ isset($oferta->fechahasta)?$oferta->fechahasta:null }}" class="form-control" required>
                </fieldset>
            </div>    
        </div>

        <div class="row text-center mt-4">
            <div class="col-9">

            </div>
            <div class="col-3">
                {!! Form::submit('actualizar', ['class' => 'btn btn-dark']) !!}
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xs-12 col-12">
                <h5>Tiendas a asociar la <span class=" font-italic font-weight-bolder"> Oferta </span> </h5>
            </div>
        </div>

        <div class="row mb-5 mt-3">
            <div class="col-3">
                @foreach ($stores as $store)
                {{ Form::checkbox('stores[]', $store->id ) }}
                <label class="ml-3 mb-3">
                    <span class="badge badge-dark"> {{$store->store_type}} </span> ({{ str_pad($store->cod_fenovo, 4, 0, STR_PAD_LEFT) }}) - {{$store->description}}
                </label>
                <br>             

                @if ($loop->iteration % 8 == 0)
            </div>
            <div class="col-4"> @endif
                @endforeach
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