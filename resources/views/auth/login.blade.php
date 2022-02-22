@extends('layouts.app')


@section('content')

<div class="container-fluid h-100" style=" background-color:#1a3353 ">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card card-custom p-5">
                    <div class="card-title mb-0 text-center">
                        <h3>
                            <img src="{{asset('assets/images/misc/logo.png')}}" alt="fenovo" class=" img-fluid">
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <form method="POST" action="{{ route('login') }}" style="padding: 25px">
                            @csrf
                            <div class="form-group  row">

                                <div class="col-lg-12 col-12 pl-0">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="example@mail.com" id="exampleInputEmail1" aria-describedby="emailHelp">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>

                            </div>
                            <div class="form-group row ">

                                <div class="col-lg-12 col-12 pl-0">
                                    <label for="">Password</label>
                                    <input type="password" placeholder="......." class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="exampleInputPassword1">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">

                                <div class="col-lg-12 col-12 pl-0">
                                    <div id="g-recaptcha" style="transform:scale(0.85);transform-origin:0 0">
                                        {!! htmlFormSnippet() !!}
                                        @if($errors->has('g-recaptcha-response'))
                                        <span class=" text-primary">{{ $errors->first('g-recaptcha-response') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-1 mb-4 align-items-center justify-content-between">

                                <div class="col-lg-12 col-12 pl-0">
                                    <div class="form-check pl-4">
                                        <label class="form-check-label text-dark" for="exampleCheck1">
                                            <input type="checkbox" class="form-check-input ml--4" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            Recordarme!
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-12 pl-0">
                                    <button type="submit" class="btn btn-primary text-white font-weight-bold w-100 py-3" data-toggle="modal" data-target="#default">
                                        Login
                                    </button>
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