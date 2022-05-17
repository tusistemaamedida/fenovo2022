@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                    <div class="card-header align-items-center  border-bottom-dark px-0">
                        <div class="card-title mb-0">
                            <h4 class="card-label mb-0 font-weight-bold text-body">
                                Historial del producto {{$producto->cod_fenovo}} :: {{$producto->name}}
                            </h4>
                        </div>
                        <div class="icons d-flex">
                            <a href="{{ route('product.printHistorial',['id'=>$producto->id]) }}" class="mt-1 mr-3">
                                <i class=" fa fa-print"></i> Imprimir
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="card-body">
                        <div class="table-datapos">
                            <div class="table-responsive">
                                <table id="productTable" class=" table table-hover display dataTable no-footer yajra-datatable" role="grid">
                                    <thead class="text-body">
                                        <tr class="bg-light">
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Desde</th>
                                            <th>Hacia</th>
                                            <th>Observaciones</th>
                                            <th>Presentacion</th>
                                            <th>Bultos</th>
                                            <th>Entrada</th>
                                            <th>Salida </th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody class="kt-table-tbody text-dark">
                                        @foreach ($movimientos as $m)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($m->movement->created_at)->format('d/m/Y')}}</td>
                                            <td>{{ $m->movement->type}}</td>
                                            <td>{{ $m->movement->From($m->movement->type)}}</td>
                                            <td>{{ $m->movement->To($m->movement->type)}}</td>
                                            <td>{{ $m->movement->observacion}}</td>
                                            <td>{{ $m->unit_package}}</td>
                                            <td>{{ $m->bultos}}</td>
                                            <td>{{ ($m->unit_type == 'K')?$m->entry:(int)$m->entry}}</td>
                                            <td>{{ ($m->unit_type == 'K')?$m->egress:(int)$m->egress}}</td>
                                            <th>{{ ($m->unit_type == 'K')?$m->balance:(int)$m->balance}}</th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.products.modal-ajuste')
@endsection

@section('js')

<script>

</script>

@endsection
