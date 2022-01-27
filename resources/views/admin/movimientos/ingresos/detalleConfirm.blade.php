@isset($movimientos)

<div class="row font-weight-bold">
    <div class="col-1 text-center">#</div>
    <div class="col-2 text-center">Cod fenovo</div>
    <div class="col-3">Producto</div>
    <div class="col-3 text-center">Presentación</div>
    <div class="col-3 text-center">Cantidad</div>
</div>

@foreach ($movimientos as $movimiento)
<div class="row">
    <div class="col-1 text-center">{{ $loop->iteration }}</div>
    <div class="col-2 text-center">{{ $movimiento->product->cod_fenovo }} </div>
    <div class="col-3"> {{ $movimiento->product->name }}</div>
    <div class="col-3 text-center"> {{ $movimiento->unit_package }} </div>
    <div class="col-3 text-center"> {{ $movimiento->entry }}</div>
</div>
@endforeach


@endisset