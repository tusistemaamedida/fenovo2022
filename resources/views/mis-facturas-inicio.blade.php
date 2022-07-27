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
                                    <img src="{{ asset('assets/images/misc/logo-color-300.png') }}" alt="fenovo"
                                    style="padding: 0;margin: -25px;height: 250px;" class=" img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('get.mis.facturas') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <label for="cuit">CUIT <span style="font-size: 11px">(sin guiones, solo números)</span></label>
                                        <input type="number" autofocus
                                            class="form-control  border-dark @error('cuit') is-invalid @enderror"
                                            name="cuit" value="{{ old('cuit') }}" required autocomplete="cuit"
                                            placeholder="20127985429" id="exampleInputcuit1"
                                            aria-describedby="cuitHelp">

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <input type="submit" class="btn btn-lg btn-outline-dark btn-block"
                                            value="Buscar" />
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
