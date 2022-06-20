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
                                    <li class="nav-item mr-2" id="nav-item-imagenes">
                                        <a class="nav-link btn-dark shadow-none" id="imagenes-tab-basic" data-toggle="pill" href="#imagenes" role="tab" aria-controls="imagenes" aria-selected="false">
                                            Imágenes
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                @include('admin.products.search')
                            </div>

                        </div>
                        <div class="row">
                            <form method="POST" action="{{route('product.update')}}" id="formData">
                                @csrf
                                @if (isset($product))
                                <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                                <input type="hidden" name="fecha_actualizacion_activa" id="fecha_actualizacion_activa" value="{{$fecha_actualizacion_activa}}">
                                <input type="hidden" name="fecha_actualizacion_label" id="fecha_actualizacion_label" value="{{$fecha_actualizacion_label}}">
                                @else
                                <input type="hidden" name="product_id" id="product_id" value="0">
                                @endif

                                @if(Request::get('fecha_oferta') !== null)
                                <input type="hidden" name="oferta_id" id="oferta_id" value="{{$oferta->id}}">
                                @else
                                <input type="hidden" name="oferta_id" id="oferta_id" value="0">
                                @endif

                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent1">
                                        <div class="tab-pane fade show active" id="precios" role="tabpanel" aria-labelledby="home-tab-basic">
                                            @include('admin.products.form-product-prices')
                                        </div>
                                        <div class="tab-pane fade" id="detalle" role="tabpanel" aria-labelledby="service-tab-basic">
                                            @include('admin.products.form-product-details')
                                        </div>
                                        <div class="tab-pane fade" id="imagenes" role="tabpanel" aria-labelledby="account-tab-basic">
                                            @include('admin.products.form-product-images')
                                        </div>
                                    </div>
                                </div>

                                @if (isset($product))
                                <div class="col-12" style="float: right">
                                    <button type="button" id="btn_product" disabled  class="btn btn-primary" onclick="updateProduct('{{ route('product.update') }}')" style="float: right"><i class="fa fa-save"></i> Guardar</button>
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
        var fecha_actualizacion         = jQuery("#fecha_actualizacion_activa").val();
        var fecha_actualizacion_label   = jQuery("#fecha_actualizacion_label").val();
        var fecha_desde                 = jQuery("#fecha_desde").val();
        var fecha_hasta                 = jQuery("#fecha_hasta").val();
        var fecha                       = jQuery("#fecha_actualizacion").val().split('-');
        var fecha_act                   = (jQuery("#fecha_actualizacion").val() !== '') ? fecha[2] + '/' + fecha[1] + '/' + fecha[0] : '';

        if(fecha_desde !== '' && fecha_hasta !== ''){
            text = 'Modifica los precios de <strong> Oferta </strong> ?';
        }else{
            if((fecha_actualizacion == 0 || fecha_actualizacion == '0') && fecha_act == ''){
                text = 'Modifica los precios <strong> Actuales </strong> ?';
            }else{
                text = 'Modifica la actualización para el <strong>' + fecha_act + '</strong> ?';
            }
        }

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
