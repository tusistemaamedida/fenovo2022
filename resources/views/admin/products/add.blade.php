@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/cropper.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/fileicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/filepicker.css')}}">
    <style>
        input[type="file"] { display: block; }
    </style>
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
                                <form style="width: 100%;margin-top: 15px;">
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

    <script src="{{asset('assets/js/filepicker.js')}}"></script>
    <script src="{{asset('assets/js//cropper.min.js')}}"></script>
    <script src="{{asset('assets/js/filepicker-ui.js')}}"></script>
    <script src="{{asset('assets/js/filepicker-crop.js')}}"></script>
    <script>

        function expandTextarea(id) {
			document.getElementById(id).addEventListener('keyup', function() {
				this.style.overflow = 'hidden';
				this.style.height = 0;
				this.style.height = this.scrollHeight + 'px';
			}, false);
		}

		expandTextarea('txtarea');

        jQuery("#plistproveedor").keyup(function(){
            calculatePrices()
        });

        jQuery("#descproveedor").keyup(function(){
            calculatePrices()
        });

        jQuery("#mupfenovo").keyup(function(){
            calculatePrices()
        });

        jQuery("#contribution_fund").keyup(function(){
            calculatePrices()
        });

        jQuery("#descproveedor").change(function(){
            calculatePrices()
        });

        jQuery("#mupfenovo").change(function(){
            calculatePrices()
        });

        jQuery("#contribution_fund").change(function(){
            calculatePrices()
        });

        jQuery("#tasiva").change(function(){
            calculatePrices()
        });

        jQuery("#muplist1").keyup(function(){
            calculatePrices()
        });

        jQuery("#muplist1").change(function(){
            calculatePrices()
        });

        jQuery("#muplist2").keyup(function(){
            calculatePrices()
        });

        jQuery("#muplist2").change(function(){
            calculatePrices()
        });

        jQuery("#p1tienda").keyup(function(){
            calculatePrices()
        });

        jQuery("#p1tienda").change(function(){
            calculatePrices()
        });

        jQuery("#descp1").keyup(function(){
            calculatePrices()
        });

        jQuery("#descp1").change(function(){
            calculatePrices()
        });

        jQuery("#p2tienda").keyup(function(){
            calculatePrices()
        });

        jQuery("#p2tienda").change(function(){
            calculatePrices()
        });

        jQuery("#descp2").keyup(function(){
            calculatePrices()
        });

        jQuery("#descp2").change(function(){
            calculatePrices()
        });

        function calculatePrices(){
            var text = "Aguarde por favor, se están claculando los precios..."
            var spanId = "#info-calculate";
            var elements = document.querySelectorAll('.is-invalid');
            var plistproveedor = jQuery("#plistproveedor").val();
            var descproveedor = jQuery("#descproveedor").val();
            var contribution_fund = jQuery("#contribution_fund").val();
            var mupfenovo = jQuery("#mupfenovo").val();
            var tasiva = jQuery("#tasiva").val();
            var muplist1 = jQuery("#muplist1").val();
            var muplist2 = jQuery("#muplist2").val();
            var p1tienda = jQuery("#p1tienda").val();
            var descp1 = jQuery("#descp1").val();

            var p2tienda = jQuery("#p2tienda").val();
            var descp2 = jQuery("#descp2").val();

            jQuery.ajax({
                url:"{{ route('calculate.product.prices') }}",
                type:'GET',
                data:{
                    plistproveedor,
                    descproveedor,
                    mupfenovo,
                    contribution_fund,
                    tasiva,
                    muplist1,
                    muplist2,
                    p1tienda,
                    descp1,
                    descp2,
                    p2tienda
                },
                beforeSend: function() {
                    jQuery(spanId).html(text)
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].classList.remove('is-invalid');
                    }
                },
                success:function(data){
                    if(data['type'] == 'success'){
                        jQuery("#costfenovo").val(data['costFenovo']);
                        jQuery("#plist0neto").val(data['plist0Neto']);
                        jQuery("#plist0iva").val(data['plist0Iva']);
                        jQuery("#plist1").val(data['plist1']);
                        jQuery("#comlista1").val(data['comlista1']);
                        jQuery("#plist2").val(data['plist2']);
                        jQuery("#comlista2").val(data['comlista2']);
                        jQuery("#mup1").val(data['mup1']);
                        jQuery("#p1may").val(data['p1may']);
                        jQuery("#mupp1may").val(data['mupp1may']);
                        jQuery("#mup2").val(data['mup2']);
                        jQuery("#p2may").val(data['p2may']);
                        jQuery("#mupp2may").val(data['mupp2may']);
                    }
                    jQuery(spanId).html('')
                },
                error: function (data) {
                    var lista_errores="";
                    var data = data.responseJSON;
                    jQuery.each(data.errors,function(index, value) {
                        lista_errores+=value+'<br />';
                        jQuery('#'+index).addClass('is-invalid');
                    });
                    Swal.fire({
                        title: "Error!",
                        html: lista_errores,
                        type: "error",
                        confirmButtonClass: "btn btn-primary",
                        buttonsStyling: !1
                    }) ;
                },
                complete: function () {
                    jQuery(spanId).html('')
                }
            });
        }
    </script>

    <script>
        jQuery("#btn-file").click(function(e){
            var cod_fenovo = jQuery("#cod_fenovo").val();
            if(cod_fenovo == ''){
                toastr.error('Ingrese un Código Fenovo','ERROR!');
                jQuery('#cod_fenovo').addClass('is-invalid');
                e.preventDefault()
            }else{
                imagenes();
            }
        });

        function imagenes(){
            jQuery('#filepicker').filePicker({
                url: "{{url('filepicker')}}",
                plugins: ['ui', 'drop','crop'],
                data: {
                    _token: "{{ csrf_token() }}",
                    cod_fenovo: jQuery("#cod_fenovo").val()
                }
            })
            .on('add.filepicker', function (e, data) {
                var cod_fenovo = jQuery("#cod_fenovo").val();
                if(cod_fenovo == ''){
                    Swal.fire({
                        title: "Error!",
                        html: 'Ingrese un código fenovo en el detalle del producto!',
                        type: "error",
                        confirmButtonClass: "btn btn-primary",
                        buttonsStyling: !1
                    }) ;
                    data.abort()
                }
            })
            .on('progress.filepicker', function (e, data) {
                jQuery('#loader').removeClass('hidden');
                setTimeout(() => {

                }, 150000);
            })
            .on('fail.filepicker', function (e, data) {
                console.log(data);
                alert('Oops! Something went wrong.');
            }).on('always.filepicker', function (e, data) {
                jQuery('#loader').addClass('hidden');
            });
        }

        function validateCode(){
            jQuery.ajax({
                url:"{{ route('product.validate.code') }}",
                type:'GET',
                data:{
                    category:jQuery("#type_id").val(),
                    cod_fenovo:jQuery("#cod_fenovo").val(),
                },
                beforeSend: function() {
                    jQuery("#cod_fenovo").remove('is-invalid');
                },
                success:function(data){
                    if(data['type'] != 'success'){
                        jQuery("#cod_fenovo").addClass('is-invalid');
                        jQuery("#cod_fenovo").focus();
                        toast('ERROR!',data['msj'],'top-right','error',3500);
                    }
                },
                error: function (data) {
                    toast('ERROR!',JSON.stringify(data),'top-right','error',3500);
                }
            });
        }

        if (jQuery.fn.timeago) {
            jQuery.timeago.settings.strings = jQuery.extend({}, jQuery.timeago.settings.strings , {
                seconds: 'few seconds', minute: 'a minute',
                hour: 'an hour', hours: '%d hours', day: 'a day',
                days: '%d days', month: 'a month', year: 'a year'
            });
        }
    </script>

    <!-- Upload Template -->
    <script type="text/x-tmpl" id="uploadTemplate">
        <tr class="upload-template">
            <td class="column-preview">
                <div class="preview">
                    <span class="fa file-icon-{%= o.file.extension %}"></span>
                </div>
            </td>
            <td class="column-name">
                <p class="name">{%= o.file.name %}</p>
                <span class="text-danger error">{%= o.file.error || '' %}</span>
            </td>
            <td colspan="2">
                <p>{%= o.file.sizeFormatted || '' %}</p>
            </td>
            <td>
                {% if (!o.file.autoUpload && !o.file.error) { %}
                    <a href="#" class="action action-primary start" title="Upload">
                        <i class="fa fa-arrow-circle-o-up"></i>
                    </a>
                {% } %}
                <a href="#" class="action action-warning cancel" title="Cancel">
                    <i class="fa fa-ban"></i>
                </a>
            </td>
        </tr>
    </script><!-- end of #uploadTemplate -->

    <!-- Download Template -->
    <script type="text/x-tmpl" id="downloadTemplate">
        {% o.timestamp = function (src) {
            return (src += (src.indexOf('?') > -1 ? '&' : '?') + new Date().getTime());
        }; %}
        <tr class="download-template">
            <td class="column-preview">
                <div class="preview">
                    {% if (o.file.versions && o.file.versions.thumb) { %}
                        <a href="{%= o.file.url %}" target="_blank">
                            <img src="{%= o.timestamp(o.file.versions.thumb.url) %}" width="64" height="64"></a>
                        </a>
                    {% } else { %}
                        <span class="fa file-icon-{%= o.file.extension %}"></span>
                    {% } %}
                </div>
            </td>
            <td class="column-name">
                <p class="name">
                    {% if (o.file.url) { %}
                        <a href="{%= o.file.url %}" target="_blank">{%= o.file.name %}</a>
                    {% } else { %}
                        {%= o.file.name %}
                    {% } %}
                </p>
                {% if (o.file.error) { %}
                    <span class="text-danger">{%= o.file.error %}</span>
                {% } %}
            </td>
            <td class="column-size"><p>{%= o.file.sizeFormatted %}</p></td>
            <td class="column-date">
                {% if (o.file.time) { %}
                    <time datetime="{%= o.file.timeISOString() %}">
                        {%= o.file.timeFormatted %}
                    </time>
                {% } %}
            </td>
            <td>
                {% if (o.file.imageFile && !o.file.error) { %}
                    <a href="#" class="action action-primary crop" title="Cortar">
                        <i class="fa fa-crop"></i>
                    </a>
                {% } %}
                {% if (o.file.error) { %}
                    <a href="#" class="action action-warning cancel" title="Cancelar">
                        <i class="fa fa-ban"></i>
                    </a>
                {% } else { %}
                    <a href="#" class="action action-danger delete" title="Eliminar">
                        <i class="fa fa-trash"></i>
                    </a>
                {% } %}
            </td>
        </tr>
    </script><!-- end of #downloadTemplate -->

    <!-- Pagination Template -->
    <script type="text/x-tmpl" id="paginationTemplate">
        {% if (o.lastPage > 1) { %}
            <ul class="pagination pagination-sm">
                <li {% if (o.currentPage === 1) { %} class="disabled" {% } %}>
                    <a href="#!page={%= o.prevPage %}" data-page="{%= o.prevPage %}" title="Previous">&laquo;</a>
                </li>

                {% if (o.firstAdjacentPage > 1) { %}
                    <li><a href="#!page=1" data-page="1">1</a></li>
                    {% if (o.firstAdjacentPage > 2) { %}
                    <li class="disabled"><a>...</a></li>
                    {% } %}
                {% } %}

                {% for (var i = o.firstAdjacentPage; i <= o.lastAdjacentPage; i++) { %}
                    <li {% if (o.currentPage === i) { %} class="active" {% } %}>
                        <a href="#!page={%= i %}" data-page="{%= i %}">{%= i %}</a>
                    </li>
                {% } %}

                {% if (o.lastAdjacentPage < o.lastPage) { %}
                    {% if (o.lastAdjacentPage < o.lastPage - 1) { %}
                        <li class="disabled"><a>...</a></li>
                    {% } %}
                    <li><a href="#!page={%= o.lastPage %}" data-page="{%= o.lastPage %}">{%= o.lastPage %}</a></li>
                {% } %}

                <li {% if (o.currentPage === o.lastPage) { %} class="disabled" {% } %}>
                    <a href="#!page={%= o.nextPage %}" data-page="{%= o.nextPage %}" title="Next">&raquo</a>
                </li>
            </ul>
        {% } %}
    </script><!-- end of #paginationTemplate -->
@endsection
