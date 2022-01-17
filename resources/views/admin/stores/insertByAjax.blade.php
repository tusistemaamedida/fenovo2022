<div class="form-group">
    <label class="text-dark">Cod Fenovo</label>
    <input type="text" id="cod_fenovo" name="cod_fenovo" @if (isset($store)) value="{{$store->cod_fenovo}}" @else value="" @endif class="form-control" required autofocus>
</div>

<div class="form-group">
    <label class="text-dark">Nombre </label>
    <input type="text" id="fantasy_name" name="fantasy_name" @if (isset($store)) value="{{$store->fantasy_name}}" @else value="" @endif class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark">Razón social </label>
    <input type="text" id="razon_social" name="razon_social" @if (isset($store)) value="{{$store->razon_social}}" @else value="" @endif class="form-control">
</div>

<div class="form-group">
    <label class="text-dark">Descripción breve (opcional)</label>
    <input type="text" id="description" name="description" @if (isset($store)) value="{{$store->description}}" @else value="" @endif class="form-control">
</div>

<div class="form-group">
    <label class="text-dark">Responsable</label>
    <input type="text" id="responsable" name="responsable" @if (isset($store)) value="{{$store->responsable}}" @else value="" @endif class="form-control">
</div>

<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Tipo Iva</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="iva_type">
                    @forelse ($ivaType as $iva)

                    <option value="{{$iva['type']}}" @if($iva['type']==$store->iva_type ) selected @endif>
                        {{$iva['type'] }}
                    </option>

                    @empty
                    <option value="">Sin tipo iva</option>
                    @endforelse
                </select>
            </fieldset>
        </div>
        <div class="col-6">
            <label class="text-dark">Cuit</label>
            <input type="text" id="cuit" name="cuit" @if (isset($store)) value="{{$store->cuit}}" @else value="" @endif class="form-control">
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Telefono</label>
            <input type="text" id="telephone" name="telephone" @if (isset($store)) value="{{$store->telephone}}" @else value="" @endif class="form-control">
        </div>
        <div class="col-6">
            <label class="text-dark">Tipo impresora</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="print_type">
                    @forelse ($printType as $print)

                    <option value="{{$print['type']}}" @if($print['type']==$store->print_type ) selected @endif>
                        {{$print['type'] }}
                    </option>

                    @empty
                    <option value="">No hay impresoras</option>
                    @endforelse
                </select>
            </fieldset>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Dirección</label>
    <input type="text" id="address" name="address" @if (isset($store)) value="{{$store->address}}" @else value="" @endif class="form-control">
</div>
<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Ciudad</label>
            <input type="text" id="city" name="city" @if (isset($store)) value="{{$store->city}}" @else value="" @endif class="form-control">
        </div>
        <div class="col-6">
            <label class="text-dark">Provincia</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="state">
                    @forelse ($states as $state)

                    <option value="{{$state['name']}}" @if($state['name']==$store->state ) selected @endif>
                        {{$state['name'] }}
                    </option>

                    @empty
                    <option value="">No hay provincia</option>
                    @endforelse
                </select>
            </fieldset>
        </div>
    </div>
</div>
<div class="form-group">

</div>

<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Region</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="region_id">
                    @forelse ($regiones as $region)
                    <option value="{{$region->id}}" @if($region->id == $store->region_id ) selected @endif>
                        {{$region->name}}
                    </option>
                    @empty
                    <option value="">No hay regiones</option>
                    @endforelse
                </select>
            </fieldset>
        </div>
        <div class="col-6">
            <label class="text-dark">Tiendas dependiente</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="storefather_id">
                    @forelse ($stores as $tienda)
                    <option value="{{$tienda->id}}" @if($tienda->id == $store->storefather_id) selected @endif>
                        {{$tienda->fantasy_name}}
                    </option>
                    @empty
                    <option value="">No hay tiendas</option>
                    @endforelse
                </select>
            </fieldset>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Máx Facturación</label>
            <input type="text" id="billing_amount" name="billing_amount" @if (isset($store)) value="{{$store->billing_amount}}" @else value="" @endif class="form-control">
        </div>
        <div class="col-6">
            <label class="text-dark">% Flete</label>
            <input type="text" id="delivery_percentage" name="delivery_percentage" @if (isset($store)) value="{{$store->delivery_percentage}}" @else value="" @endif class="form-control">
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label class="text-dark">Capacidad</label>
            <input type="text" id="stock_capacity" name="stock_capacity" @if (isset($store)) value="{{$store->stock_capacity}}" @else value="" @endif class="form-control">
        </div>
        <div class="col-4">
            <fieldset>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" @if (isset($store) && $store->active) checked="" @endif name="active" id="active" value='1'>
                    <label class="custom-control-label" for="active">Activo</label>
                </div>
            </fieldset>
        </div>
        <div class="col-4">
            <fieldset>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" @if (isset($store) && $store->online_sale) checked="" @endif name="online_sale" id="online_sale" value='1'>
                    <label class="custom-control-label" for="online_sale">Vta OnLine</label>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Latitud</label>
            <input type="text" id="lat" name="lat" @if (isset($store)) value="{{$store->lat}}" @else value="" @endif class="form-control">
        </div>
        <div class="col-6">
            <label class="text-dark">Longitud</label>
            <input type="text" id="lon" name="lon" @if (isset($store)) value="{{$store->lon}}" @else value="" @endif class="form-control">
        </div>
    </div>
</div>


@if (isset($store))
<input type="hidden" name="store_id" value="{{$store->id}}" />
@endif