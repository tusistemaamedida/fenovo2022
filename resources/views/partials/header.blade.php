<div id="tc_header" class="header header-fixed bg-dark">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="tc_header_menu_wrapper">
            <div id="tc_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active p-0" data-menu-toggle="click" aria-haspopup="true">
                        <div class="btn  btn-clean btn-dropdown mr-0 p-0" id="tc_aside_toggle">
                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                <svg width="24px" height="24px" viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </span>

                            @if(Auth::user()->rol()=='base')
                            Tienda activa <span class=" font-monospace text-white ">{{ Auth::user()->store_active()}}</span>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <header class="pos-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="greeting-text">
                            <h3 class="card-label mb-0 mt-2">
                                FENOVO SA
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="topbar">

            <div class="btn-clean mr-2 text-black-50">
                {{ ucfirst(Auth::user()->username) }} <span class=" text-warning">| </span>{{ Auth::user()->rol() }}<span class=" text-warning"> |</span>
            </div>

            <li class="dropdown">
                <button class="btn dropdown-toggle text-black-50" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="{{ Auth::user()->rol() }}">
                    Opción
                </button>
                <div class="dropdown-menu bg-dark " aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('users.editProfile') }}">
                        Perfil
                    </a>

                    @role('superadmin')

                    <a class="dropdown-item mb-0 mt-0" href="#" style=" height: 0; border: 0; border-top: 1px solid #fcfcfc">
                        <hr />
                    </a>

                    <a class="dropdown-item mt-0" href="{{ route('roles.index') }}">
                        <span class="nav-text">Roles</span>
                    </a>
                    <a class="dropdown-item" href="{{ url('permissions') }}">
                        <span class="nav-text">Permisos</span>
                    </a>

                    @endrole
                </div>
            </li>

            <div class="btn btn-icon btn-clean mr-1 text-black-50">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-pill" style="border: none;">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>


        </div>
    </div>
</div>