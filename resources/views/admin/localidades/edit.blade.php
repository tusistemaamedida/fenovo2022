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
                                        Editar localidad
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ route('localidades.index') }}">
                                        Localidades
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-body gutter-b bg-white border-0">
                    <div class="row mt-3 ml-3 mb-4 font-weight-bolder">

                        <div class="col-sm-12">

                            <form @submit.prevent="updateLocalidad(localidadEdit.id)">

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="modal-title"></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nombre">Localidad</label>
                                            <input type="text" name="nombre" class="form-control" v-model="localidadEdit.nombre">
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre">Departamento</label>
                                            <input type="text" name="departamento" class="form-control" v-model="localidadEdit.departamento">
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre">Provincia</label>
                                            <input type="text" name="provincia" class="form-control" v-model="localidadEdit.provincia">
                                        </div>
                                        <div class="form-group mt-5 mb-5">
                                            <span v-for="error in errors" class=" text-danger ">
                                                @{{ error }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input type="submit" class="btn btn-primary" value="Guardar" />
                                    </div>

                                </div>

                            </form>

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