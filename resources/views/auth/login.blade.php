@extends('layouts.app')


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
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <label for="email">Correo electrónico </label>
                                        <input type="email" autofocus
                                            class="form-control  border-dark @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="example@mail.com" id="exampleInputEmail1"
                                            aria-describedby="emailHelp">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <label for="password">Contraseña</label>
                                        <div class="input-group mb-3">
                                            <input type="password" placeholder="ingrese su clave aquí"
                                                class="form-control border-dark  @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password" id="password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">
                                                    <span class="fa fa-eye show-t"></span>
                                                </span>
                                            </div>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <div id="g-recaptcha" style="transform:scale(0.98);transform-origin:0 0">
                                            {!! htmlFormSnippet() !!}
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span
                                                    class=" text-dark">{{ $errors->first('g-recaptcha-response') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <input type="submit" class="btn btn-lg btn-outline-dark btn-block"
                                            value="Ingresar" />
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
