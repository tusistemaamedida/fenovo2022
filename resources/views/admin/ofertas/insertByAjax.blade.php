<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            Editar oferta
        </h4>
    </div>
</div>

<div class="form-group mt-3 mb-5">
    <div class="col-md-12">
        <p>Productos</p>
        <fieldset class="form-group mb-3">
            <select class="select2 form-control bg-transparent" name="product_id" id="product_id">
                <option value="" selected>Seleccione un producto ...</option>
                @foreach ( $productos as $product )
                <option value="{{$product->id}}" @if (isset($oferta) && $product->id == $oferta->product_id) selected @endif>
                    {{$product->name}}
                </option>
                @endforeach
            </select>
        </fieldset>
    </div>    
</div>
<div class="form-group mt-3 mb-5">
    <div class="col-md-12">
        <p>Fecha desde</p>
        <fieldset class="form-group mb-3">
            <input type="date" id="fechadesde" name="fechadesde" value="{{ isset($oferta->fecha_desde)?$oferta->fecha_desde:null }}" class="form-control" required>
        </fieldset>
    </div>    
</div>
<div class="form-group mt-3 mb-5">
    <div class="col-md-12">
        <p>Fecha hasta</p>
        <fieldset class="form-group mb-3">
            <input type="date" id="fechahasta" name="fechahasta" value="{{ isset($oferta->fecha_hasta)?$oferta->fecha_hasta:null }}" class="form-control" required>
        </fieldset>
    </div>    
</div>

@if (isset($oferta))
    <input type="hidden" name="oferta_id" value="{{$oferta->id}}" />
@endif