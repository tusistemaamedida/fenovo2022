@extends('layouts.app')

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">Roles</li>
            </ol>
        </nav>
    </div>
</div>

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
                                        Editar rol
                                        </h3>
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

                                {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'POST']) !!}

                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            {!! Form::label('name', 'Nombre') !!}
                                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Nombre de rol']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" @if (isset($role) && $role->active) checked="" @endif name="active" id="active" value='1'>
                                        <label class="custom-control-label" for="active">Activo</label>
                                    </div>
                                </div>

                                <div class="form-group d-none">
                                    <label class="text-dark">Guard Name</label>
                                    <input type="text" id="guard_name" name="guard_name" @if (isset($role)) value="{{$role->guard_name}}" @else value="web" @endif class="form-control">
                                </div>

                                <div class="form-group mt-5 mb-3">
                                    <h5 class=" font-size-bold">Permisos</h5>
                                </div>


                                <div class="row mb-5 mt-3">
                                    <div class="col-3">
                                        @foreach ($permissions as $permiso)
                                        <label>
                                            {{ Form::checkbox('permissions[]', $permiso->id ) }}
                                            {{$permiso->name}}
                                        </label>
                                        <br>

                                        @if ($loop->iteration % 8 == 0)
                                    </div>
                                    <div class="col-4"> @endif
                                        @endforeach
                                    </div>
                                </div>


                                <input type="hidden" name="role_id" value="{{$role->id}}" />

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

</script>

@endsection