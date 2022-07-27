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
                            </div>
                        </div>
                    </div>
                </div>
                @if (Session()->has('error-store'))
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div class="alert alert-card alert-danger" role="alert">
                                <strong class="text-capitalize">ERROR!</strong><br> {!! Session::get('error-store') !!} &nbsp; &nbsp; &nbsp; &nbsp;
                                <a href="{{route('mis.facturas')}}"  rel="noopener noreferrer"> <strong style="color: green">VOLVER</strong> </a>
                            </div>
                        </div>
                    </div>
                @endif
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
                                                    <th>Cliente</th>
                                                    <th>CUIT</th>
                                                    <th>Importe total</th>
                                                    <th>Fecha</th>
                                                    <th class="no-sort">Descargar</th>
                                                </tr>
                                            </thead>
                                            <tbody class="kt-table-tbody text-dark">
                                                @foreach ($invoices as $invoice)
                                                    <tr>
                                                        <td>{{$invoice->id}}</td>
                                                        <td>{{$invoice->cae}}</td>
                                                        <td>{{$invoice->client_name}}</td>
                                                        <td>{{$invoice->client_cuit}}</td>
                                                        <td>${{number_format($invoice->imp_total, 2, ',', '.')}}</td>
                                                        <td>{{\Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y')}}</td>
                                                        <td>
                                                            <a class="text-primary" title="Descargar factura" target="_blank" href="{{$invoice->url}}"> <i class="fa fa-download"></i></a>
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
