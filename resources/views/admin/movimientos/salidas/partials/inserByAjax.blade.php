<h4>{{$product->name}}</h4>
<br>
<div class="form-group">
    <label class="text-dark">Stock: <strong>{{$stock_total}}</strong> Kg.   Envio total: <strong id="envio_total">0</strong> Kg.</label>
    <input type="hidden" name="kg_totales" id="kg_totales" value="0">
    <input type="hidden" name="unit_weight" value="{{(float)$stock_presentaciones[0]['unit_weight']}}" id="unit_weight">

    <form name="unidades_a_enviar" id="unidades_a_enviar">
        <table class="table table-striped  text-body">
            <thead>
                <tr class="">
                    <th class="border-0  header-heading" scope="col">Pres.</th>
                    <th class="border-0  header-heading" scope="col">Enviar</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($stock_presentaciones); $i++) <tr>
                    <td>{{$stock_presentaciones[$i]['presentacion']}}</td>
                    <td>
                        <input
                        type="number"
                        name="unidades_{{(float)$stock_presentaciones[$i]['presentacion']}}"
                        id="{{(float)$stock_presentaciones[$i]['presentacion']}}"
                        class="form-control calculate" @if($stock_total==0) disabled @endif
                        max="{{$stock_presentaciones[$i]['bultos']}}" value="0"
                        onkeyup="sumar()">
                    </td>
                    </tr>
                    @endfor
            </tbody>
        </table>
    </form>
    <br>
</div>
<br>
