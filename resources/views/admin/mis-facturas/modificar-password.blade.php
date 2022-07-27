@extends('layouts.app-facturas')

@section('content')

@section('content')
    <div class="container-fluid h-100" style=" background-color:#232e67 ">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-title">
                            <div class="row text-center">
                                <div class="col-xs-12 col-md-12 col-lg-12">
                                    <img src="{{ asset('assets/images/misc/logo-color-300.png') }}" alt="fenovo"
                                        class=" img-fluid">
                                    <h5>Actualice su password</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('mis.facturas.update.password') }}">
                                @csrf
                                <input type="hidden" id="store_id" name="store_id" value="{{ $store->id }}">
                                <input type="hidden" id="cuit" name="cuit" value="{{ $store->cuit }}">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <label for="password">Ingrese password</label>
                                        <input type="text" name="password" id="password" value="" required
                                            onkeyup="longitud(this)" autofocus class="form-control input border-dark">
                                        <small> Ingrese texto entre 6 y 10 caracteres</small>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <div id="mensaje" class="alert alert-card alert-danger d-none" role="alert">
     
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <label for="password_verify">Vuelva a escribir su password</label>
                                        <input type="text" name="password_verify" id="password_verify" required
                                            onkeyup="coincidir(this)" class="form-control input border-dark">
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <input type="submit" id="btn-actualizar" class="btn btn-dark btn-block"
                                            value="Actualizar" disabled=true />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        const longitud = (objeto) => {
            let password = jQuery("#password").val();

            if(password.length < 6){
                jQuery("#mensaje").html('No tiene 6 caracteres').removeClass('d-none');
                return
            }else{
                if(password.length > 10){
                    jQuery("#mensaje").html('Tiene más 10 caracteres').removeClass('d-none');
                    return
                }else{
                    jQuery("#mensaje").addClass('d-none');
                }
            }   
        }

        const coincidir = (objeto) => {
            let password = jQuery("#password").val();

            if(password.length < 6){
                jQuery("#mensaje").html('No tiene 6 caracteres').removeClass('d-none');
                return
            }else{
                if(password.length > 10){
                    jQuery("#mensaje").html('Tiene más 10 caracteres').removeClass('d-none');
                    return
                }else{
                    jQuery("#mensaje").addClass('d-none');
                }
            }

            if (password == objeto.value) {
                jQuery("#btn-actualizar").attr('disabled', false);
            }else{
                jQuery("#btn-actualizar").attr('disabled', true);
            }
        }
    </script>
@endsection
