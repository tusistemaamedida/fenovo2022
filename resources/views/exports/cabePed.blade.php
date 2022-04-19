<table>
    <tr>
        <td colspan="15">{{ $data }}</td>
    </tr>
    <tr>
        <td>IDCAJA</td>
        <td>NROCOM</td>
        <td>FECHA</td>
        <td>HORA</td>
        <td>FISCAL</td>
        <td>ID_CLI</td>
        <td>NOMCLI</td>
        <td>CUICLI</td>
        <td>IVACLI</td>
        <td>NETO_1</td>
        <td>IVAA_1</td>
        <td>NETO_2</td>
        <td>IVAA_2</td>
        <td>NOGRAV</td>
        <td>TOTVTA</td>
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
        <td>{{ $element->TOTVTA}}</td>
    </tr>
    @endforeach
</table>
