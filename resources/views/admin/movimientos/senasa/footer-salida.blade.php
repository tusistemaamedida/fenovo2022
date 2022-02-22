<footer-5>
    <table style="width:100%; font-size: 11px ">
        <tr>
            <td colspan="2">
                En el camión patente Nro <strong>{{ $senasa->patente_nro }}</strong> habilitación SENASA Nro <strong>{{ $senasa->habilitacion_nro }}</strong> Precinto/s Nro <strong>{{ $senasa->precintos }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Destino <strong>{{ $senasa->destino }}</strong>
            </td>
        </tr>
        <tr class="text-center">
            <td colspan="2">
                ESTE DOCUMENTO ES VALIDO POR <strong> {{ $senasa->dias_validez }} </strong> DIAS
            </td>
        </tr>
        <tr>
            <td>
                <strong> INTERVIENE </strong> .....................................................................
            </td>
            <td class="text-center">
                ..............................................................................
            </td>
        </tr>
        <tr class="text-center">
            <td>Aclaración firma</td>
            <td>Firma Inspección Veterinaria</td>
        </tr>
        <tr>
            <td colspan="2">
                <br>
                Página <strong> <span class="pagenum"></span> </strong>
            </td>
        </tr>
    </table>
</footer-5>