<div class="row">
    <h4>{{$product->name}} <span id="mov_cod_fenovo"></span></h4>
    <br><br>
    <h5>Stock actual {{$product->stock(null, Auth::user()->store_active)}} {{$product->unit_type}}</h5>
    <br>
    <br>
</div>
<div class="row">
    <div class="form-group mt-3">
        <label class="text-body">Nuevo Stock *</label>
        <fieldset class="form-group mb-3">
            <input type="number" id="nuevo_stock" name="nuevo_stock" value="" class="form-control text-center" />
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
