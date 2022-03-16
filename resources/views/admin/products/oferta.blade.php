<br />
<p class=" font-italic">Fecha período de <span class=" font-weight-bolder">oferta </span></p>
<div class="row">
    <div class="col-md-5">
        <input type="date" id="fecha_desde" name="fecha_desde" value="{{ isset($oferta->fecha_desde)?$oferta->fecha_desde:null }}" class="form-control">
    </div>
    <div class="col-md-5">
        <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ isset($oferta->fecha_hasta)?$oferta->fecha_hasta:null }}" class="form-control">
    </div>
    <div class="col-md-1 mt-2">
        <a href="javascript:void(0)" title="Guardar producto en oferta " onclick="updateOferta()">
            <i class="fa fa-save text-dark"></i>
        </a>
    </div>
    <div class="col-md-1 mt-2">
        @if(isset($oferta))
        <a href="javascript:void(0)" title="Quitar producto en oferta " onclick="deleteOferta({{ $oferta->id }})">
            <i class=" fa fa-trash"></i>
        </a>
        @endif
    </div>
</div>