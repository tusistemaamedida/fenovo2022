@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div id="app-productos" class="container-fluid">
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
                            <a href="{{ route('products.compararStock') }}" class="mt-1 mr-3">
                                Comparar stocks
                            </a>

                            <a href="{{ url('oferta') }}" title="Oferta de precios" class="mt-1 mr-3">
                                Ofertas
                            </a>

                            <a href="{{ url('actualizacion') }}" title="Actualización de precios" class="mt-1 mr-3">
                                Actualizaciones
                            </a>

                            <a href="{{ url('descuento') }}" title="Lista de descuentos" class="mt-1 mr-3">
                                Descuentos
                            </a>

                            <a href="{{ route('product.add') }}" title="Agregar un producto ">
                                <i class="fa fa-2x fa-plus-circle text-primary"></i>
                            </a>
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
                                Buscar &nbsp; <i class=" fa fa-search"></i>
                            </span>
                        </div>
                        <input id="buscarProducto" name="buscarProducto" v-model="txtProducto" type="text"
                            class="form-control" @keyup="buscarRegistro">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-center" id="tablaProductos">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre del producto</th>
                                    <th>Stock</th>
                                    <th>Unidad</th>
                                    <th>Proveedor</th>
                                    <th>Costo</th>
                                    <th>Historial</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="producto in productos" :key="producto.id">
                                    <td> @{{ producto.cod_fenovo }}</td>
                                    <td class=" text-left">
                                        <a :href="`${producto.linkOferta}`">
                                            @{{ producto.name }}
                                        </a>
                                    </td>
                                    <td> @{{ producto.stock }}</td>
                                    <td> @{{ producto.unit_type }}</td>
                                    <td> @{{ producto.proveedor }}</td>
                                    <td> @{{ producto.costfenovo }}</td>
                                    <td>
                                        <a :href="`${producto.linkHistorial}`">
                                            <i class="fa fa-list" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" @click.prevent="destroyProducto(producto)">
                                            <i class=" fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
