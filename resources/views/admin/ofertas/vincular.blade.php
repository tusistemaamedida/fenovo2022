@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">

        {!! Form::model($oferta, ['route' => ['oferta.vincular.tienda.update'], 'method' => 'POST']) !!}

        {!! Form::hidden('id', $oferta->id) !!}

        <div class="row mt-3 mb-5">
            <div class="col-md-6">
                <h4>Tiendas para asociar la oferta</h4>
            </div>
        </div>

        <div class="row mt-3 mb-5">
            <div class="col-md-4 font-weight-bolder">
                {{ $oferta->product->cod_fenovo }} - {{ $oferta->product->name }}
            </div>
       
            <div class="col-md-4">
                Fechas vigencia <span class=" font-weight-bolder"> {{ date('d-m-Y', strtotime($oferta->fecha_desde)) }} </span> al <span class=" font-weight-bolder"> {{ date('d-m-Y', strtotime($oferta->fecha_hasta)) }} </span>
            </div>
        
            <div class="col-md-4 text-right">
                {!! Form::submit('actualizar', ['class' => 'btn btn-dark']) !!}
            </div>
        </div>

        <div class="row mb-5 mt-3">
            <div class="col-md-3">
                @foreach ($stores as $store)
                {{ Form::checkbox('stores[]', $store->id ) }}
                <label class="ml-3 mb-3">
                    <span class="badge badge-dark"> {{$store->store_type}} </span> ({{ str_pad($store->cod_fenovo, 4, 0, STR_PAD_LEFT) }}) - {{$store->description}}
                </label>
                <br>

                @if ($loop->iteration % 8 == 0)
            </div>
            <div class="col-md-3"> @endif
                @endforeach
            </div>
        </div>


        {!! Form::close() !!}

    </div>

</div>

@endsection