<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            {{ ($flete)?'Editar':'Agregar'}} Parámetros
        </h4>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Hasta (Km)</label>
    <input type="text" id="hasta" name="hasta" @if (isset($flete)) value="{{$flete->hasta}}" @else value="" @endif class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark">Porcentaje</label>
    <input type="text" id="porcentaje" name="porcentaje" @if (isset($flete)) value="{{$flete->porcentaje}}" @else value="" @endif class="form-control" required>
</div>

@if(isset($flete))
<input type="hidden" name="flete_id" value="{{$flete->id}}" />
@endif