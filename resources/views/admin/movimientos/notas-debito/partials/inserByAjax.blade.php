<h4>{{$product->name}}</h4>
<br>
<div class="form-group">

        <div class="row text-center">
            <div class="col-12 bg-dark text-white">Unidad ::
                {{$product->unit_type}}</div>
        </div>
        <div class="row text-center">
            <div class="col-6">Stock</div>
            <div class="col-6">Devolución</div>
        </div>
        <div class="row text-center font-size-bold ">
            <div class="col-6">
                <h4>{{$stock_total}}</h4>
            </div>
            <div class="col-6">
                <h4> <span id="envio_total" class=" text-danger">0</span> </h4>
            </div>
        </div>


    <input type="hidden" name="tope" id="tope" value="{{$stock_total}}">
    <input type="hidden" name="kg_totales" id="kg_totales" value="0">
    <input type="hidden" name="unit_weight" value="{{(float)$stock_presentaciones[0]['unit_weight']}}" id="unit_weight">

    <div class="row">
        <div class="col-12 mt-3 mb-3">&nbsp;</div>
    </div>

    <form name="unidades_a_enviar" id="unidades_a_enviar">
        <table class="table">
            <thead>
                <tr>
                    <th class="border-0  header-heading" scope="col">Presentación</th>
                    <th class="border-0  header-heading" scope="col">Ingreso</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($stock_presentaciones); $i++) <tr>
                    <td>{{$stock_presentaciones[$i]['presentacion']}}</td>
                    <td class=" text-center ">
                        <input type="number"
                               name="unidades_{{(float)$stock_presentaciones[$i]['presentacion']}}"
                               id="{{(float)$stock_presentaciones[$i]['presentacion']}}"
                               class="form-control calculate text-center"
                               max="{{$stock_presentaciones[$i]['bultos']}}"
                               value="0"
                               onkeyup="sumar(this)" >
                    </td>
                    </tr>
                    @endfor
            </tbody>
        </table>
    </form>
    <br>
</div>
