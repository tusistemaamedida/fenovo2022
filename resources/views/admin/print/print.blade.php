@extends('layouts.app')

@section('content')
    @inject('carbon', 'Carbon\Carbon')

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mt-5">
                        <div class="col-lg-12 col-xl-6">
                            <h4 class="card-label mb-0 font-weight-bold text-body">
                                Menú :: Impresión | Exportación
                            </h4>
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-xl-12 col-lg-12 ">
                            &nbsp;
                        </div>
                    </div>

                    <div class="card card-body gutter-b bg-white border-0">
                        <div class="row mt-3 mb-5 font-weight-bolder">
                            <div class="col-12">
                                Exportación Diaria Fenovo
                            </div>
                        </div>
                        <div class="row mb-2 ml-2 border-bottom-dark">

                            <div class="col-2">
                                <a href="{{ route('movement.exportCSV') }}" title="Exportar movimientos " target="_blank"
                                    class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> Movimientos
                                </a>
                            </div>

                            <div class="col-2">
                                <a href="{{ route('movement.exportOrdenesCSV') }}" title="Exportar ordenes "
                                    target="_blank" class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> Ordenes
                                </a>
                            </div>

                            <div class="col-2">
                                <a href="{{ route('products.exportCSV') }}" title="Exportar todos los productos"
                                    class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> Productos
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('products.exportPresentacionesCSV') }}" title="Exportar presentaciones"
                                    class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> Presentaciones
                                </a>
                            </div>

                            <div class="col-2">
                                <a href="{{ route('products.exportDescuentosCSV') }}" title="Exportar descuentos"
                                    class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> Descuentos
                                </a>
                            </div>


                            <div class="col-2">
                                <a href="{{ route('oferta.excepciones.exportCSV') }}">
                                    <i class=" fa fa-file-csv"></i> Excepciones
                                </a>
                            </div>

                        </div>

                        <div class="row mb-2 ml-2 border-bottom-dark">
                            <div class="col-2">
                                <a href="{{ route('actualizacion.exportCSVM1') }}" class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> Actualiz. precio lista 1
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('actualizacion.exportCSVM2') }}" class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> Actualiz. precio lista 2
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card card-body gutter-b bg-white border-0">
                        <div class="row mb-2 font-weight-bolder">
                            <div class="col-12">
                                Exportación CABE
                            </div>
                        </div>
                        <div class="row mb-2 ml-2 border-bottom-dark">
                            <div class="col-2">
                                <a href="{{ route('export.cabePed') }}" title="Exportar archivo CABE_PED"
                                    class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> PED
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('export.cabeEle') }}" title="Exportar archivo CABE-ELE"
                                    class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> ELE
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card card-body gutter-b bg-white border-0">
                        <div class="row mb-2 font-weight-bolder">
                            <div class="col-3">
                                Retenciones y Percepciones ER
                            </div>
                        </div>
                        <div class="row mb-2 ml-2 border-bottom-dark text-center">
                            <div class="col-2">
                                <a onclick="javascript:printIIBB()" title="Exportar Ingresos Brutos"
                                    class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> IIBB
                                </a>
                            </div>
                            <div class="col-2">
                                <input type="month" id="iibbFecha" name="iibbFecha" value="{{ date('Y-m') }}" class="form-control">
                            </div>

                            <div class="col-2">
                                
                            </div>
                            <div class="col-2">
                                
                            </div>
                        </div>

                        <div class="row mt-3 mb-4 font-weight-bolder">
                            <div class="col-3">
                                Ventas detalladas
                            </div>
                        </div>
                        <div class="row mb-5 ml-2 border-bottom-dark text-center">
                            <div class="col-2">
                                <a onclick="javascript:printVENTAS()" title="Exportar Ventas"
                                    class="mt-1 mr-3">
                                    <i class=" fa fa-file-csv"></i> VENTAS
                                </a>
                            </div>
                            <div class="col-2">
                                <input type="month" id="ventasFecha" name="ventasFecha" value="{{ date('Y-m') }}" class="form-control">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            let desde;
            let hasta;
            let iibbMes;
            let iibbAnio

            const leerDatos = () => {
                desde = jQuery("#salidaDesde").val();
                hasta = jQuery("#salidaHasta").val();
            }

            const exportarMovimientosCSV = () => {
                leerDatos();
                let url = "{{ route('movement.exportCSV', '') }}" + "?desde=" + desde + "&hasta=" + hasta;
                window.location = url;
            }

            const printMovimientos = () => {
                leerDatos();
                let url = "{{ route('movement.printPDF', '') }}" + "?desde=" + desde + "&hasta=" + hasta;
                window.location = url;
            }

            const printIIBB = ()=>{
                let iibbFecha = jQuery("#iibbFecha").val().split('-');
                iibbAnio = iibbFecha[0];
                iibbMes = iibbFecha[1];
                let url = "{{ route('export.iibb', '') }}" + "?mes=" + iibbMes + "&anio=" + iibbAnio;
                window.location = url;
            }

            const printVENTAS = ()=>{
                let ventasFecha = jQuery("#ventasFecha").val().split('-');
                ventasAnio = ventasFecha[0];
                ventasMes = ventasFecha[1];
                let url = "{{ route('export.ventas', '') }}" + "?mes=" + ventasMes + "&anio=" + ventasAnio;
                window.location = url;
            }
        </script>
    @endsection
