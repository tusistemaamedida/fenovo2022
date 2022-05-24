<table>
    <tr>
        <td colspan="17">{{ $data }}</td>
    </tr>

    @foreach($arr_elementos as $element)
    <tr>
        <td>{{ $element->IDCAJA}}</td>
        <td>{{ $element->NROCOM}}</td>
        <td>{{ $element->FECHA}}</td>
        <td>{{ $element->HORA}}</td>
        <td>{{ $element->FISCAL}}</td>
        <td>{{ $element->ID_CLI}}</td>
        <td>{{ $element->NOMCLI}}</td>
        <td>{{ $element->CUICLI}}</td>
        <td>{{ $element->IVACLI}}</td>
        <td>{{ $element->NETO_1}}</td>
        <td>{{ $element->IVAA_1}}</td>
        <td>{{ $element->NETO_2}}</td>
        <td>{{ $element->IVAA_2}}</td>
        <td>{{ $element->NOGRAV}}</td>
        <td>{{ $element->IIBB}}</td>
        <td>{{ $element->TOTVTA}}</td>
    </tr>
    @endforeach
</table>
