@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
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
                        <label class="text-body">Fecha</label>
                        <input type="text" name="date" value="{{ date('d-m-Y',strtotime($movement->date)) }}" class="form-control datepicker mb-3" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="text-body">Proveedor</label>
                        <fieldset class="form-group mb-3">
                            <input type="text" name="from" value="{{ $proveedor->name }}" class="form-control mb-3" readonly>
                        </fieldset>
                    </div>
                    <div class="col-md-2">
                        <label class="text-dark">Nro Comprobante</label>
                        <input type="text" id="voucher_number" name="voucher_number" value="{{ $movement->voucher_number }}" class="form-control" required="true">
                    </div>
                    <div class="col-md-1 text-center">
                        <label class="text-dark">&nbsp;</label>
                        <fieldset class="form-group mb-3">
                            <form id="formData" action="{{ route('ingresos.destroy', ['id' => $movement->id])}}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="submit" title="Anular ingreso" class="btn btn-outline-danger btn-anular-ingreso"><i class="fa fa-trash"></i> </button>
                            </form>
                        </fieldset>
                    </div>
                    <div class="col-md-1 text-center">
                        <label class="text-dark">&nbsp;</label>
                        <fieldset class="form-group mb-3">
                            <button type="button" class="btn btn-primary btn-cerrar-ingreso"><i class="fa fa-lock"></i></button>
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <form id="formProduct">
                            <fieldset class="form-group mb-3">
                                {{ Form::select('product_id', $productos, null, ['id'=>'product_id', 'class' => 'js-example-basic-single form-control bg-transparent', 'placeholder'=>'Seleccione productos ...']) }}
                            </fieldset>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-xl-12">
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
@endsection

@section('js')
<script>
    jQuery("#product_id").on('change', function(){
        const productId = jQuery("#product_id").val();
        jQuery.ajax({
            url: '{{ route('detalle-ingresos.check') }}',
            type: 'POST',
            data: {productId},
            success: function (data) {
                if (data['type'] == 'success') {
                    jQuery("#dataTemp").html(data['html']);
                }
            },
        });
    })

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

    const guardarItem = (product_id) => {
        const movement_id = jQuery("#movement_id").val();
        const store_id = 1;
        let arrMovimientos = [];

        jQuery('.calculate').each(function() {
            if(isNaN(parseFloat(jQuery(this).val()))){
                valido = false;
            }else{                       
                let unit_package = jQuery(this).attr("id");
                let valor = parseFloat(jQuery(this).val());
                let presentacion = parseFloat(jQuery(this).attr("id"));
                let entry = valor*presentacion;
                let egress= 0;
                let balance=0;
                if(entry > 0){
                    let Movi = new Object();
                    Movi.movement_id= movement_id;
                    Movi.store_id= store_id;
                    Movi.product_id= product_id;
                    Movi.unit_package = unit_package;
                    Movi.entry = entry;
                    Movi.balance = 0;
                    Movi.egress  = 0;
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
                }
                if (data['type'] !== 'success') {
                    toastr.error(data['msj'], 'Verifique');
                }
            }
        })
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

</script>
@endsection