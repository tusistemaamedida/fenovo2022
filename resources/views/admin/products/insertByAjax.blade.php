<div class="row mb-5">
    <div class="col-12">
        <p>{{$product->cod_fenovo}} - {{$product->name}} <span id="mov_cod_fenovo"></span></p>
    </div>
</div>
<div class="row mb-5">
    <div class="col-12">
        <h4>
            Stock actual :: {{$stock_total}} Kgs.
        </h4>
    </div>
</div>

<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th class="border-0  header-heading" scope="col">Presentación</th>
                <th class="border-0  header-heading" scope="col">Ingrese Bultos</th>
            </tr>
        </thead>
        <tbody id="in-box">
            @for ($i = 0; $i < count($stock_presentaciones); $i++) <tr>
                <td>{{$stock_presentaciones[$i]['presentacion']}}</td>
                <td class="text-center">
                    <input type="text"
                            name="unidades_{{$stock_presentaciones[$i]['presentacion']}}"
                            id="unidades_{{$stock_presentaciones[$i]['presentacion']}}"
                            class="form-control text-center"
                            value=""
                            autocomplete="off"
                            onclick="this.select()" >
                </td>
                </tr>
                @endfor
        </tbody>
    </table>
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
            <i class="fa fa-wrench"></i> Ajustar
        </button>
    </div>
</div>
