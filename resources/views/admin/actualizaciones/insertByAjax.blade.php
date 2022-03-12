<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            {{ ($actualizacion)?'Editar':'Agregar'}} Actualización de precio
        </h4>
    </div>
</div>

<div class="form-group mt-5 mb-5">
    <label class="text-dark">Fecha</label>
    <input type="date" id="fecha" name="fecha" @if (isset($actualizacion)) value="{{$actualizacion->fecha}}" @else value="" @endif class="form-control" required>
</div>


@if (isset($actualizacion))

<div class="row" style="margin-bottom: 25px">
    <div class="col-4">
        <fieldset>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" @if (isset($actualizacion) && $actualizacion->active) checked="" @endif name="active" id="active" value='1'>
                <label class="custom-control-label" for="active">Activo</label>
            </div>
        </fieldset>
    </div>
</div>


<input type="hidden" name="actualizacion_id" value="{{$actualizacion->id}}" />
@endif