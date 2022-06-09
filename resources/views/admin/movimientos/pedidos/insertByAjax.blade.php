<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            Editar producto
        </h4>
    </div>
</div>

<div class="form-group">
    <p class=" font-weight-bold">{{$product->name}}</p>
</div>

<div class="form-group">
    <label class="text-body">Peso por unidad *</label>
    <fieldset class="input-group form-group mb-3">
        <input type="text" class="form-control border-dark" value="{{$product->unit_weight}}" name="unit_weight" id="unit_weight">
        <div class="input-group-prepend">
            <span class="input-group-text">Kg.</span>
        </div>
    </fieldset>
</div>

<div class="form-group">
    <label class="text-body">Unidad x bulto *</label>
    <fieldset class="form-group mb-3">
        <select name="unit_package[]" id="unit_package" multiple="multiple" class="js-example-basic-multiple js-states form-control bg-transparent">
            @for ($i = 1; $i < 101; $i++) <option value="{{$i}}"> {{$i}}</option> @endfor

            @if(isset($product))
            @foreach ( $unit_package as $unit )
            <option value="{{$unit}}" selected>
                {{$unit}}
            </option>
            @endforeach
            @endif
        </select>
    </fieldset>
</div>

<input type="hidden" name="product_id" value="{{$product->id}}" />