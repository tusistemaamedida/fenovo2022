<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            {{ ($vehiculo)?'Editar':'Agregar'}} vehiculo
        </h4>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Tipo</label>
    <input type="text" id="tipo" name="tipo" @if (isset($vehiculo)) value="{{$vehiculo->tipo}}" @else value="" @endif class="form-control" required placeholder="CAMION, CAMION C/SEMI, ETC">
</div>

<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Marca</label>
            <input type="text" id="marca" name="marca" @if (isset($vehiculo)) value="{{$vehiculo->marca}}" @else value="" @endif class="form-control" required>
        </div>
        <div class="col-6">
            <label class="text-dark">Patente</label>
            <input type="text" id="patente" name="patente" @if (isset($vehiculo)) value="{{$vehiculo->patente}}" @else value="" @endif class="form-control" required>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Capacidad (Kgrs)</label>
            <input type="text" id="capacidad" name="capacidad" @if (isset($vehiculo)) value="{{$vehiculo->capacidad}}" @else value="" @endif class="form-control" required>
        </div>
        <div class="col-6">
            <label class="text-dark">Nro Senasa</label>
            <input type="text" id="senasa" name="senasa" @if (isset($vehiculo)) value="{{$vehiculo->senasa}}" @else value="" @endif class="form-control" required>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Chofer</label>
    <input type="text" id="chofer" name="chofer" @if (isset($vehiculo)) value="{{$vehiculo->chofer}}" @else value="" @endif class="form-control">
</div>

<div class="form-group">
    <label class="text-dark">Transportista</label>
    <fieldset class="form-group">
        <select class="rounded form-control bg-transparent" name="transportista_id" id="transportista_id">
            <option value="">Seleccione transportista</option>
            @foreach ($transportistas as $transportista)
            <option value="{{$transportista->id}}" @if(isset($vehiculo) && ($transportista->id==$vehiculo->transportista_id)) selected @endif>
                {{$transportista->nombre }}
            </option>
            @endforeach
        </select>
    </fieldset>
</div>

<input type="hidden" name="store_id" id="store_id" value="1" />

@if(isset($vehiculo))
<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" @if (isset($vehiculo) && $vehiculo->active) checked="" @endif name="active" id="active" value='1'>
        <label class="custom-control-label" for="active">Activo</label>
    </div>
</div>

<input type="hidden" name="vehiculo_id" value="{{$vehiculo->id}}" />
@endif