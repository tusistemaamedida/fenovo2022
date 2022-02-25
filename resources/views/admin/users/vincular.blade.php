@extends('layouts.app')

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">Vincular usuario - tiendas</li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">


        {!! Form::model($user, ['route' => ['users.vincular.tienda.update'], 'method' => 'POST']) !!}

        {!! Form::hidden('id', $user->id) !!}

        <div class="row">
            <div class="col-6">
                <label>Nombre y apellido</label>
                <input type="text" id="name" name="name" @if (isset($user)) value="{{$user->name}}" @else value="" @endif class="form-control" autocomplete="off">
            </div>
            <div class="col-6">
                <label>Username</label>
                <input type="text" name="username" @if (isset($user)) value="{{$user->username}}" @else value="" @endif class="form-control" autocomplete="off">
            </div>
        </div>

        <div class="row text-center mt-4">
            <div class="col-9">

            </div>
            <div class="col-3">
                {!! Form::submit('actualizar', ['class' => 'link']) !!}
            </div>
        </div>

        <div class="row mb-5 mt-3">
            <div class="col-3">
                @foreach ($stores as $store)
                <label>
                    {{ Form::checkbox('stores[]', $store->id ) }}
                    {{$store->description}}
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
                {!! Form::submit('actualizar', ['class' => 'link']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

</div>

@endsection