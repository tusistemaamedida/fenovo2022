@extends('layouts.app')

@section('css')
<link href="{{asset('assets/api/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid addproduct-main">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card card-custom gutter-b bg-white border-0">

                    <div class="card-header align-items-center  border-0">
                        <div class="card-title mb-0">
                            <h4 class="card-label mb-0 font-weight-bold text-body"> </h4>
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

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h4 class="font-size-h4 font-weight-bold m-0">{{ ($proveedor)?'Editar':'Agregar'}} proveedor</h4>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <label class="text-dark">Razon social </label>
                                                                <input type="text" id="name" name="name" @if (isset($proveedor)) value="{{$proveedor->name}}" @else value="" @endif class="form-control" required>
                                                            </div>
                                                            <div class="col-4">
                                                                <label class="text-dark">Contacto</label>
                                                                <input type="text" id="responsable" name="responsable" @if (isset($proveedor)) value="{{$proveedor->responsable}}" @else value="" @endif class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <label class="text-dark">Tipo Iva</label>
                                                                <fieldset class="form-group">
                                                                    <select class="rounded form-control bg-transparent" name="iva_type">
                                                                        @forelse ($ivaType as $iva)

                                                                        <option value="{{$iva['type']}}" @if(isset($proveedor) && ($iva['type']==$proveedor->iva_type)) selected @endif>
                                                                            {{$iva['type'] }}
                                                                        </option>

                                                                        @empty
                                                                        <option value="">Sin tipo iva</option>
                                                                        @endforelse
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-2">
                                                                <label class="text-dark">Cuit</label>
                                                                <input type="text" id="cuit" name="cuit" @if (isset($proveedor)) value="{{$proveedor->cuit}}" @else value="" @endif class="form-control">
                                                            </div>

                                                            <div class="col-6">
                                                                <label class="text-dark">E-mail</label>
                                                                <input type="text" id="email" name="email" @if (isset($proveedor)) value="{{$proveedor->email}}" @else value="" @endif class="form-control" required>
                                                            </div>
                                                            <div class="col-2">
                                                                <label class="text-dark">Telefono</label>
                                                                <input type="text" id="telephone" name="telephone" @if (isset($proveedor)) value="{{$proveedor->telephone}}" @else value="" @endif class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="text-dark">Dirección</label>
                                                        <input type="text" id="address" name="address" @if (isset($proveedor)) value="{{$proveedor->address}}" @else value="" @endif class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label class="text-dark">Ciudad</label>
                                                                <input type="text" id="city" name="city" @if (isset($proveedor)) value="{{$proveedor->city}}" @else value="" @endif class="form-control">
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="text-dark">Provincia</label>
                                                                <fieldset class="form-group">
                                                                    <select class="rounded form-control bg-transparent" name="state">
                                                                        @forelse ($states as $state)
                                                                        <option value="{{$state['name']}}" @if(isset($proveedor) && ($state['name']==$proveedor->state)) selected @endif>
                                                                            {{$state['name'] }}
                                                                        </option>

                                                                        @empty
                                                                        <option value="">No hay provincia</option>
                                                                        @endforelse
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    @if (isset($proveedor))

                                                    {!! Form::model($proveedor, []) !!}

                                                    <input type="hidden" name="proveedor_id" value="{{$proveedor->id}}" />
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <fieldset>
                                                                    <label>
                                                                        {{ Form::checkbox('active', $proveedor->id ) }}
                                                                        Activo
                                                                    </label>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-primary btn-actualizar" onclick="update('{{ route('proveedors.update') }}')" style="float: right"><i class="fa fa-save"></i> Actualizar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-primary btn-guardar" onclick="store('{{ route('proveedors.store') }}')" style="float: right"><i class="fa fa-save"></i> Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{ Form::close() }}
                                                    @endif

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