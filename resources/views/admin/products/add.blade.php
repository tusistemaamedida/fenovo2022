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
                                    <a class="nav-link btn-light active shadow-none" id="detalle-tab-basic" data-toggle="pill" href="#detalle" role="tab" aria-controls="detalle" aria-selected="true">
                                      Detalles
                                    </a>
                                </li>
                                <li class="nav-item mr-2">
                                    <a class="nav-link btn-light shadow-none" id="precios-tab-basic" data-toggle="pill" href="#precios" role="tab" aria-controls="precios" aria-selected="false">
                                        Precios
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn-light shadow-none" id="imagenes-tab-basic" data-toggle="pill" href="#imagenes" role="tab" aria-controls="imagenes" aria-selected="false">
                                      Imágenes
                                    </a>
                                </li>
                            </ul>
                            <div class="row">
                                <form>
                                    <div class="col-12">
                                        <div class="tab-content" id="v-pills-tabContent1">
                                            <div class="tab-pane fade show active" id="detalle" role="tabpanel" aria-labelledby="home-tab-basic">
                                                @include('admin.products.form-product-details')
                                            </div>
                                            <div class="tab-pane fade " id="precios" role="tabpanel" aria-labelledby="service-tab-basic">
                                                @include('admin.products.form-product-prices')
                                            </div>
                                            <div class="tab-pane fade " id="imagenes" role="tabpanel" aria-labelledby="account-tab-basic">
                                                <p class="text-dark">
                                                    .Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque lorem est, vestibulum eu ex ac, mattis aliquam turpis. Vivamus sed orci nibh. Donec scelerisque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque lorem est, vestibulum
                                                    eu ex ac, mattis aliquam turpis. Vivamus sed orci nibh. Donec scelerisque
                                                </p>
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
    <script src="{{asset('assets/api/select2/select2.min.js')}}"></script>
    <script>
        jQuery(document).ready(function() {
			  jQuery('.js-example-basic-single').select2();
		  });

          function expandTextarea(id) {
			document.getElementById(id).addEventListener('keyup', function() {
				this.style.overflow = 'hidden';
				this.style.height = 0;
				this.style.height = this.scrollHeight + 'px';
			}, false);
		}

		expandTextarea('txtarea');

        jQuery("#plistproveedor").keyup(function(){
            calculatePrices('#span-plistproveedor','Calculando costo fenovo...')
        });

        jQuery("#descproveedor").keyup(function(){
            calculatePrices('#span-plistproveedor','Calculando costo fenovo...')
        });

        function calculatePrices(spanId,text){
            var elements = document.querySelectorAll('.is-invalid');
            var plistproveedor = jQuery("#plistproveedor").val();
            var descproveedor = jQuery("#descproveedor").val();
            var contribution_fund = jQuery("#contribution_fund").val();
            var mupfenovo = jQuery("#mupfenovo").val();

            jQuery.ajax({
                url:"{{ route('calculate.product.prices') }}",
                type:'GET',
                data:{
                    plistproveedor,
                    descproveedor,
                    mupfenovo,
                    contribution_fund
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
@endsection
