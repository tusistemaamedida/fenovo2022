@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">Ingreso de mercadería</li>
            </ol>
        </nav>
    </div>
</div>
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card gutter-b bg-white border-0">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="movement_id" id="movement_id" value={{ $movement->id }} />
                    <div class="col-md-4">
                        <label class="text-body">Proveedor</label>
                        <fieldset class="form-group mb-3">
                            <input type="text" name="from" value="{{ $proveedor->name }}" class="form-control mb-3" readonly>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <label class="text-body">Fecha</label>
                        <input type="text" name="date" value="{{ date('d-m-Y',strtotime($movement->date)) }}" class="form-control datepicker mb-3" readonly>
                    </div>
                    <div class="col-md-2 text-center">
                        <label class="text-dark">Nro Comprobante</label>
                        <input type="text" id="voucher_number" name="voucher_number" value="{{ $movement->voucher_number }}" class="form-control text-center" readonly>
                    </div>
                    <div class="col-md-1 text-center">
                        <label class="text-dark font-size-bold">Cerrar</label>
                        <fieldset class="form-group">
                            <a href="javascript:void(0)" onclick="close_compra('{{ $movement->id}}', '{{ route('ingresos.close') }}')" class="btn btn-link btn-cerrar-ingreso">
                                <i class="fa fa-lock text-primary"></i>
                            </a>
                        </fieldset>
                    </div>
                    <div class="col-md-1 text-center">
                        <label class="text-dark">Anular</label>
                        <fieldset class="form-group">
                            <a href="javascript:void(0)" onclick="destroy_local('{{ $movement->id}}', '{{ route('ingresos.destroy') }}')" class="btn btn-link">
                                <i class="fa fa-trash"></i>
                            </a>
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="row font-weight-bold">
                            <div class="col-12"> Producto</div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ Form::select('product_id', $productos, null, ['id'=>'product_id', 'class' => 'js-example-basic-single form-control bg-transparent', 'placeholder'=>'Seleccione productos ...']) }}
                            </div>
                        </div>

                    </div>
                    <div class="col-8">
                        <div id="dataTemp">
                            @include('admin.movimientos.ingresos.detalleTemp')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card gutter-b bg-white border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div id="dataConfirm">
                            @include('admin.movimientos.ingresos.detalleConfirm')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.movimientos.ingresos.modal')

@endsection

