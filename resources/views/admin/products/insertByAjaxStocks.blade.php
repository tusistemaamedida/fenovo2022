<div class="row mb-2">
    <div class="col-12">
        <strong>{{$product->cod_fenovo}} - {{$product->name}} <span id="mov_cod_fenovo"></span></strong>
    </div>
</div>

<div class="row mb-5">
    <div class="col-4">
        Stock
    </div>
    <div class="col-4  text-center">
        <strong> {{$stock_total}} </strong>
    </div>
    <div class="col-4  text-center">
        <strong>{{ $product->unit_type }}</strong>
    </div>
    <div class="col-12">
        <br>
        <p>Colocar % de relación</p>
    </div>
</div>

<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th class="border-0  header-heading" scope="col" style="text-align: center">% Stock F.</th>
            </tr>
        </thead>
        <tbody id="in-box">
            <tr>
                <td class="text-center">
                    <input type="number" max="100" step="5" name="stock_f" id="stock_f" class="form-control text-center" value="50" autocomplete="off" onclick="this.select()">

                    <br>
                </td>
            </tr>

            <tr>
                <td style="border: none">Observaciones</td>
            </tr>
            <tr>
                <td >
                    <input type="text" name="observacion" id="observacion" class="form-control">
                </td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" id="product_id" name="product_id" value="{{$product->id}}" />
    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}" />
</div>

<div class="row mt-5">
    <div class="col-6">
        <button type="reset" class="btn btn-outline-primary" onclick="cerrarModal()">
            <i class="fa fa-times"></i> Cancelar
        </button>
    </div>
    <div class="col-6">
        <button type="button" class="btn btn-primary" onclick="ajustarStock()">
            <i class="fa fa-wrench"></i> Ajustar
        </button>
    </div>
</div>
