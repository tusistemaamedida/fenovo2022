<div>
    <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="tc_aside">

        <div class="brand flex-column-auto" id="tc_brand">
            <a href="{{route('inicio')}}" class="brand-logo">
                <div class="brand-image"><img style="height: 40px;margin-right:20px" alt="fenovo" src="{{asset('assets/images/misc/logo.png')}}" /></div>
                <span class="brand-text"><img style="height: 40px;margin-right:20px" alt="fenovo" src="{{asset('assets/images/misc/logo.png')}}" /></span>
            </a>
        </div>

        <div class="aside-menu-wrapper flex-column-fluid overflow-auto h-100" id="tc_aside_menu_wrapper">
            <div id="tc_aside_menu" class="aside-menu  mb-5" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                <div id="accordion">
                    <ul class="nav flex-column">
                        <li class="nav-item @if(Route::is('inicio')) active @endif">
                            <a href="{{route('inicio')}}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                </span>
                                <span class="nav-text">
                                    Inicio
                                </span>
                            </a>
                        </li>

                        <li class="nav-item @if(Route::is('product.*')||Route::is('products.*')) active @endif">
                            <a href="{{url('productos')}}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-boxes font-size-h4"></i>
                                </span>
                                <span class="nav-text">
                                    Productos
                                </span>
                            </a>
                        </li>

                        <li class="nav-item @if(Route::is('salidas.*') || Route::is('ingresos.*')) active @endif">
                            <a class="nav-link" data-toggle="collapse" href="#catalogPurchase" role="button" aria-expanded="false" aria-controls="catalogPurchase">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-money-check-alt font-size-h4"></i>
                                </span>
                                <span class="nav-text">Movimientos</span>
                                <i class="fas fa-chevron-right fa-rotate-90"></i>
                            </a>
                            <div class="collapse nav-collapse @if(Route::is('salidas.*') || Route::is('ingresos.*')) show @endif" id="catalogPurchase" data-parent="#accordion">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('ingresos.index') }}" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                </svg>
                                            </span>
                                            <span class="nav-text">Ingresos</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('salidas.add')}}" class="nav-link sub-nav-link @if(Route::is('salidas.*')) active @endif">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                </svg>
                                            </span>
                                            <span class="nav-text">Salidas</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('senasa.index')}}" class="nav-link sub-nav-link @if(Route::is('senasa.*')) active @endif">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                </svg>
                                            </span>
                                            <span class="nav-text">Senasa</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item @if(Route::is('proveedors.*')) active @endif">
                            <a href="{{url('proveedores')}}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-truck font-size-h4"></i>
                                </span>
                                <span class="nav-text">
                                    Proveedores
                                </span>
                            </a>
                        </li>
                        <li class="nav-item @if(Route::is('stores.*')) active @endif">
                            <a href="{{ url('tiendas') }}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-store font-size-h4"></i>
                                </span>
                                <span class="nav-text">Tiendas</span>
                            </a>
                        </li>
                        <li class="nav-item @if(Route::is('customers.*')) active @endif">
                            <a href="{{ url('clientes') }}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-user-friends font-size-h4"></i>
                                </span>
                                <span class="nav-text">Clientes</span>
                            </a>
                        </li>

                        @role('superadmin')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#setting" role="button" aria-expanded="false" aria-controls="setting">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-cogs font-size-h4"></i>
                                </span>
                                <span class="nav-text">Configuración</span>
                                <i class="fas fa-chevron-right fa-rotate-90"></i>
                            </a>
                            <div class="collapse nav-collapse show" id="setting" data-parent="#accordion">
                                <div id="accordion3">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('users') }}" class="nav-link sub-nav-link @if(Route::is('users.*')) active @endif">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Usuarios</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('roles.index') }}" class="nav-link sub-nav-link  @if(Route::is('roles.*')) active @endif">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Roles</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('permissions') }}" class="nav-link sub-nav-link  @if(Route::is('permissions.*')) active @endif">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Permisos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @endrole
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>