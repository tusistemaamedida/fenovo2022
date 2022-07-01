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
                        <div class="col-md-2">
                            <label>Fecha</label>
                        </div>
                        <div class="col-md-3 text-center">
                            <label>Operación</label>
                        </div>
                        <div class="col-md-2 text-center">
                            <label>Tipo</label>
                        </div>
                        <div class="col-md-3 text-center">
                            <label>Origen</label>
                        </div>
                        <div class="col-md-2 text-center">
                            <label>Comprobante</label>
                        </div>
                    </div>
                    <div class="row font-weight-bolder">
                        <div class="col-md-2">
                            {{ date('d-m-Y', strtotime($movement->date)) }}
                        </div>
                        <div class="col-md-3 text-center">
                            {{ $movement->type }}
                        </div>
                        <div class="col-md-2 text-center">
                            {{ $movement->subtype }}
                        </div>
                        <div class="col-md-3 text-center">
                            {{ $movement->origenData($movement->type) }}
                        </div>
                        <div class="col-md-2 text-center">
                            {{ $movement->voucher_number }}
                        </div>
                    </div>

                </div>

                <div class="card gutter-b bg-white border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                @isset($movimientos)
                                    <div class="table-datapos">
                                        <div class="table-responsive">
                                            <table class=" table table-hover table-sm text-center">
                                                <tr class=" bg-dark text-white">
                                                    <th>Codigo</th>
                                                    <th>Producto</th>
                                                    <th>Medida</th>
                                                    <th>Kgrs</th>
                                                    <th>Presentación</th>
                                                    <th>$_Costo </th>
                                                    <th>Bultos</th>
                                                    <th>$_Total</th>
                                                    <th>Unidades</th>
                                                    <th>#</th>
                                                    <th>Historial</th>
                                                </tr>

                                                @php
                                                    $total = 0;
                                                @endphp

                                                @foreach ($movimientos as $movimiento)
                                                    @php
                                                        $total += $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                                                    @endphp
                                                    <tr>
                                                        <td> {{ $movimiento->product->cod_fenovo }} </td>
                                                        <td class=" text-left"> {{ $movimiento->product->name }}</td>
                                                        <td> {{ $movimiento->unit_type }} </td>
                                                        <td> {{ number_format($movimiento->product->unit_weight * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
                                                        </td>
                                                        <td> {{ $movimiento->unit_package }} </td>
                                                        <td> {{ $movimiento->cost_fenovo }}</td>
                                                        <td> {{ $movimiento->bultos }}</td>
                                                        <td> {{ number_format($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
                                                        </td>
                                                        <td> {{ number_format($movimiento->unit_package * $movimiento->bultos, 0, '', '') }}
                                                        </td>
                                                        <td>
                                                            @if ($movement->status == 'FINISHED')
                                                                <a href="javascript:void(0)"
                                                                    onclick="editarMovimiento(
                                                                            '{{ $movimiento->id }}', 
                                                                            '{{ $movimiento->bultos }}', 
                                                                            '{{ $movimiento->product->id }}',
                                                                            '{{ $movimiento->product->cod_fenovo }}',
                                                                            '{{ $movimiento->product->name }}',
                                                                            '{{ $movimiento->unit_package }}'
                                                                        )">
                                                                    <i class=" fa fa-pencil-alt"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="{{ route('product.historial', ['id' => $movimiento->product_id]) }}">
                                                                <i class="fa fa-list" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
  
                                                <tr class=" bg-dark text-black-50">
                                                    <th>Totales</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>{{ number_format($movement->totalKgrs(), 2, ',', '.') }}</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th> {{ $movimientos->sum('bultos') }} </th>
                                                    <th> {{ number_format($total, 2, ',', '.') }} </th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @endisset
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-10">

                            </div>
                            <div class="col-2 text-center">

                                @if ($movement->status == 'FINISHED')
                                    <button onclick="check_compra('{{ $movement->id }}')" class="btn btn btn-primary">
                                        <i class="f "></i> Chequeada
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        @include('admin.movimientos.ingresos.modalMovimiento')
    @endsection

    @section('js')
        <script>
            const editarMovimiento = (detalleId, bultos, producto_id, cod_fenovo, nombre, unit_package) => {
                jQuery("#detalle_id").val(detalleId);
                jQuery("#bultos_anterior").val(bultos);
                jQuery("#bultos_actual").val(bultos);
                jQuery("#producto_id").val(producto_id);
                jQuery("#unit_package").val(unit_package);
                jQuery("#cod_fenovo").html(cod_fenovo);
                jQuery("#nombre").html(nombre);
                jQuery('.movimientoPopup').addClass('offcanvas-on');
            }

            const actualizarMovimiento = () => {

                if (jQuery('#bultos_actual').val() == 0) {
                    toastr.error('La cantidad <strong>no puede ser 0 </strong>', "Cantidad");
                    jQuery('#bultos_actual').select()
                    return
                }
                if (jQuery('#bultos_anterior').val() == jQuery('#bultos_actual').val()) {
                    toastr.error('Ingrese una cantidad <strong>diferente al anteriormente registrada </strong>',
                        "Cantidad");
                    jQuery('#bultos_actual').select()
                    return
                }

                let data = jQuery("#formDataCompra").serialize();

                var url = "{{ route('ajustar.ingreso.item') }}";
                jQuery.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    beforeSend: function() {
                        jQuery('#loader').removeClass('hidden');
                    },
                    success: function(data) {
                        jQuery('.movimientoPopup').removeClass('offcanvas-on');
                        jQuery('#to').val(jQuery('#to').val()).trigger('change');
                    },
                    error: function(data) {},
                    complete: function() {
                        jQuery('#loader').addClass('hidden');
                    }
                });
            }

            const cerrarModal = () => {
                jQuery('.movimientoPopup').removeClass('offcanvas-on');
            }

            const check_compra = (id) => {

                ymz.jq_confirm({
                    title: 'Compra ',
                    text: "Confirma que chequeó la  compra ?",
                    no_btn: "Cancelar",
                    yes_btn: "Confirma",
                    no_fn: function() {
                        return false;
                    },
                    yes_fn: function() {
                        let ruta = '{{ route('ingresos.checkedCerrada', ['id' => $movement->id]) }}';
                        window.location = ruta;
                    }
                });
            };
        </script>
    @endsection
