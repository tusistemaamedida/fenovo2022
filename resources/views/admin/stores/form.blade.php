@extends('layouts.app')

@section('css')
<link href="{{asset('assets/api/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">Tiendas</li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container-fluid addproduct-main">

        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card card-custom gutter-b bg-white border-0">

                    <div class="card-header align-items-center  border-0">
                        <div class="card-title mb-0">
                            <h3 class="card-label mb-0 font-weight-bold text-body"></h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="tab-content" id="v-pills-tabContent1">
                                    <div class="tab-pane fade show active" id="home-basic" role="tabpanel" aria-labelledby="home-tab-basic">
                                        <form id="formData">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    @include('admin.stores.form-details')
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
<script src="{{asset('assets/api/select2/select2.min.js')}}"></script>

<script>
    var table = jQuery('.yajra-datatable').DataTable({});
</script>
@endsection