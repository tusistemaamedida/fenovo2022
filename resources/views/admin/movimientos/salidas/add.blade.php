@extends('layouts.app')

@section('css')
<style>
    .table tbody tr td {
        color: #1a3353;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Salida de mercadería</li>
            </ol>
        </nav>
    </div>
</div>
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            @include('admin.movimientos.salidas.partials.form-select-cliente')
            <b style="width: 100%" id="session_products_table"></b>
        </div>
    </div>
</div>

@include('admin.movimientos.salidas.partials.modal-product-details')

@include('admin.movimientos.salidas.partials.open-close-salida')

@include('admin.movimientos.salidas.modalMovimiento')

@endsection

@section('js')
<script>
    jQuery(document).ready(function(){
        @if(isset($destino))
            cargarTablaProductos();
        @endif
    });

    const editarMovimiento = (id, quantity, cod_fenovo) => {

        jQuery("#session_product_id").val(id);
        jQuery("#session_product_quantity").val(quantity);
        jQuery("#mov_cod_fenovo").html(cod_fenovo);
        jQuery('.movimientoPopup').addClass('offcanvas-on');
    }

    const actualizarMovimiento = () =>{
        var url ="{{ route('store.session.product.item') }}";
        jQuery.ajax({
            url:url,
            type:'POST',
            data:{
                id: jQuery("#session_product_id").val(),
                quantity: jQuery("#session_product_quantity").val()
            },
            beforeSend: function() {
                jQuery('#loader').removeClass('hidden');
            },
            success:function(data){
                jQuery('.movimientoPopup').removeClass('offcanvas-on');
                jQuery('#to').val(jQuery('#to').val()).trigger('change');
            },
            error: function (data) {
            },
            complete: function () {
                jQuery('#loader').addClass('hidden');
            }
        });
    }

    const cerrarModal = () =>{
        jQuery('.movimientoPopup').removeClass('offcanvas-on');
    }

    jQuery("#to_type").change(function(){
        jQuery('#to').val(null).trigger('change');
    })

    jQuery('#to').select2({
        placeholder: 'Seleccione el cliente...',
        minimumInputLength: 2,
        tags: false,
        ajax: {
            dataType: 'json',
            url: '{{ route('get.cliente.salida') }}',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term,
                    to_type: jQuery("#to_type").val()
                }
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
        }
    });

    jQuery('#product_search').select2({
        placeholder: 'Seleccione por nombre, código fenovo, código de barras...',
        minimumInputLength: 2,
        tags: false,
        ajax: {
            dataType: 'json',
            url: '{{ route('search.products') }}',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
        }
    });

    jQuery('#product_search').change(function(){

        var elements = document.querySelectorAll('.is-invalid');
        var id = jQuery("#product_search").val();

        var to_type = jQuery("#to_type").val();
        var to = jQuery("#to").val();
        var list_id = to_type+'_'+to;

        if(id != ''){
            jQuery.ajax({
                url: "{{route('get.presentaciones')}}",
                type: 'GET',
                data: { id, list_id },
                beforeSend: function () {
                    jQuery('#loader').removeClass('hidden');
                },
                success: function (data) {
                    if (data['type'] == 'success') {
                        
                        jQuery("#insertByAjax").html(data['html']);
                        jQuery('.editpopup').addClass('offcanvas-on');
                    } else if(data['type'] != 'clear') {
                        toastr.error(data['msj'], 'Verifique');
                    }

                    jQuery('#loader').addClass('hidden');
                },
                complete: function () {
                    jQuery('#loader').addClass('hidden');
                }
            });
        }
    });

    jQuery('#product_search').on('select2:open', function () {
        jQuery('.editpopup').removeClass('offcanvas-on');
    });

    jQuery('#to').change(function(){
        cargarTablaProductos();
    });

    function deleteItemSession(id,route){
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
                        toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                        toastr.info("Eliminado ... ");
                        cargarTablaProductos();
                    }                    
                }
            });
        }
    });
    }

    function cargarTablaProductos(){
        var to_type = jQuery("#to_type").val();
        var to = jQuery("#to").val();
        var list_id = to_type+'_'+to;
        var formData =  {list_id};
        var url ="{{ route('get.session.products') }}";
        jQuery.ajax({
            url:url,
            type:'GET',
            data:formData,
            beforeSend: function() {
                jQuery('#loader').removeClass('hidden');
                jQuery("#session_products_table").html('')
            },
            success:function(data){
                jQuery("#session_products_table").html(data['html']);
                jQuery("#btnOpenCerrarSalida").attr('disabled',false);
                jQuery("#session_list_id").val(list_id);
            },
            error: function (data) {
            },
            complete: function () {
                jQuery('#loader').addClass('hidden');
            }
        });
    }

    function cargarFlete(){
        var to_type = jQuery("#to_type").val();
        var to = jQuery("#to").val();
        var list_id = to_type+'_'+to;
        var formData =  {list_id};
        var url ="{{ route('get.flete.session.products') }}";
        jQuery.ajax({
            url:url,
            type:'GET',
            data:formData,
            success:function(data){
                jQuery("#montoFlete").html(data['flete']);
                let flete = parseFloat(data['flete']/100);          
                jQuery("#flete").val(parseFloat(jQuery("#subTotal").val()*flete).toFixed(2));
            },
            error: function (data) {
            },
        });
    }

    function verif(pres){
        
        const max = parseFloat(document.getElementById("unidades_"+pres).max);
        const value = parseFloat(document.getElementById("unidades_"+pres).value);
        if(value > max){
            toastr.error('Supero la cantidad de bultos que puede enviar!', 'Verifique');
            jQuery("#unidades_"+pres).val(max);
            jQuery("#unidades_"+pres).focus();
        };
    }

    jQuery("#sessionProductstore").click(function(e){
        e.preventDefault();
        guardarProductoEnSession()
    })

    function guardarProductoEnSession(){
        var to_type = jQuery("#to_type").val();
        var product_id = jQuery("#product_search").val();
        var to = jQuery("#to").val();
        var list_id = to_type+'_'+to;
        var unidades = jQuery("#unidades_a_enviar").serializeArray();
        var formData =  {list_id, product_id, unidades, to,to_type};
        var url ="{{ route('store.session.product') }}";
        var elements = document.querySelectorAll('.is-invalid');
        jQuery.ajax({
            url:url,
            type:'POST',
            data:formData,
            beforeSend: function() {
                for (var i = 0; i < elements.length; i++) {
                    elements[i].classList.remove('is-invalid');
                }
                jQuery('#loader').removeClass('hidden');
            },
            success:function(data){
                if (data['type'] == 'success') {
                    document.getElementById("unidades_a_enviar").reset();
                    jQuery('.editpopup').removeClass('offcanvas-on');
                    cargarTablaProductos()
                } else{
                    jQuery('#' + data['index']).addClass('is-invalid');
                    jQuery('#'+  data['index']).next().find('.select2-selection').addClass('is-invalid');
                    toastr.error(data['msj'], 'Verifique');
                }
                jQuery('#product_search').val(null).trigger('change')
                jQuery('#loader').addClass('hidden');
            },
            error: function (data) {
            },
            complete: function () {
                jQuery('#loader').addClass('hidden');
            }
        });
    }

    jQuery('#close_modal_presentaciones').on('click', function () {
        document.getElementById("unidades_a_enviar").reset();
        jQuery('.editpopup').removeClass('offcanvas-on');
        jQuery('#product_search').val(null).trigger('change');
    });

    jQuery("#btnOpenCerrarSalida").click(function(e){
        e.preventDefault();
        cargarFlete()
        jQuery('#closeSalida').addClass('offcanvas-on');
    })
    jQuery('#close_modal_salida').on('click', function () {
        jQuery('#closeSalida').removeClass('offcanvas-on');
    });

    jQuery("#btnCloseSalida").click(function(){
        jQuery('#loader').removeClass('hidden');
    })

    function changeInvoice(list_id,product_id){
        jQuery.ajax({
            url:"{{route('change.invoice.product')}}",
            type:'POST',
            data:{list_id,product_id},
            beforeSend: function() {
                jQuery('#loader').removeClass('hidden');
            },
            success:function(data){
                if (data['type'] != 'success') {
                    toastr.error(data['msj'], 'Verifique');
                }
                jQuery('#loader').addClass('hidden');
            },
            error: function (data) {
            },
            complete: function () {
                jQuery('#loader').addClass('hidden');
            }
        });
    }
</script>
@endsection