@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div id="app-localidades" class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                            <div class="card-header align-items-center  border-bottom-dark px-0">
                                <div class="card-title mb-0">
                                    <h4 class="card-label mb-0 font-weight-bold text-body">
                                        Localidades
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    <a href="#" class="ml-2 " data-toggle="modal" data-target="#createLocalidad">
                                        <i class="fa fa-2x fa-plus-circle text-primary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-body gutter-b bg-white border-0">
                    <div class="row mt-3 ml-3 mb-4 font-weight-bolder">

                        <div class="col-sm-12">

                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Localidad</th>
                                        <th>Departamento</th>
                                        <th>Provincia</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="localidad in localidades">
                                        <td> @{{ localidad.id }}</td>
                                        <td> @{{ localidad.nombre }}</td>
                                        <td> @{{ localidad.departamento }}</td>
                                        <td> @{{ localidad.provincia }} </td>
                                        <td> <a href="#" class="btn btn-light btn-sm">Editar</a></td>
                                        <td> <a href="#" class="btn btn-light btn-sm text-danger" @click.prevent="destroyLocalidad(localidad.id)">Borrar </a> </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    @include('admin.localidades.create')

    @endsection

    @section('js')

    <script>

    </script>

    @endsection