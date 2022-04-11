<div id="closeSalida" class="offcanvas offcanvas-right kt-color-panel p-5">
    <form action="{{route('guardar.salida')}}" method="POST">
        @csrf
        <div class="row mb-2">
            <div class="col-12">
                <h4>CERRAR SALIDA</h4>
                <input type="hidden" name="session_list_id" id="session_list_id" value="">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12">
                <p>El stock se actualizará definitivamente, continúa ? </p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6">
                <label class="text-dark">#Nro de identificación</label>
                <input type="text" name="voucher_number" value="{{ strtoupper(substr(md5(time()), 0, 6)) }}" id="voucher_number" class="form-control text-center" autofocus>
            </div>
        </div>

        <div class="row mt-5">            
            <div class="col-6">
                <label class="text-dark">Flete <strong> <span id="porcentajeFlete"></span> </strong> % </label>
                <input type="text" name="flete" id="flete" value="0" class="form-control text-center">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <fieldset>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="factura_flete" id="factura_flete" value='1' class="custom-control-input">
                        <label class="custom-control-label" for="factura_flete">Factura flete </label>
                    </div>
                </fieldset>  
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <button type="reset" class="btn btn-outline-primary" id="close_modal_salida"><i class="fa fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btnCloseSalida" style="float: right"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </form>
</div>
