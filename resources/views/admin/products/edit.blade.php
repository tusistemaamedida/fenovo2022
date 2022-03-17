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

<div class="d-flex flex-column-fluid">
    <div class="container-fluid addproduct-main">

        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card card-custom gutter-b bg-white border-0">

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="card-header align-items-center  border-0">
                                <div class="card-title mb-0">
                                    <h4 class="card-label mb-0 font-weight-bold text-body">
                                        Editar Producto - <small>{{ $product->cod_fenovo }} :: {{ $product->name }}</small>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 mt-4 text-right">
                            @can('products.create')
                            <a href="{{url('oferta')}}" title="Oferta de precios" class="mr-3">
                                Ofertas
                            </a>
                            <a href="{{url('actualizacion')}}" title="Actualización de precios" class="mr-3">
                                Actualizaciones
                            </a>
                            @endcan
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
                                    <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="fecha_actualizacion_activa" value="{{$fecha_actualizacion_activa}}">
                                    <input type="hidden" name="fecha_actualizacion_label" value="{{$fecha_actualizacion_label}}">
                                @else
                                    <input type="hidden" name="product_id" id="product_id" value="0">
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

                                @if (isset($product))
                                    <div class="col-12" style="float: right">
                                        <button type="button" class="btn btn-primary" onclick="updateProduct('{{ route('product.update') }}')" style="float: right"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                @endif
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
        var text = '';
        var fecha_actualizacion = jQuery("#fecha_actualizacion_activa").val();
        var fecha_actualizacion_label = jQuery("#fecha_actualizacion_label").val();
        if(fecha_actualizacion == 0 || fecha_actualizacion == '0'){
            text = 'Está por modificar los precios actuales!';
        }else{
            text = 'Está por modificar los precios del ' + fecha_actualizacion_label +'!';
        }
        ymz.jq_confirm({
            title: 'Actualización!',
            text: text,
            no_btn: "Cancelar",
            yes_btn: "Confirmar",
            no_fn: function () {
                return false;
            },
            yes_fn: function () {
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
            }
        });
    };

    function updatePrices(){
        var fecha_actualizacion = jQuery("#fecha_actualizacion").val();
        if(fecha_actualizacion){
            ymz.jq_confirm({
            title: 'Actualización!',
            text: "Actualizar precios ?",
            no_btn: "Cancelar",
            yes_btn: "Confirmar",
            no_fn: function () {
                return false;
            },
            yes_fn: function () {
                var elements = document.querySelectorAll('.is-invalid');
                var form = jQuery('#formData').serialize();
                jQuery.ajax({
                    url: "{{route('actualizar.precios')}}",
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
                    }
                });
            }
        });
        }else{
            alert('DEBE INGRESAR UNA FECHA DE ACTUALIZACIÓN');
        }
    }

    function updateOferta(){
        var fecha_desde = jQuery("#fecha_desde").val();
        var fecha_hasta = jQuery("#fecha_hasta").val();

        if(fecha_desde !== '' && fecha_hasta !== '' ){

            var elements = document.querySelectorAll('.is-invalid');
            var form = jQuery('#formData').serialize();
            jQuery.ajax({
                url: "{{route('actualizar.oferta')}}",
                type: 'POST',
                data: form,
                beforeSend: function () {
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].classList.remove('is-invalid');
                    }
                    jQuery('#loader').removeClass('hidden');
                },
                success: function (response) {
                    jQuery("#divOferta").html(response['divOferta']);  
                    jQuery("#divPanel").html(response['divPanel']);   
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
                }
            })
        }else{
            toastr.error('Ingrese FECHA DESDE - HASTA', 'Oferta');
        }
    }

    const deleteOferta = (id) => {
        jQuery.ajax({
            url: '{{ route('oferta.destroyReload') }}',
            type: 'POST',
            data: {id},
            success: function (response) {                    
                jQuery("#divOferta").html(response['divOferta']);                
                jQuery("#divPanel").html(response['divPanel']);
            }
        });
    }
</script>
@endsection
