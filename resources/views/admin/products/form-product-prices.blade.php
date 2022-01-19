<div class="form-group row">
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-12">
                <label  class="text-body">Precio proveedor *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="plistproveedor" id="plistproveedor" value="" class="form-control border-dark">
                </fieldset>
                <p><small  id="span-plistproveedor" style="margin-top: 0;font-size:13px;top: 30px;color:rgb(217 13 47)"></small></p>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Desc. Proveedor *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="descproveedor" id="descproveedor" value="0" class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-8">
                <label  class="text-body">Costo *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="costfenovo" id="costfenovo" value="0" disabled class="form-control border-dark"  >
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Markup Fenovo *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="mupfenovo" id="mupfenovo" value="16" class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Fondo contribución *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="contribution_fund" id="contribution_fund" value="0" class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Lista 0 neto *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="plist0neto" id="plist0neto" value="0" disabled class="form-control border-dark"  >
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">IVA *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="tasiva">
                        <option value="AL">Supplier a</option>
                        <option value="WY">Supplier b</option>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-8">
                <label  class="text-body">Lista 0 neto + IVA *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="plist0iva" value="0" disabled class="form-control border-dark"  >
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-4">
                <label  class="text-body">Markup lista 1 *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="muplist1" value="0" class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-4">
                <label  class="text-body">Precio lista 1 *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="plist1" value="0" disabled class="form-control border-dark"  >
                </fieldset>
            </div>
            <div class="col-md-4">
                <label  class="text-body">Comision lista 1 *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="comlista1" value="0" disabled class="form-control border-dark"  >
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Markup lista 2 *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="muplist2" value="0" class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-4">
                <label  class="text-body">Precio lista 2 *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="plist2" value="0" disabled class="form-control border-dark"  >
                </fieldset>
            </div>
            <div class="col-md-4">
                <label  class="text-body">Comision lista 2 *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="comlista2" value="0" disabled class="form-control border-dark"  >
                </fieldset>
            </div>
        </div>
        <hr>

        <div class="form-group row">
            <div class="col-md-6">
                <label  class="text-body">Precio tienda 1 *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="p1tienda" value="0" class="form-control border-dark"  >
                </fieldset>
            </div>
            <div class="col-md-6">
                <label  class="text-body">Markup precio tienda 1 *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="mup1" value="0" disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Cant. mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="cantmay1" value="0" class="form-control border-dark"  >
                </fieldset>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Desc. mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="descp1" value="0" class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Precio 1 mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="p1may" value="0" disabled class="form-control border-dark"  >
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Markup *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="mupp1may" value="0" disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
        </div>
        <hr>

        <div class="form-group row">
            <div class="col-md-6">
                <label  class="text-body">Precio tienda 2 *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="p2tienda" value="0" class="form-control border-dark"  >
                </fieldset>
            </div>
            <div class="col-md-6">
                <label  class="text-body">Markup precio tienda 2 *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="mup2" value="0" disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Cant. mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="cantmay2" value="0" class="form-control border-dark"  >
                </fieldset>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Desc. mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="descp2" value="0" class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Precio 2 mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="p2may" value="0" disabled class="form-control border-dark"  >
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Markup *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" name="mupp2may" value="0" disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
