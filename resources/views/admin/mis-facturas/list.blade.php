@extends('layouts.app-facturas')

@section('css')
<link href="{{asset('assets/api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')


<div class="d-flex flex-column-fluid">
    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                            <div class="card-header align-items-center  border-bottom-dark px-0">
                                <div class="card-title mb-0">
                                    <h4 class="card-label mb-0 font-weight-bold text-body">
                                        Facturas generadas
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ route('mis.facturas') }}">
                                        Salir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($invoices))
                    <div class="row">
                        <div class="col-12 ">
                            <div class="card card-custom gutter-b bg-white border-0">
                                <div class="card-body">
                                    <div class=" table-responsive" id="printableTable">
                                        <table id="productTable" class="display table-hover yajra-datatable">
                                            <thead class="text-body">
                                                <tr>
                                                    <th>#</th>
                                                    <th>CAE</th>
                                                    <th>Nombre</th>
                                                    <th>CUIT</th>
                                                    <th>Tienda</th>
                                                    <th>Importe total</th>
                                                    <th>Fecha</th>
                                                    <th class="no-sort">FAC</th>
                                                    <th class="no-sort">PAN</th>
                                                    <th class="no-sort">FLE</th>
                                                </tr>
                                            </thead>
                                            <tbody class="kt-table-tbody text-dark">
                                                @foreach ($invoices as $invoice)
                                                    <tr>
                                                        <td>{{$invoice->id}}</td>
                                                        <td>{{$invoice->cae}}</td>
                                                        <td>{{$invoice->client_name}}</td>
                                                        <td>{{$invoice->client_cuit}}</td>
                                                        <td>{{$invoice->tienda()}}</td>
                                                        <td>${{number_format($invoice->imp_total, 2, ',', '.')}}</td>
                                                        <td>{{\Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y')}}</td>
                                                        <td>
                                                            <a class="text-primary" title="Descargar FACTURA" target="_blank" href="{{$invoice->url}}"> <i class="fa fa-download"></i></a>
                                                        </td>
                                                        <td>
                                                            @if($invoice->panama)
                                                                <a class="text-primary" title="Descargar PAN" target="_blank" href="{{route('tiendas.print.panama', ['id' => $invoice->movement_id])}}">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($invoice->flete)
                                                                <a class="text-primary" title="Descargar FLETE" target="_blank" href="{{route('tiendas.print.flete', ['id' => $invoice->movement_id])}}">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    jQuery('.yajra-datatable').DataTable();
</script>
@endsection