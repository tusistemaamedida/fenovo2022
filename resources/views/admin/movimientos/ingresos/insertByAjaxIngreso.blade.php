<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            Editar ingreso
        </h4>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Proveedor</label>
    <input type="text" id="proveedor" name="proveedor" value="{{$proveedor->name}}" class="form-control" readonly>
</div>

<div class="form-group">
    <label class="text-dark">Fecha</label>
    <input type="date" id="date" name="date" value="{{ date('Y-m-d', strtotime($movement->date))}}" class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark">Comprobante</label>
    <input type="text" id="voucher_number" name="voucher_number" value="{{$movement->voucher_number}}" class="form-control">
</div>

<input type="hidden" name="movement_id" value="{{$movement->id}}" />
