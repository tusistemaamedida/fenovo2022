@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div id="app-localidades" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row mt-5">
                    <div class="col-lg-12 col-xl-6">
                        <h4 class="card-label mb-0 font-weight-bold text-body">
                            Localidades
                        </h4>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-xl-12 col-lg-12 ">
                        &nbsp;
                    </div>
                </div>

                <div class="card card-body gutter-b bg-white border-0">
                    <div class="row mt-3 ml-3 mb-4 font-weight-bolder">

                        <div class="col-sm-12">
                            <ul class="list-group">
                                <li v-for="item in lists" class="list-group-item">
                                    @{{ item.nombre }} - @{{ item.provincia }}
                                </li>
                            </ul>
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