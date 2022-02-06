<header>
    <div class="row">
        <div class="col-12">
            <table style="width: 100%">
                <tr>
                    <td style="width: 20%">
                        <img src="{{asset('assets/images/misc/senasa_opt.png')}}" alt="fenovo">
                    </td>
                    <td style="width: 80%; font-size: 18px; text-align: center">
                        Permiso de Tránsito
                    </td>
                    <td style="width: 20%">
                        <img src="{{asset('assets/images/misc/ministerio_opt.png')}}" alt="fenovo">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <hr />
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table style="width: 100%">
                <tr>
                    <td style="width: 45%">LUGAR DE EMISION</td>
                    <td class=" text-center" style="width: 10%">DIA</td>
                    <td class=" text-center" style="width: 10%">MES</td>
                    <td class=" text-center" style="width: 10%">AÑO</td>
                    <td class=" text-center" style="width: 15%">HORA SALIDA</td>
                    <td class=" text-center" style="width: 5%">TEMP</td>
                </tr>
                <tr>
                    <th>PARANA - ENTRE RIOS</th>
                    <th class=" text-center">{{ date('d', strtotime($senasa->fecha_salida)) }}</th>
                    <th class=" text-center">{{ date('m', strtotime($senasa->fecha_salida)) }}</th>
                    <th class=" text-center">{{ date('Y', strtotime($senasa->fecha_salida)) }}</th>
                    <th class=" text-center">{{ $senasa->hora_salida }}</th>
                    <th class=" text-center">-18</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-12">
            Autorízase al estableciento Nro Oficial <strong> 5241 FENOVO S.A.</strong> a transportar los siguientes productos inspeccionados
        </div>
    </div>
</header>