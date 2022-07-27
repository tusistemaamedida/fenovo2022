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
                                    <h5>Actualice su clave</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('mis.facturas.update.password') }}">
                                @csrf

                                <input type="text" id="store_id" name="store_id" value="{{ $store->id }}">
                                <div class="row mb-5">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <label for="clave">Ingrese clave</label>
                                        <input type="text" name="clave" id="clave" value="" required
                                            autofocus class="form-control input border-dark">
                                        <small> (Ingrese hasta 10 caracteres)</small>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <label for="clave_verify">Vuelva a escribir su clave</label>
                                        <input type="text" name="clave_verify" id="clave_verify" required
                                            onkeyup="coincidir(this)" class="form-control input border-dark">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <div id="mensaje" class="alert alert-card alert-danger d-none" role="alert">
                                            Verifique que escribió hasta 10 caracteres y que coincidan ambos ingresos.
                                        </div>
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
        const coincidir = (objeto) => {
            let clave = jQuery("#clave").val();
            if (clave == objeto.value) {
                jQuery("#btn-actualizar").attr('disabled', false);
            }else{
                jQuery("#btn-actualizar").attr('disabled', true);
            }
        }
    </script>
@endsection
