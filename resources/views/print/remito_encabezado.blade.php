<table class="table table-borderless text-center" style="margin-top: 2.5cm; font-size: 12px ">
    <tr>
        <td>FECHA {{ $fecha }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>{{ $mercaderia_en_transito }}</td>
    </tr>
</table>

<table class="table table-borderless" style="margin-top: 0.7cm; font-size: 12px ">
    <tr>
        <td>&nbsp;</td>
        <td>
            {{ $destino->razon_social }}
        </td>
        <td>
            CUIT {{ $destino->cuit }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            {{ $destino->address }}
        </td>
        <td>
            {{ $destino->city }}
        </td>
    </tr>
</table>



<table style="width:100%; margin-top: 0.5cm; font-size: 10px ">
