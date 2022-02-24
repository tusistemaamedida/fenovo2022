<div id="tc_header" class="header header-fixed bg-dark">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="tc_header_menu_wrapper">
            <!--begin::Header Menu-->
            <div id="tc_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <!--begin::Header Nav-->
                <ul class="menu-nav">
                    <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active p-0" data-menu-toggle="click" aria-haspopup="true">
                        <div class="btn  btn-clean btn-dropdown mr-0 p-0" id="tc_aside_toggle">
                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                <svg width="24px" height="24px" viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </span>
                        </div>
                    </li>
                </ul>
                <!--end::Header Nav-->
            </div>
            <!--end::Header Menu-->
        </div>
        <header class="pos-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="greeting-text">
                            <h3 class="card-label mb-0 mt-2">
                                FENOVO S.A.
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="topbar">
            <li class="dropdown">
                <button class="btn dropdown-toggle text-black-50" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="{{ Auth::user()->rol() }}">
                    {{ ucfirst(Auth::user()->username) }}
                </button>
                <div class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-pill" style="border: none;">
                                Salir
                            </button>
                        </form>
                    </a>
                    <a class="dropdown-item" href="{{ route('users.editProfile') }}">
                        Perfil
                    </a>

                    @role('superadmin')
                    <div class="dropdown dropleft dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" type="button" data-toggle="dropdown">Setting</a>
                        <div class="dropdown-menu bg-dark">
                            <a href="{{ url('users') }}" class="dropdown-item">
                                <span class="nav-text">Usuarios</span>
                            </a>
                            <a href="{{ route('roles.index') }}" class="dropdown-item">
                                <span class="nav-text">Roles</span>
                            </a>
                            <a href="{{ url('permissions') }}" class="dropdown-item">
                                <span class="nav-text">Permisos</span>
                            </a>
                        </div>
                    </div>
                    @endrole

                </div>
            </li>
        </div>
    </div>
</div>