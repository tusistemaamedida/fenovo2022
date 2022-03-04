<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            {{ ($transportista)?'Editar':'Agregar'}} Transportista
        </h4>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Nombre</label>
    <input type="text" id="nombre" name="nombre" @if (isset($transportista)) value="{{$transportista->nombre}}" @else value="" @endif class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark">Cuit</label>
    <input type="text" id="cuit" name="cuit" @if (isset($transportista)) value="{{$transportista->cuit}}" @else value="" @endif class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark">Contacto nombre</label>
    <input type="text" id="contacto" name="contacto" @if (isset($transportista)) value="{{$transportista->contacto}}" @else value="" @endif class="form-control">
</div>

<div class="form-group">
    <label class="text-dark">Direccion</label>
    <input type="text" id="direccion" name="direccion" @if (isset($transportista)) value="{{$transportista->direccion}}" @else value="" @endif class="form-control">
</div>


<div class="form-group">
    <label class="text-dark">Telefono</label>
    <input type="text" id="telefono" name="telefono" @if (isset($transportista)) value="{{$transportista->telefono}}" @else value="" @endif class="form-control">
</div>

@if(isset($transportista))
<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" @if (isset($transportista) && $transportista->active) checked="" @endif name="active" id="active" value='1'>
        <label class="custom-control-label" for="active">Activo</label>
    </div>
</div>
@endif

@if(isset($transportista))
<input type="hidden" name="transportista_id" value="{{$transportista->id}}" />
@endif