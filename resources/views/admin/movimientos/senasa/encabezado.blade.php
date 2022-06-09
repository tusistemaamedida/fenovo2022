<table style="width:100%; margin-top:1.8cm; font-size: 11px ">
    <tr>
        <td colspan="6">
            <strong style="margin-left: 9cm">
                {{ date('d', strtotime($senasa->fecha_salida)) }}
            </strong>
            <strong style="margin-left: 1cm">
                {{ date('m', strtotime($senasa->fecha_salida)) }}
            </strong>
            <strong style="margin-left: 0.5cm">
                {{ date('Y', strtotime($senasa->fecha_salida)) }}
            </strong>
            <strong style="margin-left: 2cm">
                {{ date('H:i', strtotime($senasa->hora_salida)) }}
            </strong>
            <strong style="margin-left: 1cm">
                -18
            </strong>
        </td>
    </tr>
</table>

<table style="width:100%; margin-top: 5cm; font-size: 9px ">
    <tr>
        <th class="text-center" style="width: 10%; ">&nbsp;</th>
        <th class="text-center" style="width: 55%;">&nbsp;</th>
        <th class="text-center" style="width: 10%;">&nbsp;</th>
        <th class="text-center" style="width: 5%;">&nbsp;</th>
        <th class="text-center" style="width: 5%;">&nbsp;</th>
    </tr>