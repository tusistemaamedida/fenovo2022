<div class="form-group">
    @if (isset($senasa))
    <input type="hidden" name="senasa_id" value="{{$senasa->id}}" />
    @endif
</div>

<div class="form-group">
    <label class="text-dark">Habilitacion nro</label>
    <input type="text" id="habilitacion_nro" name="habilitacion_nro" @if (isset($senasa)) value="{{$senasa->habilitacion_nro}}" @else value="" @endif class="form-control" required>
</div>
<div class="form-group">
    <label class="text-dark">Patente nro</label>
    <input type="text" id="patente_nro" name="patente_nro" @if (isset($senasa)) value="{{$senasa->patente_nro}}" @else value="" @endif class="form-control" required>
</div>
<div class="form-group">
    <label class="text-dark">Precintos</label>
    <input type="text" id="precintos" name="precintos" @if (isset($senasa)) value="{{$senasa->precintos}}" @else value="" @endif class="form-control" required>
</div>