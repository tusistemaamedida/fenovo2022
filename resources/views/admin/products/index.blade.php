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

                    <div class="card card-body gutter-b bg-white border-0" data-aos="fade-up">
                        <div class="row">
                            <div class="col-2">
                                
                            </div>
                            <div class="col-2">
                                
                            </div>
                            <div class="col-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" @keyup ="buscarRegistro" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" id="tablaProductos">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Producto</th>
                                                <th></th>
                                                <th></th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="producto in productos">
                                                <td> @{{ producto.id }}</td>
                                                <td> @{{ producto.name }}</td>
                                                <td></td>
                                                <td></td>
                                                <td> 
                                                    <a href="javascript:void(0)" class="btn btn-light btn-sm"
                                                        @click.prevent="editarProducto(producto)">Editar
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
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script></script>
@endsection
