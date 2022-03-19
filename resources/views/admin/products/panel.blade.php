@if(isset($oferta))
|
<a href="{{route('product.edit',['id' => $product->id,'fecha_oferta' => $oferta->id])}}#precios" onclick="jQuery('#loader').removeClass('hidden')">
    <span class="badge @if(\Carbon\Carbon::now() >= $oferta->fecha_desde && \Carbon\Carbon::now() <= $oferta->fecha_hasta ) badge-primary  @else  badge-secondary @endif p-2">
        OFERTA :: {{\Carbon\Carbon::parse($oferta->fecha_desde)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($oferta->fecha_hasta)->format('d/m/Y')}}
    </span>
</a>
@endif