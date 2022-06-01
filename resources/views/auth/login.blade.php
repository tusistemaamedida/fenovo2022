@extends('layouts.app')


@section('content')

<div class="container-fluid h-100" style=" background-color:#1a3353 ">

    <div class="d-flex justify-content-center align-items-center h-100">

        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card card-custom p-5">
                    <div class="card-title mb-0 text-center">
                        <h4>
                            <img src="{{asset('assets/images/misc/logo.png')}}" alt="fenovo" class=" img-fluid">
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <p>Usuario</p>
                            <div class="input-group mb-3">                                
                                <input type="email" class="form-control  border-dark @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="example@mail.com" id="exampleInputEmail1" aria-describedby="emailHelp">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>                      
                            
                            <p>Contraseña</p>
                            <div class="input-group mb-3">
                                <input type="password" placeholder="......." class="form-control border-dark  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">
                                        <span class="fa fa-eye show-t"></span>
                                    </span>    
                                </div>
                            </div>                           
                                                            
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror    

                            <div class="input-group mb-3">
                                <div id="g-recaptcha" style="transform:scale(0.97);transform-origin:0 0">
                                    {!! htmlFormSnippet() !!}
                                    @if($errors->has('g-recaptcha-response'))
                                    <span class=" text-primary">{{ $errors->first('g-recaptcha-response') }}</span>
                                    @endif
                                </div>
                            </div>
                            

                            <div class="input-group mb-3">
                                <input type="submit" class="btn btn-outline-dark btn-block" value="Ingresar"/>
                            </div>
                            

                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection