@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div id="app-productos" class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                                <div class="card-header align-items-center  border-bottom-dark px-0">
                                    <div class="card-title mb-0">
                                        <h4 class="card-label mb-0 font-weight-bold text-body">
                                            Productos
                                        </h4>
                                    </div>
                                    <div class="icons d-flex">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-body gutter-b bg-white border-0">
                        <div class="row">
                            <div class="col-9">

                            </div>
                            <div class="col-3">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            Buscar  &nbsp; <i class=" fa fa-search"></i>
                                        </span>
                                    </div>
                                    <input id="buscarProducto" name="buscarProducto" v-model="txtProducto" type="text" class="form-control" @keyup ="buscarRegistro">
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-12">                                
                                <div class="table-responsive" >
                                    <table class="table table-hover table-striped text-center" id="tablaProductos">
                                        <thead>
                                            <tr>
                                                <th>CodFenovo</th>
                                                <th>Producto</th>
                                                <th>Stock</th>
                                                <th>Unidad</th>
                                                <th>Proveedor</th>
                                                <th>Costo</th>
                                                <th>Ver</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                            <tr v-for="producto in productos" :key="producto.id">
                                                <td> @{{ producto.cod_fenovo }}</td>
                                                <td class=" text-left"> @{{ producto.name }}</td>
                                                <td> @{{ producto.stock }}</td>
                                                <td> @{{ producto.unit_type }}</td>
                                                <td> @{{ producto.proveedor }}</td>
                                                <td> @{{ producto.costfenovo }}</td>
                                                <td> <a :href="`${producto.link}`"><i class="fa fa-edit"></i></a></td>
                                            </tr>
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
@endsection

@section('js')
    <script>
    </script>
@endsection
