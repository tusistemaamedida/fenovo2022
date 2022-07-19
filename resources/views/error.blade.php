@extends('layouts.app')

@section('css')

@endsection

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="row mt-5">
                    <div class="col-lg-12 col-xl-12">

                        @if(session('login-success'))
                        <div class="alert alert-info" role="alert">
                            {!! session('login-success') !!}
                        </div>
                        @endif

                        <div id="storeActiveBody">
                            {{$error}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')

@endsection
