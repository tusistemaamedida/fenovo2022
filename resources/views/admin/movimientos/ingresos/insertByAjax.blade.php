<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            Editar producto
        </h4>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Nombre</label>
    <input type="text" id="name" name="name" @if (isset($product)) value="{{$product->name}}" @else value="" @endif class="form-control" required>
</div>

<div class="form-group">
    <label class="text-body">Unidad x bulto *</label>
    <fieldset class="form-group mb-3">
        <select name="unit_package[]" id="unit_package" multiple="multiple" class="js-example-basic-multiple js-states form-control bg-transparent">
            @for ($i = 1; $i < 101; $i++) <option value="{{$i}}" @if(isset($product) && in_array($i,$unit_package)) selected @endif>
                {{$i}}
                </option>
                @endfor
        </select>
    </fieldset>
</div>

<input type="hidden" name="product_id" value="{{$product->id}}" />