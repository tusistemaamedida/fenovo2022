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
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-custom gutter-b bg-white border-0">
                        <div class="card-body">
                            {{ Form::open(['route' => 'ingresos.store']) }}
                            <div class="form-group d-none">
                                <input type="hidden" name="type" id="type" value="COMPRA" />
                                <input type="hidden" name="to" id="to" value="1" />
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="text-body">Proveedor</label>
                                    <fieldset class="form-group mb-3">
                                        {{ Form::select('from', $proveedores, null, ['class' => 'js-example-basic-single form-control bg-transparent proveedor', 'placeholder' => 'seleccione ...', 'required' => 'true']) }}
                                    </fieldset>
                                </div>
                                <div class="col-md-2">
                                    <label class="text-body">Fecha</label>
                                    <input type="date" name="date" value="{{ date('Y-m-d', strtotime(now())) }}"
                                        class="form-control datepicker mb-3">
                                </div>
                                <div class="@if(isset($depositos)) col-md-1 @else col-md-3 @endif">
                                    <label class="text-body">Tipo compra</label>
                                    <select class="form-control bg-transparent" name="subtype" id="subtype">
                                        <option value="FACTURA" selected>F</option>
                                        <option value="CYO">CYO</option>
                                        <option value="REMITO">R</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="text-dark">Comprobante</label>
                                    <input type="text" id="voucher_number" name="voucher_number" value=""
                                        class="form-control text-center" required="true">
                                </div>
                                @if(isset($depositos))
                                    <div class="col-md-2">
                                        <label class="text-body">Depósito final</label>
                                        <select class="form-control bg-transparent" name="deposito" id="deposito">
                                            @foreach ($depositos as $deposito)
                                                <option value="{{$deposito->id}}">{{$deposito->razon_social}} - {{$deposito->description}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-2 text-center">
                                    <label class="text-dark">Guardar</label>
                                    <fieldset class="form-group mb-3">
                                        <button type="submit" class="btn btn-link btn-guardar-ingreso text-primary"><i
                                                class="fa fa-save"></i> </button>
                                    </fieldset>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-custom gutter-b bg-white border-0">
                        <div class="card-body">
                            <div id="data" class="row d-none">
                                <div class="col-12"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @section('js')
        <script>
            jQuery(document).ready(function() {
                jQuery(".proveedor").select2('open')
            });

            jQuery(".proveedor").on('change', function() {
                const id = this.value;
                jQuery.ajax({
                    url: '{{ route('products.getProductByProveedor') }}',
                    type: 'GET',
                    data: {
                        id
                    },
                    success: function(data) {
                        if (data['type'] == 'success') {
                            jQuery("#data").html(data['html']);
                            jQuery("#product_id").select2({});
                        }
                    }
                });
            })
        </script>
    @endsection
