<div class="row">
    @foreach ($user->stores as $store)
    @if($store->store_type == 'B')
    <div class="col-xl-3">
        <div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-info">
            <div class="card-body">
                <h3 class="text-body font-weight-bold">{{ $store->description }}</h3>
                <div class="mt-3">
                    <div class="text-black-50 mt-3">
                        @if($user->store_active != $store->id )
                        <button class=" btn btn-outline-primary" onclick="activar('{{ $store->id}}', '{{ Auth::user()->id }}')">
                            Activar tienda
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>