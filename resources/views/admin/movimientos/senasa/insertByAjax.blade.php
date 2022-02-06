<div class="form-group">
    @if (isset($senasa))
    <input type="hidden" name="senasa_id" value="{{$senasa->id}}" />
    @endif
</div>


<div class="row">
    <div class="col-6">
        <label class="text-dark">Patente nro</label>
        <input type="text" id="patente_nro" name="patente_nro" @if (isset($senasa)) value="{{$senasa->patente_nro}}" @else value="" @endif class="form-control" required>
    </div>
    <div class="col-6">
        <label class="text-dark">Habilitacion nro</label>
        <input type="text" id="habilitacion_nro" name="habilitacion_nro" @if (isset($senasa)) value="{{$senasa->habilitacion_nro}}" @else value="" @endif class="form-control" required>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Precintos</label>
    <input type="text" id="precintos" name="precintos" @if (isset($senasa)) value="{{$senasa->precintos}}" @else value="" @endif class="form-control" required>
</div>
<div class="form-group">
    <label class="text-dark">Destino</label>
    <input type="text" id="destino" name="destino" @if (isset($senasa)) value="{{$senasa->destino}}" @else value="" @endif class="form-control">
</div>
<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Días validez</label>
            <input type="text" id="dias_validez" name="dias_validez" @if (isset($senasa)) value="{{$senasa->dias_validez}}" @else value="" @endif class="form-control">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Fecha salida</label>
            <input type="date" id="fecha_salida" name="fecha_salida" @if (isset($senasa)) value="{{$senasa->fecha_salida}}" @else value="" @endif class="form-control">
        </div>
        <div class="col-6">
            <label class="text-dark">Hora salida</label>
            <input type="time" id="hora_salida" name="hora_salida" @if (isset($senasa)) value="{{$senasa->hora_salida}}" @else value="" @endif class="form-control">
        </div>
    </div>
</div>