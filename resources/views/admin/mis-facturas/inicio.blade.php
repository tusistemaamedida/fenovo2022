@extends('layouts.app-facturas')


@section('content')
    <div class="container-fluid h-100" style=" background-color:#232e67 ">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-title">
                            <div class="row text-center">
                                <div class="col-xs-12 col-md-12 col-lg-12">
                                    <img src="{{ asset('assets/images/misc/logo-color-300.png') }}" alt="fenovo" class=" img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('mis.facturas.check') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <label for="cuit">Cuit</label>
                                        <input type="number" name="cuit" id="cuit" required
                                            class="form-control input border-dark mb-2" autofocus>
                                        <small class=" text-center"> Ingrese <b>cuit</b> sin guiones ni barras, sólo números</small>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <label for="password">Contraseña</label>
                                        <input type="password" name="password" id="password" required class="form-control input border-dark">
                                        <div class="mt-3">
                                            @if (Session()->has('update-store'))
                                                <div class="alert alert-card alert-info" role="alert">
                                                    <strong>Perfecto, </strong> {!! Session::get('update-store') !!}
                                                </div>                                            
                                            @endif    
                                            @if (Session()->has('error-store'))
                                                <div class="alert alert-card alert-danger" role="alert">
                                                    <strong>Verifique, </strong>  {!! Session::get('error-store') !!}                                             
                                                </div>                                            
                                            @endif    
                                        </div>    
                                    </div>
                                </div>

                                <div class="row mt-2 mb-5">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <input type="submit" class="btn btn-dark btn-block" value="BUSCAR" />
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
        
        jQuery("#cuit").on("focus", function() {
            jQuery("cuit").val("");
        });

        jQuery("#password").on("focus", function() {
            jQuery("password").val("");
        });
        
    </script>
@endsection
