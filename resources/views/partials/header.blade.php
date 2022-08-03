<nav class="navbar navbar-expand-lg navbar-red navbar-dark mt-2">
    <div class="wrapper-f"></div>
    <div class="container-fluid all-show">
        <a class="navbar-brand mt-3" href="{{ route('inicio') }}">FENOVO SA </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">

                @can('products.index')
                <li class="nav-item dropdown ml-3 mt-2" title="Lista de productos">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-barcode"></i> </span>
                    </a>
                    <div class="dropdown-menu bg-dark">


                        <a class="dropdown-item" href="{{ url('productos') }}">
                            <span class="text-black-50"> Lista de productos </span>
                        </a>


                        <a class="dropdown-item" href="{{ url('productos-no-congelados') }}">
                            <span class="text-black-50"> Productos No congelados </span>
                        </a>
                        <a class="dropdown-item" href="{{ route('productos.stock.deposito') }}">
                            <span class="text-black-50"> Stock de productos en Friotekas </span>
                        </a>

                        <a class="dropdown-item" href="{{ route('productos.ajusteHistoricoDeposito') }}">
                            <span class="text-black-50"> Lista de productos - Depósito reclamos </span>
                        </a>

                        <a class="dropdown-item" href="{{ route('products.compararStock') }}">
                            <span class="text-black-50">Comparar stocks</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('ingresos.ajustarStockIndex') }}">
                            <span class="text-black-50">Ajustes de stocks entre depósitos</span>
                        </a>

                        <a class="dropdown-item" href="{{ url('oferta') }}" title="Oferta de precios">
                            <span class="text-black-50">Ofertas</span>
                        </a>

                        <a class="dropdown-item" href="{{ url('actualizacion') }}" title="Actualización de precios">
                            <span class="text-black-50">Actualizaciones</span>
                        </a>

                        <a class="dropdown-item" href="{{ url('descuento') }}" title="Lista de descuentos">
                            <span class="text-black-50">Descuentos</span>
                        </a>
                    </div>
                </li>
                @endcan

                @can('products.index')
                <li class="nav-item dropdown mt-2" title="Compras">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cart-arrow-down"></i>
                    </a>
                    <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item text-black-50" href="{{ route('ingresos.index') }}">
                            Preparar Compras
                        </a>
                        <a class="dropdown-item text-black-50" href="{{ route('ingresos.indexCerradas') }}">
                            Compras cerradas
                        </a>
                        <a class="dropdown-item text-black-50" href="{{ route('ingresos.indexChequeadas') }}">
                            Compras chequeadas
                        </a>
                    </div>
                </li>
                @endcan

                <li class="nav-item dropdown mt-2" title="Salidas">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-dolly-flatbed"></i>
                    </a>
                    <div class="dropdown-menu bg-dark">
                        <a class="dropdown-item text-black-50" href="{{ route('salidas.pendientes') }}">
                            Preparar salidas
                        </a>

                        @if(in_array(Auth::user()->rol(), ['superadmin', 'admin']) )

                        <a class="dropdown-item text-black-50" href="{{ route('salidas.index') }}">
                            Salidas finalizadas
                        </a>
                        <a class="dropdown-item text-black-50" href="{{ route('senasa.index') }}">
                            Senasa
                        </a>
                        <a class="dropdown-item text-black-50" href="{{ route('nc.index') }}">
                            Notas de <span class=" text-warning">Crédito</span>
                        </a>
                        <a class="dropdown-item text-black-50" href="{{ route('nd.index') }}">
                            Notas de <span class="text-warning">Dédito</span>
                        </a>

                        @endif
                    </div>
                </li>

                @can('pedidos.index')
                    <li class="nav-item" title="Lista de pedidos - @if ($nroPedidos > 0) tiene {{ $nroPedidos }} pedido pendientes @endif " >
                        <a href="{{ route('pedidos.index') }}" class="nav-link mt-2">
                            @if ($nroPedidos > 0)
                                <i class="fas fa-list text-warning"></i> <span
                                    class="text-warning">{{ $nroPedidos }}</span>
                            @else
                                <i class="fas fa-list"></i>
                            @endif
                        </a>
                    </li>
                @endcan


                @can('stores.index')
                <li class="nav-item dropdown mt-2" title="">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-store"></i>
                    </a>
                    <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item text-black-50" href="{{ url('depositos') }}">
                            Depósitos
                        </a>
                        <a class="dropdown-item text-black-50" href="{{ url('tiendas') }}">
                            Franquicias
                        </a>
                    </div>
                </li>
                @endcan

                @can('customers.index')
                <li class="nav-item" title="Clientes">
                    <a href="{{ url('clientes') }}" class="nav-link mt-2">
                        <span class="svg-icon nav-icon">
                            <i class="fas fa-user-friends"></i>
                        </span>
                    </a>
                </li>
                @endcan

                @can('print.index')
                <li class="nav-item" title="Impresión / Exportación">
                    <a href="{{ route('menu.print') }}" class="nav-link mt-2">
                        <span class="svg-icon nav-icon">
                            <i class="fas fa-print"></i>
                        </span>
                    </a>
                </li>
                @endcan


                @can('setting.index')
                <li class="nav-item dropdown mt-2" title="Configuracion de accesos y roles">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cogs"></i>
                    </a>
                    <div class="dropdown-menu bg-dark">
                        <a class="dropdown-item" href="{{ url('users') }}">
                            <span class="text-black-50"> Usuarios </span>
                        </a>
                        @role('superadmin')
                            <a class="dropdown-item" href="{{ route('roles.index') }}">
                                <span class="text-black-50"> Roles </span>
                            </a>
                            <a class="dropdown-item" href="{{ url('permissions') }}">
                                <span class="text-black-50"> Permisos </span>
                            </a>
                        @endrole
                    </div>
                </li>
                @endcan

                @can('setting.index')
                <li class="nav-item" title="Proveedores">
                    <a href="{{ url('proveedores') }}" class="nav-link mt-2">
                        <span class="svg-icon nav-icon">
                            <i class="fas fa-industry"></i>
                        </span>
                    </a>
                </li>
                @endcan

                @can('transporte.index')
                <li class="nav-item dropdown mt-2" title="Transporte">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shipping-fast"></i>
                    </a>
                    <div class="dropdown-menu bg-dark">
                        <a class="dropdown-item" href="{{ route('rutas.index') }}">
                            <span class="text-black-50">Rutas</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('transportistas.index') }}">
                            <span class="text-black-50">Transportistas</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('vehiculos.index') }}">
                            <span class="text-black-50">Vehículos</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('localidades.index') }}">
                            <span class="text-black-50"> Localidades</span>
                        </a>
                    </div>
                </li>
                @endcan

            </ul>

            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <li class="nav-item" title="Opciones del usuario">
                    <a href="{{ route('users.editProfile') }}" class="nav-link">
                        <small> {{ ucfirst(Auth::user()->username) }} [{{ Auth::user()->rol()}}] </small>
                    </a>
                </li>
            </ul>
            <div class="d-flex flex-column sim">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class=" btn nav-link" title="Salir">
                        <i class="fas fa-sign-out-alt text-white"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
