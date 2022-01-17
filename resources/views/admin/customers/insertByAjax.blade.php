<div class="form-group">
    <label class="text-dark">Razon social</label>
    <input type="text" id="razon_social" name="razon_social" @if (isset($customer)) value="{{$customer->razon_social}}" @else value="" @endif class="form-control" required autofocus>
</div>

<div class="form-group">
    <label class="text-dark">Nombre fantasia local </label>
    <input type="text" id="bussiness_name" name="bussiness_name" @if (isset($customer)) value="{{$customer->bussiness_name}}" @else value="" @endif class="form-control">
</div>

<div class="form-group">
    <label class="text-dark">Contacto responsable</label>
    <input type="text" id="responsable" name="responsable" @if (isset($customer)) value="{{$customer->responsable}}" @else value="" @endif class="form-control">
</div>

<div class="form-group">
    <label class="text-dark">Email</label>
    <input type="text" id="email" name="email" @if (isset($customer)) value="{{$customer->email}}" @else value="" @endif class="form-control">
</div>

<div class="form-group">
    <label class="text-dark">Teléf</label>
    <input type="text" id="telephone" name="telephone" @if (isset($customer)) value="{{$customer->telephone}}" @else value="" @endif class="form-control">
</div>


<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Tipo Iva</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="iva_type">
                    @forelse ($ivaType as $iva)
                    <option value="{{$iva['type']}}" @if($iva['type']==$customer->iva_type ) selected @endif>
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
            <input type="text" id="cuit" name="cuit" @if (isset($customer)) value="{{$customer->cuit}}" @else value="" @endif class="form-control">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Tiendas asociada</label>
    <fieldset class="form-group">
        <select class="rounded form-control bg-transparent" name="store_id">
            @forelse ($stores as $store)
            <option value="{{$store->id}}" @if($store->id == $customer->store_id) selected @endif>
                {{$store->fantasy_name}}
            </option>
            @empty
            <option value="">No hay tiendas</option>
            @endforelse
        </select>
    </fieldset>
</div>

<div class="form-group">
    <label class="text-dark">Dirección</label>
    <input type="text" id="address" name="address" @if (isset($customer)) value="{{$customer->address}}" @else value="" @endif class="form-control">
</div>

<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Ciudad</label>
            <input type="text" id="city" name="city" @if (isset($customer)) value="{{$customer->city}}" @else value="" @endif class="form-control">
        </div>
        <div class="col-6">
            <label class="text-dark">Provincia</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="state">
                    @forelse ($states as $state)

                    <option value="{{$state['name']}}" @if($state['name']==$customer->state ) selected @endif>
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

    <label class="text-dark">Lista precio asociada</label>
    <fieldset class="form-group">
        <select class="rounded form-control bg-transparent" name="listprice_associate">
            @forelse ($listPrices as $listPrice)
            <option value="{{$listPrice['type']}}" @if($listPrice['type']==$customer->listprice_associate ) selected @endif>
                {{$listPrice['type'] }}
            </option>
            @empty
            <option value="">No hay precios</option>
            @endforelse
        </select>
    </fieldset>
</div>

<div class="row" style="margin-bottom: 25px">
    <div class="col-4">
        <fieldset>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" @if (isset($customer) && $customer->active) checked="" @endif name="active" id="active" value='1'>
                <label class="custom-control-label" for="active">Activo</label>
            </div>
        </fieldset>
    </div>
</div>



@if (isset($customer))
<input type="hidden" name="customer_id" value="{{$customer->id}}" />
@endif