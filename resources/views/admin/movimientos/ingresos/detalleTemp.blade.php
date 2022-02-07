@if(isset($producto))
<div class="row mb-2 text-center font-weight-bold">
    <div class="col-3"> Presentación </div>
    <div class="col-3"> <span class=" text-danger">Ingrese bultos</span> </div>
    <div class="col-3"> </div>
    <div class="col-3"> </div>
</div>
@foreach ($presentaciones as $presentacion )
<div class="row text-center">
    <div class="col-3"> {{ $presentacion }} </div>
    <div class="col-3"> <input type="number" id="{{ $presentacion }}" class="form-control text-center calculate" onkeyup="sumar()" value="0"> </div>
    <div class="col-3"></div>
    <div class="col-3"></div>
</div>
@endforeach
<div class="row mt-2 text-center font-weight-bold" style="display: flex; flex-wrap: wrap">
    <div class="col-3"> <span class=" text-danger">Total </span></div>
    <div class="col-3"> <input type="number" class="form-control total text-center bg-transparent disabled" value="" readonly> </div>
    <div class="col-3"> {{ $producto->unit_type }} </div>
    <div class="col-3"> <button id="btn-guardar-producto" onclick="guardarItem('{{ $producto->id }}', '{{ $producto->unit_weight }}')" class="btn-link btn-outline-primary rounded-pill"> Guardar <i class=" fa fa-save text-primary"></i> </button> </div>
</div>
<div class="row">
    <div class="col-12">
        <br>
    </div>
</div>

@endif