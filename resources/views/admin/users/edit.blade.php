@extends('layouts.app')

@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card-body">

    <div class="container-fluid h-75">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="row w-100 justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                    <div class="card card-custom gutter-b bg-white border-0 mb-0 p-5 login-card">
                        <div class="card-header align-items-center justify-content-center border-0 h-100px flex-column">
                            <h4> Datos de tu perfil </h4>
                        </div>
                        <div class="card-body p-0">

                            <form id="formData" autocomplete="off">
                                @csrf

                                <input type="hidden" name="user_id" value="{{$user->id}}" />

                                <div class="form-group">
                                    <label class="text-dark">Nombre y apellido</label>
                                    <input type="text" id="name" name="name" @if (isset($user)) value="{{$user->name}}" @else value="" @endif class="form-control" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label class="text-dark">Username</label>
                                    <input type="text" name="username" @if (isset($user)) value="{{$user->username}}" @else value="" @endif class="form-control" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label class="text-dark">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="text-dark">Confirm Password</label>
                                    <input type="password" id="confirm-password" name="confirm-password" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="text-dark">Email</label>
                                    <input type="email" id="email" name="email" @if (isset($user)) value="{{$user->email}}" @else value="" @endif class="form-control" autocomplete="off">
                                </div>


                                <div class="d-none">
                                    <select class="rounded form-control bg-transparent" name="rol_id">
                                        @foreach ($roles as $rol)
                                        <option value="{{$rol->id}}" @if(isset($user) && isset($user->roles->pluck('id')[0]) && ($rol->id == $user->roles->pluck('id')[0]) ) selected @endif>
                                            {{$rol->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <input type="checkbox" class="custom-control-input" @if (isset($user) && $user->active) checked="" @endif name="active" id="active" value='1'>
                                </div>

                                <div class="form-group pt-3">
                                    <button type="button" class="btn btn-primary btn-actualizar btn-block" onclick="actualizar('{{ route('users.update') }}')">
                                        <i class="fa fa-save"></i> Actualizar
                                    </button>
                                </div>

                            </form>
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
    const actualizar = (route) => {
    var elements = document.querySelectorAll('.is-invalid');
    var form = jQuery('#formData').serialize();

    jQuery.ajax({
        url: route,
        type: 'POST',
        data: form,
        beforeSend: function () {
            for (var i = 0; i < elements.length; i++) {
                elements[i].classList.remove('is-invalid');
            }
            jQuery('#loader').removeClass('hidden');
        },
        success: function (data) {
            if (data['type'] == 'success') {
                toastr.info(data['msj'], 'Registro');
            } else {
                toastr.error(data['html'], 'Verifique');
            }
        },
        error: function (data) {
            var lista_errores = "";
            var data = data.responseJSON;
            jQuery.each(data.errors, function (index, value) {
                lista_errores += value + '<br />';
                jQuery('#' + index).addClass('is-invalid');
            });
            toastr.error(lista_errores, 'Verifique');
        },
        complete: function () {
            jQuery('#loader').addClass('hidden');
        }
    });
};
</script>

@endsection