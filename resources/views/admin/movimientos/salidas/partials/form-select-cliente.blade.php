<div class="col-lg-12 col-xl-12">
    <div class="card card-custom gutter-b bg-white border-0">
        <div class="card-body">
            <div class="form-group row">

                <div class="col-md-2">
                    <label class="text-body">Movimiento</label>
                    <fieldset class="form-group mb-3">
                        <select class="js-example-basic-single js-states form-control bg-transparent" name="to_type" id="to_type">
                            <option value="">Seleccione tipo de salida</option>
                            <option value="VENTA" @if(isset($tipo) && $tipo=='VENTA' ) selected @endif>Venta</option>
                            @if (\Auth::user()->rol() == 'admin' || \Auth::user()->rol() == 'superadmin')
                            <option value="TRASLADO" @if(isset($tipo) && $tipo=='TRASLADO' ) selected @endif>Traslado</option>
                            @endif
                            <option value="VENTACLIENTE" @if(isset($tipo) && $tipo=='VENTACLIENTE' ) selected @endif>Venta a cliente</option>
                        </select>
                    </fieldset>
                </div>

                <div class="col-md-3">
                    <label class="text-body">Cliente/Tienda</label>
                    <fieldset class="form-group mb-3">
                        <select class="js-example-basic-single js-states form-control bg-transparent" name="to" id="to">
                            @if(isset($destino)) <option value="{{$destino->id}}">{{$destinoName}}</option>@endif
                        </select>
                    </fieldset>
                </div>

                <div class="col-md-4">
                    <label class="text-body">Seleccionar producto</label>
                    <fieldset class="form-group mb-3 d-flex">
                        <select class="js-example-basic-single js-states form-control bg-transparent" name="product_search" id="product_search" autofocus> </select>
                    </fieldset>
                </div>

                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-dark" id="btnPrintCerrarSalida"  style="float: right;margin-top: 30px;height: 20px;padding: 2px 15px 22px 15px;">
                        <i class="fa fa-print"></i>
                    </button>
                </div>

                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-danger" id="btnOpenCerrarSalida" disabled style="float: right;margin-top: 30px;height: 20px;padding: 2px 15px 22px 15px;">
                        <i class="fa fa-times"></i> Cerrar Salida
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
