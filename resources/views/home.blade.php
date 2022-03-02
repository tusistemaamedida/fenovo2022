@extends('layouts.app')

@section('css')

@endsection

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="row mt-5">
                    <div class="col-lg-12 col-xl-12">

                        @if(session('login-success'))
                        <div class="alert alert-info" role="alert">
                            {!! session('login-success') !!}
                        </div>
                        @endif

                        <div id="storeActiveBody">
                            @if (Auth::user()->rol() == 'base')
                            <div class="row">
                                @foreach (Auth::user()->stores as $store)

                                @if($store->store_type == 'B')
                                <div class="col-xl-3">
                                    <div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-info">
                                        <div class="card-body">
                                            <p class="text-body font-weight-bold">{{ $store->description }}</p>
                                            <div class="mt-3">
                                                <div class="text-black-50 mt-3">
                                                    @if(Auth::user()->store_active != $store->id )
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')

<script>
    const activar = (id, user_id) =>{
        jQuery.ajax({
            url: '{{ route('users.activar.tienda') }}',
            type: 'POST',
            data: { id, user_id },
            success: function (data) {   
                if (data['type'] == 'success') {
                    jQuery("#storeActiveHeader").html(data['header']);
                    jQuery("#storeActiveBody").html(data['body']);
                }
            }
        });        
    }
</script>

@endsection