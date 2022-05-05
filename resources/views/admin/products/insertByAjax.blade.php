<div class="row mb-5">
    <div class="col-12">
        <p>{{$product->cod_fenovo}} - {{$product->name}} <span id="mov_cod_fenovo"></span></p>
    </div>
</div>
<div class="row mb-5">
    <div class="col-12">
        <h4>
            Stock actual :: {{$product->stockReal(null, Auth::user()->store_active)}} {{$product->unit_type}}
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-12 mt-3">
        <label class="text-body">Nuevo Stock *</label>
        <fieldset class="form-group mb-3">
            <input type="number" id="nuevo_stock" name="nuevo_stock" value="" class="form-control text-center"  autofocus required/>
        </fieldset>
    </div>
    <input type="hidden" id="product_id" name="product_id" value="{{$product->id}}" class="form-control" />
</div>

<div class="row mt-5">
    <div class="col-6">
        <button type="reset" class="btn btn-outline-primary" onclick="cerrarModal()">
            <i class="fa fa-times"></i> Cancelar
        </button>
    </div>
    <div class="col-6">
        <button type="button" class="btn btn-primary" onclick="ajustarStock()">
            <i class="fa fa-save"></i> Actualizar
        </button>
    </div>
</div>
