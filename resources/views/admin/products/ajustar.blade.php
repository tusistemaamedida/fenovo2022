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
                                Ajustar stocks entre depósitos
                            </h4>
                        </div>
                        <div class="icons d-flex">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="text-dark">Tienda donde <span class=" text-success">ingresa la mercadería </span></label>
                                    <fieldset class="form-group">
                                        <select class="rounded form-control bg-transparent" name="store_active" required>
                                            <option value="">Seleccione ...</option>
                                            @foreach ($stores as $store)
                                            <option value="{{$store->id}}">
                                                {{ str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT) }} - {{$store->description}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="text-dark">Tienda donde <span class=" text-danger">sale la mercadería</span></label>
                                    <fieldset class="form-group">
                                        <select class="rounded form-control bg-transparent" name="store_active" required>
                                            <option value="">Seleccione ...</option>
                                            @foreach ($stores as $store)
                                            <option value="{{$store->id}}">
                                                {{ str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT) }} - {{$store->description}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </fieldset>
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

<script>
    
</script>

@endsection