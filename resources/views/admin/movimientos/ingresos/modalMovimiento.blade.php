<div id="movimientoPopup" class="movimientoPopup offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formDataCompra">
        @csrf
        <div class="row">
            <div class="col-12 font-weight-bolder">
                AJUSTAR
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 font-weight-bolder">
                <span id="cod_fenovo"></span> - <span id="nombre"></span>
            </div>
        </div>

        <input type="hidden" id="detalle_id" name="detalle_id" />
        <input type="hidden" id="producto_id" name="producto_id" />
        <input type="hidden" id="bultos_anterior" name="bultos_anterior" />
        <input type="hidden" id="tipo" name="tipo" value="{{ $movement->subtype }}" />

        <div class="row mt-5">
            <div class="col-12">
                <label class="text-body">Bultos *</label>
                <fieldset class="form-group">
                    <input type="number" id="bultos_actual" name="bultos_actual" class="form-control text-center"
                        autofocus />
                </fieldset>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                @foreach ($ajustes as $ajuste)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="radioAjuste{{ $ajuste['type'] }}" name="ajuste"
                            class="custom-control-input" onclick="VerAjuste(this.value)" value="{{ $ajuste['type'] }}"
                            @if ($loop->first) checked @endif>
                        <label class="custom-control-label" for="radioAjuste{{ $ajuste['type'] }}">
                            {{ $ajuste['type'] }}</label>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-12">
                <label class="text-body">Observaciones / comentarios</label>
                <input type="text" name="observacion" id="observacion" value="Ajuste contable "
                    class="form-control bg-white border-primary">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6">
                <button type="reset" class="btn btn-outline-primary" onclick="cerrarModal()">
                    <i class="fa fa-times"></i> Cancelar
                </button>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-dark" onclick="actualizarMovimiento()">
                    <i class="fa fa-save"></i> Ajustar
                </button>
            </div>
        </div>
    </form>
</div>
