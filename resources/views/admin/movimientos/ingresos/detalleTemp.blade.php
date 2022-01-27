@if(isset($producto))
<div class="row text-center">
    <div class="col-3"> Presentación </div>
    <div class="col-3"> Bultos</div>
    <div class="col-3"> </div>
    <div class="col-3"> </div>
</div>
@foreach ($presentaciones as $presentacion )
<div class="row text-center">
    <div class="col-3"> {{ $presentacion }} </div>
    <div class="col-3"> <input type="number" id="{{ $presentacion }}" class="form-control text-center calculate" value="0" onkeyup="sumar()"> </div>
    <div class="col-3"></div>
    <div class="col-3"></div>
</div>
@endforeach
<div class="row">
    <div class="col-3 text-center">
        <button id="btn-guardar-producto" onclick="guardarItem({{ $producto->id }})" class="d-none btn btn-primary rounded-pill btn-small">
            Guardar
        </button>
    </div>
    <div class="col-3"> <input type="number" class="form-control total text-center" value="" disabled="true"> </div>
    <div class="col-3"> {{ $producto->unit_type }} </div>
    <div class="col-3"> </div>
</div>
<div class="row">
    <div class="col-12">
        <br>
    </div>
</div>

@endif