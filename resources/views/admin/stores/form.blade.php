@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/api/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid addproduct-main">

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-custom gutter-b bg-white border-0">

                        <div class="card-header align-items-center  border-0">
                            <div class="card-title mb-0">
                                <h4 class="card-label mb-0 font-weight-bold text-body"> </h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">

                                    @if (isset($store))
                                        {!! Form::model($store, ['route' => ['stores.update', $store->id], 'method' => 'POST']) !!}
                                    @else
                                        {!! Form::open(['route' => 'stores.store', 'method' => 'POST']) !!}
                                    @endif

                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h4 class="font-size-h4 font-weight-bold m-0">
                                                {{ $store ? 'Editar' : 'Agregar' }} tienda</h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <label class="text-dark">Nombre Tienda</label>
                                            <input type="text" id="description" name="description"
                                                @if (isset($store)) value="{{ $store->description }}" @else value="" @endif
                                                class="form-control" autofocus required>
                                        </div>

                                        <div class="col-xs-12 col-md-2">
                                            <label class="text-dark">Cod Fenovo</label>
                                            <input type="text" id="cod_fenovo" name="cod_fenovo"
                                                @if (isset($store)) value="{{ $store->cod_fenovo }}" @else value="" @endif
                                                class="form-control" required>
                                        </div>

                                        <div class="col-xs-12 col-md-2">
                                            <label class="text-dark">Pto venta</label>
                                            <input type="text" id="punto_venta" name="punto_venta"
                                                @if (isset($store)) value="{{ $store->punto_venta }}" @else value="" @endif
                                                class="form-control">
                                        </div>

                                        <div class="col-xs-12 col-md-2">
                                            <label class="text-dark">Tipo Store</label>
                                            <fieldset class="form-group border border-dark">
                                                <select class="rounded form-control border-dark" name="store_type"
                                                    id="store_type">
                                                    @foreach ($storeType as $storeT)
                                                        <option value="{{ $storeT['type'] }}"
                                                            @if (isset($store) && $storeT['type'] == $store->store_type) selected @endif>
                                                            {{ $storeT['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>



                                    <div class="row mt-3 mb-3">
                                        <div class="col-2">
                                            <label class="text-dark">Cuit</label>
                                            <input type="text" id="cuit" name="cuit"
                                                @if (isset($store)) value="{{ $store->cuit }}" @else value="" @endif
                                                class="form-control" required>
                                        </div>
                                        <div class="col-4">
                                            <label class="text-dark">Razón social responsable</label>
                                            <input type="text" id="razon_social" name="razon_social"
                                                @if (isset($store)) value="{{ $store->razon_social }}" @else value="" @endif
                                                class="form-control">
                                        </div>
                                        <div class="col-6">
                                            <label class="text-dark">Nombres de contacto</label>
                                            <input type="text" id="responsable" name="responsable"
                                                @if (isset($store)) value="{{ $store->responsable }}" @else value="" @endif
                                                class="form-control">
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-xs-12 col-md-2">
                                            <label class="text-dark">Tipo Iva</label>
                                            <fieldset class="form-group">
                                                <select class="rounded form-control bg-transparent" name="iva_type">
                                                    @forelse ($ivaType as $iva)
                                                        <option value="{{ $iva['type'] }}"
                                                            @if (isset($store) && $iva['type'] == $store->iva_type) selected @endif>
                                                            {{ $iva['type'] }}
                                                        </option>
                                                    @empty
                                                        <option value="">Sin tipo iva</option>
                                                    @endforelse
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-xs-12 col-md-2">
                                            <label class="text-dark">Tipo impresora</label>
                                            <fieldset class="form-group">
                                                <select class="rounded form-control bg-transparent" name="print_type">
                                                    @forelse ($printType as $print)
                                                        <option value="{{ $print['type'] }}"
                                                            @if (isset($store) && $print['type'] == $store->print_type) selected @endif>
                                                            {{ $print['type'] }}
                                                        </option>

                                                    @empty
                                                        <option value="">No hay impresoras</option>
                                                    @endforelse
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-xs-12 col-md-2">
                                            <label class="text-dark">Máx Facturación</label>
                                            <input type="text" id="billing_amount" name="billing_amount"
                                                @if (isset($store)) value="{{ $store->billing_amount }}" @else value="" @endif
                                                class="form-control">
                                        </div>
                                        <div class="col-xs-12 col-md-2">
                                            <label class="text-dark">% Flete</label>
                                            <input type="text" id="delivery_percentage" name="delivery_percentage"
                                                @if (isset($store)) value="{{ $store->delivery_percentage }}" @else value="" @endif
                                                class="form-control">
                                        </div>
                                        <div class="col-xs-12 col-md-2">
                                            <label class="text-dark">Km Flete</label>
                                            <input type="text" id="delivery_km" name="delivery_km"
                                                @if (isset($store)) value="{{ $store->delivery_km }}" @else value="" @endif
                                                class="form-control">
                                        </div>
                                        <div class="col-xs-12 col-md-2">
                                            <label class="text-dark">Capacidad</label>
                                            <input type="text" id="stock_capacity" name="stock_capacity"
                                                @if (isset($store)) value="{{ $store->stock_capacity }}" @else value="" @endif
                                                class="form-control">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <br />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-2">
                                            <label class="text-dark">Telefono</label>
                                            <input type="text" id="telephone" name="telephone"
                                                @if (isset($store)) value="{{ $store->telephone }}" @else value="" @endif
                                                class="form-control">
                                        </div>
                                        <div class="col-4">
                                            <label class="text-dark">Dirección</label>
                                            <input type="text" id="address" name="address"
                                                @if (isset($store)) value="{{ $store->address }}" @else value="" @endif
                                                class="form-control">
                                        </div>
                                        <div class="col-4">
                                            &nbsp;
                                        </div>
                                        <div class="col-2">
                                            <label class="text-dark">Logistica express</label>
                                            <input type="text" id="logistica_express" name="logistica_express"
                                                @if (isset($store)) value="{{ $store->logistica_express }}" @else value="" @endif
                                                class="form-control">
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-4">
                                            <label class="text-dark">Ciudad</label>
                                            <input type="text" id="city" name="city"
                                                @if (isset($store)) value="{{ $store->city }}" @else value="" @endif
                                                class="form-control">
                                        </div>
                                        <div class="col-4">
                                            <label class="text-dark">Provincia</label>
                                            <fieldset class="form-group">
                                                <select class="rounded form-control bg-transparent" name="state">
                                                    @forelse ($states as $state)
                                                        <option value="{{ $state['name'] }}"
                                                            @if (isset($store) && $state['name'] == $store->state) selected @endif>
                                                            {{ $state['name'] }}
                                                        </option>

                                                    @empty
                                                        <option value="">No hay provincia</option>
                                                    @endforelse
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-4">
                                            <label class="text-dark">Región</label>
                                            <fieldset class="form-group">
                                                <select class="rounded form-control bg-transparent" name="region_id">
                                                    @forelse ($regiones as $region)
                                                        <option value="{{ $region->id }}"
                                                            @if (isset($store) && $region->id == $store->region_id) selected @endif>
                                                            {{ $region->name }}
                                                        </option>
                                                    @empty
                                                        <option value="">No hay regiones</option>
                                                    @endforelse
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-12">
                                            <br />
                                        </div>
                                    </div>


                                    <div class="row">

                                        @if (isset($store))
                                            <input type="hidden" name="store_id" value="{{ $store->id }}" />
                                        @endif

                                        <div class="col-3">
                                            <p>Activo :</p>
                                            <div class="custom-control switch custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="active"
                                                    name="active"
                                                    @if (isset($store) && $store->active) checked="" @elseif(isset($store) && !$store->active)) unchecked="" @else checked="" @endif
                                                    value="1">
                                                <label class="custom-control-label mr-1" for="active"></label>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <p>Vta-OnLine:</p>
                                            <div class="custom-control switch custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="online_sale"
                                                    name="online_sale"
                                                    @if (isset($store) && $store->online_sale) checked="" @elseif(isset($store) && !$store->online_sale) unchecked="" @else checked="" @endif
                                                    value="1">
                                                <label class="custom-control-label mr-1" for="online_sale"></label>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <p>Habilitado-Pna:</p>
                                            <div class="custom-control switch custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="habilitado_panama" name="habilitado_panama"
                                                    @if (isset($store) && $store->habilitado_panama) checked="" @elseif(isset($store) && !$store->habilitado_panama) unchecked="" @else checked="" @endif
                                                    value="1">
                                                <label class="custom-control-label mr-1" for="habilitado_panama"></label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                Guardar
                                            </button>
                                        </div>
                                    </div>


                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/api/select2/select2.min.js') }}"></script>

    <script>
        var table = jQuery('.yajra-datatable').DataTable({});
    </script>
@endsection