@section('js')
<script>
    jQuery( document ).ready(function() {
        jQuery("#product_id").select2('open');
        jQuery("#unit_package").select2({
            tags: true
        })
    });

    jQuery("#product_id").on('change', function(){
        const productId = jQuery("#product_id").val();
        jQuery.ajax({
            url: '{{ route('detalle-ingresos.check') }}',
            type: 'POST',
            data: {productId},
            success: function (data) {
                if (data['type'] == 'success') {
                    jQuery("#dataTemp").html(data['html']);
                    jQuery(".calculate").first().select();
                    
                    console.log(jQuery("#unit_weight").val())

                    if(jQuery("#unit_weight").val() == 0){
                        toastr.error('Evite errores, PRODUCTO SIN "PESO UNITARIO"', 'Verifique');
                    }
                }
            },
        });
    })

    const editarProducto = (id) => {
        var elements = document.querySelectorAll('.is-invalid');
        jQuery.ajax({
            url: '{{ route('ingresos.editProduct') }}',
            type: 'GET',
            data: { id },
            success: function (data) {
                if (data['type'] == 'success') {
                    jQuery("#insertByAjax").html(data['html']);
                    jQuery("#unit_package").select2({});
                    jQuery('.editpopup').addClass('offcanvas-on');
                } else {
                    toastr.error(data['html'], 'Verifique');
                }
            }
        });
    }

    const actualizarProducto = () => {
        var form = jQuery('#formData').serialize();
        jQuery.ajax({
            url: '{{ route('ingresos.updateProduct') }}',
            type: 'POST',
            data: form,
            success: function (data) {
                if (data['type'] == 'success') {
                    toastr.info('Actualizado', 'Registro');
                    jQuery('.editpopup').removeClass('offcanvas-on');
                    jQuery("#dataTemp").html('');
                    jQuery("#product_id").val(null).trigger('change').select2('open');
                } else {
                    toastr.error(data['html'], 'Verifique');
                }
            },
        });
    };

    const sumar = () => {
        let total = 0;
        let valido = true; 

        jQuery('.calculate').each(function() {
            if(isNaN(parseFloat(jQuery(this).val()))){
                valido = false;
            }
        });        

        if(valido){
            jQuery('.calculate').each(function() {
                let valor = parseFloat(jQuery(this).val());
                let presentacion = jQuery(this).attr("id");
                total = total + (valor*presentacion);
            });
            if(total > 0){
                jQuery('#btn-guardar-producto').removeClass("d-none");
            }    
            jQuery('.total').val(total)
        }else{
            jQuery('#btn-guardar-producto').addClass("d-none");
            jQuery('.total').val(0)
        }
    }

    const guardarItem = (product_id, peso_unitario) => {

        jQuery('#loader').removeClass('hidden');

        const movement_id = jQuery("#movement_id").val();
        const store_id = 1;
        let arrMovimientos = [];

        jQuery('.calculate').each(function() {
            if(isNaN(parseFloat(jQuery(this).val()))){
                valido = false;
            }else{                       
                let unit_package    = parseFloat(jQuery(this).attr("id"));
                let valor           = parseFloat(jQuery(this).val());
                let presentacion    = parseFloat(jQuery(this).attr("id"));
                let entry           = (valor*presentacion)*peso_unitario;
                let egress          = 0;
                let balance         = 0;
                let entidad_tipo    = 'S';

                if(entry > 0){

                    let Movi = new Object();

                    Movi.movement_id    = movement_id;
                    Movi.entidad_id     = store_id;
                    Movi.entidad_tipo   = entidad_tipo;
                    Movi.product_id     = product_id;
                    Movi.unit_package   = unit_package;
                    Movi.bultos         = valor;
                    Movi.entry          = entry;
                    Movi.balance        = 0;
                    Movi.egress         = 0;

                    arrMovimientos.push(Movi);
                }
            }
        }); 
                
        jQuery.ajax({
            url: '{{ route('detalle-ingresos.store') }}',
            type: 'POST',
            data: {datos: arrMovimientos},
            success: function (data) {
                if (data['type'] == 'success') {
                    actualizarIngreso();
                    jQuery("#dataTemp").html('');
                    jQuery("#product_id").val(null).trigger('change').select2('open');
                }
                if (data['type'] !== 'success') {
                    toastr.error(data['msj'], 'Verifique');
                }
            }
        })

        jQuery('#loader').addClass('hidden');
    }
    
    const actualizarIngreso = ()=>{
        const id = jQuery("#movement_id").val();
        jQuery.ajax({
            url: '{{ route('get.movements.ingreso') }}',
            type: 'GET',
            data: {id},
            success: function (data) {
                if (data['type'] == 'success') {
                    jQuery("#dataConfirm").html(data['html']);
                }
            },
        });
    }

    const borrarDetalle = ( movement_id, product_id ) => {
        const route = '{{ route('detalle-ingresos.destroy') }}';

        ymz.jq_confirm({
            title: 'Atención',
            text: "Ud eliminará el producto y todas sus presentaciones ?",
            no_btn: "Cancelar",
            yes_btn: "Confirma",
            no_fn: function () {
                return false;
            },
            yes_fn: function () {
                jQuery.ajax({
                    url: route,
                    type: 'POST',
                    data: {movement_id, product_id},
                    success: function (data) {
                        if (data['type'] == 'success') {
                            jQuery("#dataConfirm").html(data['html']);
                            toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                            toastr.info("Eliminado ... ");
                        }
                    }
                })
            }
        })
    }

    const destroy_local = (id, route) => {
        ymz.jq_confirm({
            title: 'Eliminar',
            text: "confirma borrar registro ?",
            no_btn: "Cancelar",
            yes_btn: "Confirma",
            no_fn: function () {
                return false;
            },
            yes_fn: function () {
                jQuery.ajax({
                    url: route,
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id },
                    success: function (data) {
                        if (data['type'] == 'success') {                 
                            let ruta = "{{ route('ingresos.index') }}";
                            window.location = ruta;                           
                        }
                    }
                });
            }
        });
    };

    const close_compra = (id, route) => {
        ymz.jq_confirm({
            title: 'Compra ',
            text: "Confirma el cierre de la  compra ?",
            no_btn: "Cancelar",
            yes_btn: "Confirma",
            no_fn: function () {
                return false;
            },
            yes_fn: function () {
                jQuery.ajax({
                    url: route,
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id },
                    success: function (data) {
                        if (data['type'] == 'success') {                    
                            let ruta = "{{ route('ingresos.index') }}";
                            window.location = ruta;
                        }
                    }
                });
            }
        });
    };

</script>
@endsection