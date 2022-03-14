<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            {{ ($descuento)?'Editar':'Agregar'}} descuento
        </h4>
    </div>
</div>

<div class="form-group mt-3 mb-5">
    <label class="text-dark">Codigo</label>
    <input type="text" id="codigo" name="codigo" @if (isset($descuento)) value="{{$descuento->codigo}}" @else value="" @endif class="form-control" required>
</div>

<div class="form-group mt-5 mb-5">
    <label class="text-dark">Descripcion</label>
    <input type="text" id="descripcion" name="descripcion" @if (isset($descuento)) value="{{$descuento->descripcion}}" @else value="" @endif class="form-control" required>
</div>

<div class="form-group mt-5 mb-5">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Descuento</label>
            <input type="number" step="0.1" id="descuento" name="descuento" @if (isset($descuento)) value="{{$descuento->descuento}}" @else value="" @endif class="form-control" required>
        </div>
        <div class="col-6">
            <label class="text-dark">Cantidad</label>
            <input type="number" id="cantidad" name="cantidad" @if (isset($descuento)) value="{{$descuento->cantidad}}" @else value="" @endif class="form-control" required>
        </div>
    </div>
</div>

<div class="form-group mt-5 mb-5 d-none ">
    <p>Tipo</p>
    <fieldset class="form-group mb-3">
        <select class="js-example-basic-single js-states form-control bg-transparent" id="tipo" name="tipo">
            <option value="DESCUENTO" @if (isset($descuento) && ($descuento->tipo = 'DESCUENTO')) selected @endif> DESCUENTO</option>
        </select>
    </fieldset>
</div>


@if (isset($descuento))

<div class="row mb-5">
    <div class="col-4">
        <fieldset>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" @if (isset($descuento) && $descuento->active) checked="" @endif name="active" id="active" value='1'>
                <label class="custom-control-label" for="active">Activo</label>
            </div>
        </fieldset>
    </div>
</div>
<input type="hidden" name="descuento_id" id="descuento_id" value="{{$descuento->id}}" />
@endif