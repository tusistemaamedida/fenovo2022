<table>
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
        <td>PAGEFV</td>
        <td>PAGTAR</td>
        <td>PAGCTA</td>
        <td>COSVTA</td>
        <td>MARBTO</td>
        <td>DESCTO</td>
        <td>RECARG</td>
        <td>TOTFIS</td>
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
        <td>{{ $element->PAGEFV}}</td>
        <td>{{ $element->PAGTAR}}</td>
        <td>{{ $element->PAGCTA}}</td>
        <td>{{ $element->COSVTA}}</td>
        <td>{{ $element->MARBTO}}</td>
        <td>{{ $element->DESCTO}}</td>
        <td>{{ $element->RECARG}}</td>
        <td>{{ $element->TOTFIS}}</td>
    </tr>
    @endforeach
</table>
