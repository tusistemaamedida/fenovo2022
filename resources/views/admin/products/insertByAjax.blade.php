<div class="row mb-2">
    <div class="col-12">
        <p>{{$product->cod_fenovo}} - {{$product->name}} <span id="mov_cod_fenovo"></span></p>
    </div>
</div>

<div class="row mb-5">
    <div class="col-4">
        STOCK ACTUAL
    </div>
    <div class="col-4  text-center">
        <strong> {{$stock_total}} </strong>
    </div>
    <div class="col-4  text-center">
        <strong>{{ $product->unit_type }}</strong>
    </div>
</div>

<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th class="border-0  header-heading" scope="col">Presentación</th>
                <th class="border-0  header-heading" scope="col">Cantidad actual de bultos</th>
            </tr>
        </thead>
        <tbody id="in-box">
            @for ($i = 0; $i < count($stock_presentaciones); $i++) <tr>
                <td>{{$stock_presentaciones[$i]['presentacion']}}</td>
                <td class="text-center">
                    <input type="text" name="unidades_{{$stock_presentaciones[$i]['presentacion']}}" id="unidades_{{$stock_presentaciones[$i]['presentacion']}}" class="form-control text-center" value="" autocomplete="off" onclick="this.select()">
                </td>
                </tr>
                @endfor
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Observaciones (obligatorio)</td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="text" name="observacion" id="observacion" class="form-control">
                </td>
            </tr>
        </tfoot>
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