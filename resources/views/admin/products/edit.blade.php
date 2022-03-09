@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('assets/css/cropper.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/fileicons.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/filepicker.css')}}">
<style>
    input[type="file"] {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
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
                            <h3 class="card-label mb-0 font-weight-bold text-body">
                                Editar Producto - <small>{{ $product->cod_fenovo }} :: {{ $product->name }}</small>
                            </h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab1" role="tablist">
                            <li class="nav-item mr-2">
                                <a class="nav-link btn-light active shadow-none" id="detalle-tab-basic" data-toggle="pill" href="#detalle" role="tab" aria-controls="detalle" aria-selected="true">
                                    Detalles
                                </a>
                            </li>
                            <li class="nav-item mr-2" id="nav-item-precios">
                                <a class="nav-link btn-light shadow-none" id="precios-tab-basic" data-toggle="pill" href="#precios" role="tab" aria-controls="precios" aria-selected="false">
                                    Precios
                                </a>
                            </li>
                            <li class="nav-item mr-2" id="nav-item-imagenes">
                                <a class="nav-link btn-light shadow-none" id="imagenes-tab-basic" data-toggle="pill" href="#imagenes" role="tab" aria-controls="imagenes" aria-selected="false">
                                    Imágenes
                                </a>
                            </li>
                        </ul>
                        <div class="row">
                            <form style="width: 100%;margin-top: 15px;" method="POST" action="{{route('product.update')}}" id="formData">
                                @csrf
                                @if (isset($product))
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                @endif
                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent1">
                                        <div class="tab-pane fade show active" id="detalle" role="tabpanel" aria-labelledby="home-tab-basic">
                                            @include('admin.products.form-product-details')
                                        </div>
                                        <div class="tab-pane fade" id="precios" role="tabpanel" aria-labelledby="service-tab-basic">
                                            @include('admin.products.form-product-prices')
                                        </div>
                                        <div class="tab-pane fade" id="imagenes" role="tabpanel" aria-labelledby="account-tab-basic">
                                            @include('admin.products.form-product-images')
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" style="float: right">
                                    <button type="button" class="btn btn-primary" onclick="updateProduct('{{ route('product.update') }}')" style="float: right"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@include('admin.products.images-js')
@include('admin.products.calculated-prices-js')
<script>
    jQuery( document ).ready(function() {
        jQuery("#unit_package").select2({
            tags: true
        })
    });

    function updateProduct(route){
            var elements = document.querySelectorAll('.is-invalid');
            var form = jQuery('#formData').serialize();
            jQuery.ajax({
                url: route,
                type: 'POST',
                data: form,
                beforeSend: function () {
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].classList.remove('is-invalid');
                    }
                    jQuery('#loader').removeClass('hidden');
                },
                success: function (data) {
                    if (data['type'] == 'success') {
                        toastr.info(data['msj'],'Actualización');                        
                    } else {
                        toastr.error(data['html'], 'Verifique');
                    }
                },
                error: function (data) {
                    var lista_errores = "";
                    var data = data.responseJSON;
                    jQuery.each(data.errors, function (index, value) {
                        lista_errores += value + '<br />';
                        jQuery('#' + index).addClass('is-invalid');
                    });
                    toastr.error(lista_errores, 'Verifique');
                },
                complete: function () {
                    jQuery('#loader').addClass('hidden');
                    setTimeout(() => {
                        window.location= '{{ route('products.list') }}';    
                    }, 500);
                    
                }
            });
        };
</script>
@endsection