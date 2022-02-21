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

                        <li class="nav-item">
                            <a href="{{url('productos')}}" class="nav-link">
                                <span class="svg-icon nav-icon"> <i class="fas fa-boxes"></i> </span>
                                <span class="nav-text"> Productos </span>
                            </a>
                        </li>

                        <li> <span class="nav-text"> ... </span> </li>

                        <li class="nav-item">
                            <a href="{{ route('ingresos.index') }}" class="nav-link">
                                <span class="svg-icon nav-icon"> <i class="fas fa-arrow-alt-circle-left"></i> </span>
                                <span class="nav-text"> Ingresos </span>
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
                            <a href="{{route('nc.add')}}" class="nav-link">
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

                        @role('superadmin')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#setting" role="button" aria-expanded="false" aria-controls="setting">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-cogs"></i>
                                </span>
                                <span class="nav-text">Configuración</span>
                                <i class="fas fa-chevron-right fa-rotate-90"></i>
                            </a>
                            <div class="collapse nav-collapse" id="setting" data-parent="#accordion">
                                <div id="accordion3">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('users') }}" class="nav-link sub-nav-link">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Usuarios</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('roles.index') }}" class="nav-link sub-nav-link">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Roles</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('permissions') }}" class="nav-link sub-nav-link">
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
