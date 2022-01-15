@extends('layouts.app')

@section('css')
	<link href="{{asset('assets/api/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-solid">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                    <li class="breadcrumb-item active" aria-current="page">Productos</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid addproduct-main">

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-custom gutter-b bg-white border-0">

                        <div class="card-header align-items-center  border-0">
                            <div class="card-title mb-0">
                                <h3 class="card-label mb-0 font-weight-bold text-body">Agregar nuevo producto</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab1" role="tablist">
                                <li class="nav-item mr-2">
                                    <a class="nav-link btn-light active shadow-none" id="home-tab-basic" data-toggle="pill" href="#home-basic" role="tab" aria-controls="home-basic" aria-selected="true">
                                      Home
                                </a>
                                </li>
                                <li class="nav-item mr-2">
                                    <a class="nav-link btn-light shadow-none" id="service-tab-basic" data-toggle="pill" href="#service-basic" role="tab" aria-controls="service-basic" aria-selected="false">
                                    Service
                                  </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn-light shadow-none" id="account-tab-basic" data-toggle="pill" href="#account-basic" role="tab" aria-controls="account-basic" aria-selected="false">
                                      Account
                                    </a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent1">
                                        <div class="tab-pane fade show active" id="home-basic" role="tabpanel" aria-labelledby="home-tab-basic">
                                            @include('admin.products.form-product-details')
                                        </div>
                                        <div class="tab-pane fade " id="service-basic" role="tabpanel" aria-labelledby="service-tab-basic">
                                            <p class="text-dark">
                                                ..Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque lorem est, vestibulum eu ex ac, mattis aliquam turpis. Vivamus sed orci nibh. Donec scelerisque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque lorem est, vestibulum
                                                eu ex ac, mattis aliquam turpis. Vivamus sed orci nibh. Donec scelerisque
                                            </p>
                                        </div>
                                        <div class="tab-pane fade " id="account-basic" role="tabpanel" aria-labelledby="account-tab-basic">
                                            <p class="text-dark">
                                                .Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque lorem est, vestibulum eu ex ac, mattis aliquam turpis. Vivamus sed orci nibh. Donec scelerisque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque lorem est, vestibulum
                                                eu ex ac, mattis aliquam turpis. Vivamus sed orci nibh. Donec scelerisque
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('assets/api/select2/select2.min.js')}}"></script>
    <script>
        jQuery(document).ready(function() {
			  jQuery('.js-example-basic-single').select2();
		  });
    </script>
@endsection
