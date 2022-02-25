<div>
    <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="tc_aside">

        <div class="aside-menu-wrapper h-100 bg-dark " id="tc_aside_menu_wrapper">
            <div id="tc_aside_menu" class="aside-menu mb-5">
                <div id="accordion">
                    <ul class="nav">

                        <li> <span class="nav-text"> ... </span> </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <span class="svg-icon nav-icon"> <br /> </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('inicio')}}" class="nav-link">
                                <span class="svg-icon nav-icon"> <i class=" fa fa-home"> </i> </span>
                                <span class="nav-text"> Inicio </span>
                            </a>
                        </li>

                        @can('products.index')
                        <li class="nav-item">
                            <a href="{{url('productos')}}" class="nav-link">
                                <span class="svg-icon nav-icon"> <i class="fas fa-boxes"></i> </span>
                                <span class="nav-text"> Productos </span>
                            </a>
                        </li>
                        @endcan

                        <li> <span class="nav-text"> ... </span> </li>

                        <li class="nav-item">
                            <a href="{{ route('ingresos.index') }}" class="nav-link">
                                <span class="svg-icon nav-icon"> <i class="fas fa-arrow-alt-circle-left"></i> </span>
                                <span class="nav-text">Ingresos </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('salidas.pendientes')}}" class="nav-link">
                                <span class="svg-icon nav-icon"> <i class="fas fa-arrow-alt-circle-right text-secondary"></i> </span>
                                <span class="nav-text">Salidas</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('salidas.index')}}" class="nav-link">
                                <span class="svg-icon nav-icon"> <i class="fas fa-arrow-alt-circle-right text-danger"></i> </span>
                                <span class="nav-text">Salidas.Cerradas</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('nc.index')}}" class="nav-link">
                                <span class="svg-icon nav-icon"> <i class="fas fa-file text-primary"></i> </span>
                                <span class="nav-text">Notas de Crédito</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('senasa.index')}}" class="nav-link">
                                <span class="svg-icon nav-icon"> <i class="fa fa-exclamation-circle"></i> </span>
                                <span class="nav-text">Senasa</span>
                            </a>
                        </li>

                        <li> <span class="nav-text"> ... </span> </li>

                        <li class="nav-item ">
                            <a href="{{url('proveedores')}}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-truck"></i>
                                </span>
                                <span class="nav-text">
                                    Proveedores
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('tiendas') }}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-store"></i>
                                </span>
                                <span class="nav-text">Tiendas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('clientes') }}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-user-friends"></i>
                                </span>
                                <span class="nav-text">Clientes</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('users') }}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-user-cog"></i>
                                </span>
                                <span class="nav-text">Usuarios</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>