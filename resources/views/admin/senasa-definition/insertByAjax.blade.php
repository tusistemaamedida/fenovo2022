<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            {{ ($senasa)?'Editar':'Agregar'}} Categoria SENASA
        </h4>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Nombre categoria</label>
    <input type="text" id="product_name" name="product_name" @if (isset($senasa)) value="{{$senasa->product_name}}" @else value="" @endif class="form-control" required>
</div>

@if (isset($senasa))

{!! Form::model($senasa, []) !!}

<input type="hidden" name="id" value="{{$senasa->id}}" />

{{ Form::close() }}
@endif