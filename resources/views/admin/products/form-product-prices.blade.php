<div class="form-group row">
    <div class="col-md-5">
        <div class="form-group row">
            <div class="col-md-12">
                <label  class="text-body">Precio proveedor * </label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->plistproveedor}}" @else value="" @endif
                    name="plistproveedor" id="plistproveedor" class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->plistproveedor}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Desc. Proveedor *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->descproveedor}}" @else value="0" @endif
                    name="descproveedor" id="descproveedor"  class="form-control border-dark"  >
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
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->costfenovo}}" @else value="0" @endif
                     name="costfenovo" id="costfenovo"  disabled class="form-control border-dark"  >
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->costfenovo}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Markup Fenovo *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->mupfenovo}}" @else value="16" @endif
                    name="mupfenovo" id="mupfenovo"  class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Fondo contribución *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->contribution_fund}}" @else value="0" @endif
                     name="contribution_fund" id="contribution_fund"  class="form-control border-dark"  >
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
                    <input type="number" step="0.50" @if (isset($product)) value="{{$product->product_price->plist0neto}}" @else value="0" @endif
                     min="0" name="plist0neto" id="plist0neto"  disabled class="form-control border-dark"  >
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->plist0neto}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">IVA *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="tasiva" id="tasiva">
                        @foreach ($alicuotas as $alicuota)
                            <option value="{{$alicuota->value}}"
                                @if(isset($product) && ((float)$product->product_price->tasiva == (float)$alicuota->value*100))
                                    selected
                                 @elseif($alicuota->value * 100 == 21)
                                    selected
                                @endif>
                                    {{$alicuota->description}}
                            </option>
                        @endforeach
                    </select>
                </fieldset>
            </div>

            <div class="col-md-8">
                <label  class="text-body">Lista 0 neto + IVA *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" @if (isset($product)) value="{{$product->product_price->plist0iva}}" @else value="0" @endif
                     min="0" name="plist0iva" id="plist0iva" disabled class="form-control border-dark"  >
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->plist0iva}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-12">
                <p><small  id="info-calculate" style="margin-top: 0;font-size:13px;top: 30px;color:rgb(217 13 47)"></small></p>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="form-group row">
            <div class="col-md-4">
                <label  class="text-body">Markup lista 1 *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="muplist1" id="muplist1"
                        @if (isset($product)) value="{{$product->product_price->muplist1}}" @else value="0" @endif class="form-control border-dark"  >
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
                    <input type="number" step="0.50" min="0" name="plist1" id="plist1"
                    @if (isset($product)) value="{{$product->product_price->plist1}}" @else value="0" @endif
                     disabled class="form-control border-dark"  >
                </fieldset>
            </div>
            <div class="col-md-4">
                <label  class="text-body">Comision lista 1 *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="comlista1" id="comlista1"
                    @if (isset($product)) value="{{$product->product_price->comlista1}}" @else value="0" @endif
                     disabled class="form-control border-dark"  >
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Markup lista 2 *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="muplist2" id="muplist2"
                    @if (isset($product)) value="{{$product->product_price->muplist2}}" @else value="0" @endif
                     class="form-control border-dark"  >
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
                    <input type="number" step="0.50" min="0" name="plist2" id="plist2"
                    @if (isset($product)) value="{{$product->product_price->plist2}}" @else value="0" @endif
                     disabled class="form-control border-dark"  >
                </fieldset>
            </div>
            <div class="col-md-4">
                <label  class="text-body">Comision lista 2 *</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="comlista2" id="comlista2"
                    @if (isset($product)) value="{{$product->product_price->comlista2}}" @else value="0" @endif
                     disabled class="form-control border-dark"  >
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
                    <input type="number" step="0.50" min="0" name="p1tienda" id="p1tienda"
                     @if (isset($product)) value="{{$product->product_price->p1tienda}}" @else value="0" @endif
                    class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->p1tienda}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6">
                <label  class="text-body">Markup precio tienda 1 *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="mup1" id="mup1"
                     @if (isset($product)) value="{{$product->product_price->mup1}}" @else value="0" @endif
                    disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->mup1}} @endif %</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Cant. mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="cantmay1" id="cantmay1"
                     @if (isset($product)) value="{{$product->product_price->cantmay1}}" @else value="0" @endif
                    class="form-control border-dark"  >
                </fieldset>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Desc. mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="descp1" id="descp1"
                     @if (isset($product)) value="{{$product->product_price->descp1}}" @else value="0" @endif
                    class="form-control border-dark"  >
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
                    <input type="number" step="0.50" min="0" name="p1may" id="p1may"
                     @if (isset($product)) value="{{$product->product_price->p1may}}" @else value="0" @endif
                    disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->p1may}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Markup *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="mupp1may" id="mupp1may"
                     @if (isset($product)) value="{{$product->product_price->mupp1may}}" @else value="0" @endif
                    disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->mupp1may}} @endif %</b>
                        </span>
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
                    <input type="number" step="0.50" min="0" name="p2tienda" id="p2tienda"
                     @if (isset($product)) value="{{$product->product_price->p2tienda}}" @else value="0" @endif
                    class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->p2tienda}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6">
                <label  class="text-body">Markup precio tienda 2 *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="mup2" id="mup2"
                     @if (isset($product)) value="{{$product->product_price->mup2}}" @else value="0" @endif
                    disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->mup2}} @endif %</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Cant. mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="cantmay2"
                     @if (isset($product)) value="{{$product->product_price->cantmay2}}" @else value="0" @endif
                    class="form-control border-dark"  >
                </fieldset>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Desc. mayorista *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="descp2" id="descp2" readonly
                     @if (isset($product)) value="{{$product->product_price->descp2}}" @else value="0" @endif
                    class="form-control border-dark"  >
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
                    <input type="number" step="0.50" min="0" name="p2may" id="p2may"
                     @if (isset($product)) value="{{$product->product_price->p2may}}" @else value="0" @endif
                    disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->p2may}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label  class="text-body">Markup *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="mupp2may" id="mupp2may"
                     @if (isset($product)) value="{{$product->product_price->mupp2may}}" @else value="0" @endif
                    disabled class="form-control border-dark"  >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->mupp2may}} @endif %</b>
                        </span>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
