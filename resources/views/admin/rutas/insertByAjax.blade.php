<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            {{ ($ruta)?'Editar':'Agregar'}} Ruta
        </h4>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Nombre</label>
    <input type="text" id="nombre" name="nombre" @if (isset($ruta)) value="{{$ruta->nombre}}" @else value="" @endif class="form-control" required>
</div>

@if(isset($ruta))
<input type="hidden" name="ruta_id" value="{{$ruta->id}}" />
@endif