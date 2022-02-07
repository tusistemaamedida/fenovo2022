<footer>
    <div class="mb-3 p-2 border border-3 border-dark border-dashed rounded-circle">
        <div class="row mb-1">
            <div class="col-12">
                En el camión patente Nro <strong>{{ $senasa->patente_nro }}</strong> habilitación SENASA Nro <strong>{{ $senasa->habilitacion_nro }}</strong> Precinto/s Nro <strong>{{ $senasa->precintos }}</strong>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-12">
                Destino <strong>{{ $senasa->destino }}</strong>
            </div>
        </div>
    </div>
    <table width="100%">
        <tr class="text-center">
            <th colspan="2">
                ESTE DOCUMENTO ES VALIDO POR {{ $senasa->dias_validez }} DIAS
            </th>
        </tr>
        <tr>
            <th colspan="2">
                INTERVIENE
            </th>
        </tr>
        <tr class="text-center">
            <td>
                ..............................................................................
            </td>
            <td>
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
</footer>