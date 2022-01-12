@extends('layouts.app')


@section('content')

<div class="container-fluid h-100 bg-image" style="background-image: url(./assets/images/misc/bg-login1.png);">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card card-custom gutter-b bg-white border-0 mb-0 p-5 login-card">
                    <div class="card-header align-items-center  justify-content-center border-0 h-100px flex-column">
                        <div class="card-title mb-0">
                            <h3 class="card-label font-weight-bold mb-0 text-body">
                                <img src="{{asset('assets/images/misc/logo.png')}}" alt="fenovo" style="height:40px;">
                            </h3>
                            <br>
                            <h3 class="font-size-h5 mb-0 mt-3 text-dark">
                                Bienvenido.
                            </h3>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <form method="POST" action="{{ route('login') }}" class="pb-5 pt-5">
                            @csrf
                            <div class="form-group  row">
                                <div class="col-lg-2 col-3 ">
                                    <label for="exampleInputEmail1" class="mb-0 text-dark">
                                        <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                          </svg>
                                    </label>
                                </div>
                                <div class="col-lg-10 col-9 pl-0">
                                    <input type="email"
                                    class="form-control bg-transparent text-dark border-0 p-0 h-20px font-size-h5 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                    placeholder="example@mail.com"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                            </div>
                            <div class="form-group row ">
                                <div class="col-lg-2 col-3 ">
                                    <label for="exampleInputPassword1" class="mb-0 text-dark">
                                        <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-lock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M11.5 8h-7a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1zm-7-1a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-7zm0-3a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/>
                                          </svg>
                                    </label>
                                </div>
                                <div class="col-lg-10 col-9 pl-0">
                                    <input type="password"
                                           placeholder="......."
                                           class="form-control text-dark bg-transparent font-size-h4 border-0 p-0 h-20px @error('password') is-invalid @enderror"
                                           name="password"
                                           required
                                           autocomplete="current-password"
                                           id="exampleInputPassword1">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row align-items-center justify-content-between">
                                <div class="col-6">
                                    <div class="form-check pl-4">
                                        <input type="checkbox" class="form-check-input ml--4"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark" for="exampleCheck1">Recordarme!</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary text-white font-weight-bold w-100 py-3" data-toggle="modal" data-target="#default">
                                Login
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
