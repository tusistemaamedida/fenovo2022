<div class="form-group">
    @if (isset($senasa))
    <input type="hidden" name="senasa_id" value="{{$senasa->id}}" />
    @endif
</div>

<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label>Patente nro</label>
            <fieldset class="form-group">
                <select class="js-example-basic-single js-states form-control bg-transparent" id="patente_nro" name="patente_nro" onchange="getSenasa(this.value)">
                    <option value="" selected>Patente ...</option>
                    @foreach ( $vehiculos as $vehiculo )
                    <option value="{{$vehiculo->patente}}" @if (isset($senasa) && ($senasa->patente_nro == $vehiculo->patente)) selected @endif>
                        {{$vehiculo->patente }}
                    </option>
                    @endforeach
                </select>
            </fieldset>
        </div>
        <div class="col-6">
            <label class="text-dark">Habilitacion nro</label>
            <input type="text" id="habilitacion_nro" name="habilitacion_nro" @if (isset($senasa)) value="{{$senasa->habilitacion_nro}}" @else value="" @endif class="form-control" required>
        </div>
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
        <div class="col-12">
            <label class="text-dark">Fecha salida</label>
            <input type="date" id="fecha_salida" name="fecha_salida" @if (isset($senasa)) value="{{$senasa->fecha_salida}}" @else value="" @endif class="form-control">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row mb-5">
        <div class="col-12">
            <label class="text-dark">Hora salida</label>
            <input type="time" id="hora_salida" name="hora_salida" @if (isset($senasa)) value="{{$senasa->hora_salida}}" @else value="" @endif class="form-control">
        </div>
    </div>
</div>