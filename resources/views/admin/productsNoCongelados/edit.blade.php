@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('assets/css/cropper.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/fileicons.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/filepicker.css')}}">
<style>
    input[type="file"] {
        display: block;
    }
    .form-control:focus{
        border-color: #ae69f5 !important;
    }
</style>
@endsection

@section('content')

<div class="d-flex flex-column-fluid mt-5">
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
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <ul class="nav nav-pills mb-3" id="pills-tab1" role="tablist">
                                    <li class="nav-item mr-2">
                                        <a class="nav-link btn-dark active shadow-none" id="precios-tab-basic" data-toggle="pill" href="#precios" role="tab" aria-controls="precios" aria-selected="true">
                                            Precios
                                        </a>
                                    </li>
                                    <li class="nav-item mr-2" id="nav-item-precios">
                                        <a class="nav-link btn-dark shadow-none" id="detalle-tab-basic" data-toggle="pill" href="#detalle" role="tab" aria-controls="detalle" aria-selected="false">
                                            Detalles
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <form method="POST" action="{{route('product.nc.update')}}" id="formData">
                                @csrf

                                @if (isset($product))
                                    <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                                @else
                                    <input type="hidden" name="product_id" id="product_id" value="0">
                                @endif

                                <input type="hidden" name="oferta_id" id="oferta_id" value="0">

                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent1">
                                        <div class="tab-pane fade show active" id="precios" role="tabpanel" aria-labelledby="home-tab-basic">
                                            @include('admin.productsNoCongelados.form-product-prices')
                                        </div>
                                        <div class="tab-pane fade" id="detalle" role="tabpanel" aria-labelledby="service-tab-basic">
                                            @include('admin.productsNoCongelados.form-product-details')
                                        </div>
                                    </div>
                                </div>

                                @if (isset($product))
                                <div class="col-12" style="float: right">
                                    <button type="button" id="btn_product" disabled  class="btn btn-primary" onclick="updateProduct('{{ route('product.nc.update') }}')" style="float: right"><i class="fa fa-save"></i> Guardar</button>
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
        validateBtn();
    });

    function updateProduct(route){
        var text = '';

        ymz.jq_confirm({
            title: 'Actualización',
            text: '<div class="text-center">'+ text +'</div>',
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
                            setTimeout(() => {
                                window.location.reload();
                            }, 500);
                        } else {
                            toastr.error(data['msj'], 'Verifique');
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
                        jQuery(".badge").removeClass('badge-primary');
                        jQuery(".badge").addClass('badge-secondary');
                        var divOferta = document.getElementById("divFechasPrecio");
                        divOferta.innerHTML += data['divFechasPrecios'];
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
            }
        });
    }
</script>
@endsection
