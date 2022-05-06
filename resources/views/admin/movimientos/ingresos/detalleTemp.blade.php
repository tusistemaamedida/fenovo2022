@if(isset($producto))
<div class="row mb-2 text-center font-weight-bold">
    <div class="col-1"> Editar</div>
    <div class="col-2"> Presentación</div>
    <div class="col-3"> <span class=" text-danger">Bultos</span> </div>
    <div class="col-3"> <input type="hidden" value="{{$producto->unit_weight}}" name="unit_weight" id="unit_weight"> </div>
</div>
@foreach ($presentaciones as $presentacion )
<div class="row text-center">
    <div class="col-1">
        @if($loop->iteration == 1)
        <a href="javascript:void(0)" onclick="editarProducto({{ $producto->id}})">
            <i class="fa fa-edit text-primary"></i>
        </a>
        @endif

    </div>
    <div class="col-2"> {{ $presentacion }} </div>
    <div class="col-3"> <input type="number" id="unidades_{{ $presentacion }}" name="{{ $presentacion }}" class="form-control text-center calculate" onkeyup="sumar()" value="0" /> </div>
    <div class="col-3">
        @if($loop->last)
        <button id="btn-guardar-producto" onclick="guardarItem('{{ $producto->id }}', '{{ $producto->unit_weight }}')" class="btn-outline-primary rounded-pill"> Guardar </button>
        @endif
    </div>
</div>
@endforeach
<div class="row mt-4 text-center font-weight-bold">
    <div class="col-1"> </div>
    <div class="col-2"> <span class=" text-danger">Total </span></div>
    <div class="col-3"> <input type="number" class="form-control total text-center font-weight-bolder disabled" disabled="true" value="" readonly> </div>
    <div class="col-3"> </div>
</div>
@endif