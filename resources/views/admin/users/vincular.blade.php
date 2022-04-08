@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">

        {!! Form::model($user, ['route' => ['users.vincular.tienda.update'], 'method' => 'POST']) !!}

        {!! Form::hidden('id', $user->id) !!}

        <div class="row mb-4">
            <div class="col-xs-12 col-12">
                <h5>Tiendas para asociar al usuario</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                Nombre y apellido <span class=" font-weight-bolder"> {{$user->name}} </span> :: 
                Username <span class=" font-weight-bolder"> {{$user->username}} </span> :: Rol <span class=" font-weight-bolder">{{ $user->rol() }}</span>
            </div>
            <div class="col-6 text-right">
                {!! Form::submit('actualizar', ['class' => 'btn btn-dark']) !!}
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
            <div class="col-3"> @endif
                @endforeach
            </div>
        </div>

        {!! Form::close() !!}

    </div>

</div>

@endsection