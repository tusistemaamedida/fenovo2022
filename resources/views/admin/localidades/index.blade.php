@extends('layouts.app')

@section('css')

@endsection

@section('content')

<div id="app-localidades" class="d-flex flex-column-fluid">
    <div class="container-fluid">
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
                                    <a href="#" data-toggle="modal" data-target="#crearLocalidad" class="ml-2">
                                        <i class="fa fa-2x fa-plus-circle text-primary" @click="limpiarLocalidad"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-body gutter-b bg-white border-0" data-aos="fade-up">

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="tablaLocalidades">
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
                                            <td> <a href="javascript:void(0)" class="btn btn-light btn-sm" @click.prevent="editarLocalidad(localidad)">Editar</a></td>
                                            <td> <a href="javascript:void(0)" class="btn btn-light btn-sm text-danger" @click.prevent="destroyLocalidad(localidad.id)">Borrar </a> </td>
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
    @include('admin.localidades.create')
    @include('admin.localidades.edit')
</div>

@endsection

@section('js')

<script>

</script>

@endsection