<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto">
    <div class="aside-menu-wrapper h-100 bg-dark ">
        <div id="tc_aside_menu" class="aside-menu mb-5">
            <div id="accordion">
                <ul class="nav">

                    <li class="nav-item"> <span class="nav-text"> &nbsp; </span> </li>

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
                    <li class="nav-item" title="Lista de Productos">
                        <a href="{{url('productos')}}" class="nav-link">
                            <span class="svg-icon nav-icon"> <i class="fas fa-boxes"></i> </span>
                            <span class="nav-text"> Productos </span>
                        </a>
                    </li>
                    @endcan

                    <li class="nav-item" title="Compra de Mercadería">
                        <a href="{{ route('ingresos.index') }}" class="nav-link">
                            <span class="svg-icon nav-icon"> <i class="fas fa-truck-moving"></i> </span>
                            <span class="nav-text">Compras</span>
                        </a>
                    </li>

                    <li class="nav-item" title="Salidas en preparación">
                        <a href="{{route('salidas.pendientes')}}" class="nav-link">
                            <span class="svg-icon nav-icon"> <i class="fas fa-stopwatch text-secondary"></i> </span>
                            <span class="nav-text">Salidas</span>
                        </a>
                    </li>

                    <li class="nav-item" title="Salidas cerradas">
                        <a href="{{route('salidas.index')}}" class="nav-link">
                            <span class="svg-icon nav-icon"> <i class="fab fa-expeditedssl text-secondary "></i> </span>
                            <span class="nav-text">Salidas.Finalizadas</span>
                        </a>
                    </li>

                    <li class="nav-item" title="Notas de crédito">
                        <a href="{{route('nc.index')}}" class="nav-link">
                            <span class="svg-icon nav-icon"> <i class="fas fa-file-invoice"></i> </span>
                            <span class="nav-text">Notas.de.Crédito</span>
                        </a>
                    </li>

                    <li class="nav-item ml-2" title="Documentos Senasa">
                        <a href="{{route('senasa.index')}}" class="nav-link">
                            <span class="svg-icon nav-icon">
                                <img src="{{asset('assets/images/misc/senasa.ico')}}" alt="senasa">
                            </span>
                            <span class="nav-text">Senasa</span>
                        </a>
                    </li>

                    <li class="nav-item" title="Proveedores">
                        <a href="{{url('proveedores')}}" class="nav-link">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-industry"></i>
                            </span>
                            <span class="nav-text"> Proveedores </span>
                        </a>
                    </li>
                    <li class="nav-item" title="Lista de Friotekas">
                        <a href="{{ url('tiendas') }}" class="nav-link">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-store"></i>
                            </span>
                            <span class="nav-text">Tiendas</span>
                        </a>
                    </li>
                    <li class="nav-item" title="Clientes">
                        <a href="{{ url('clientes') }}" class="nav-link">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-user-friends"></i>
                            </span>
                            <span class="nav-text">Clientes</span>
                        </a>
                    </li>

                    <li class="nav-item" title="Usuarios del sistema">
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