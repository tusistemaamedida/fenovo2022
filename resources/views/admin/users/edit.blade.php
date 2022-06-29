@extends('layouts.app')

@section('content')
    <div class="row mt-5">
        <div class="w-50 mx-auto">
            <div class=" card bg-dark text-white">
                <div class="card-header">
                    <h4 class=" text-center">
                        <i class="fa fa-user "></i> Datos del usuario 
                    </h4>
                </div>

                <div class="card-body">

                    <form id="formData" autocomplete="off">
                        @csrf                    

                        <input type="hidden" name="user_id" value="{{ $user->id }}" />

                        <div class="form-group m-4 mt-3">
                            <label>Email</label>
                            <input type="email" id="email" name="email"
                                @if (isset($user)) value="{{ $user->email }}" @else value="" @endif
                                class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group m-4">
                            <label>Password</label>
                            <input type="password" id="password" name="password" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group m-4">
                            <label>Confirm Password</label>
                            <input type="password" id="confirm-password" name="confirm-password" class="form-control"
                                autocomplete="off">
                        </div>

                        <div class="form-group m-4 mt-5">
                            <label>Nombre usuario</label>
                            <input type="text" name="username"
                                @if (isset($user)) value="{{ $user->username }}" @else value="" @endif
                                class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group m-4">
                            <label>Nombres y apellido</label>
                            <input type="text" id="name" name="name"
                                @if (isset($user)) value="{{ $user->name }}" @else value="" @endif
                                class="form-control" autocomplete="off">
                        </div>

                        <div class="d-none">
                            <select class="rounded form-control bg-transparent" name="rol_id">
                                
                            </select>
                            <input type="checkbox" class="custom-control-input"
                                @if (isset($user) && $user->active) checked="" @endif name="active" id="active" value='1'>
                        </div>

                    
                        <div class="form-group m-4 mb-5">
                            <button type="button" class="btn btn-outline-light btn-actualizar btn-block"
                                onclick="actualizar('{{ route('users.update') }}')">
                                <i class="fa fa-save"></i> Actualizar
                            </button>
                        </div>
                    
                    </form>

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
                beforeSend: function() {
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].classList.remove('is-invalid');
                    }
                    jQuery('#loader').removeClass('hidden');
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        toastr.info(data['msj'], 'Registro');
                    } else {
                        toastr.error(data['html'], 'Verifique');
                    }
                },
                error: function(data) {
                    var lista_errores = "";
                    var data = data.responseJSON;
                    jQuery.each(data.errors, function(index, value) {
                        lista_errores += value + '<br />';
                        jQuery('#' + index).addClass('is-invalid');
                    });
                    toastr.error(lista_errores, 'Verifique');
                },
                complete: function() {
                    jQuery('#loader').addClass('hidden');
                }
            });
        };
    </script>
@endsection
