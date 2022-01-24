<div id="tc_header" class="header header-fixed">
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
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">

            <!--begin::user-->

            <div class="dropdown">
                <div class="topbar-item" data-toggle="dropdown" data-display="static">
                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center pr-1 pl-3">
                        <span class="text-dark-50 font-size-base d-none d-xl-inline mr-3">
                            {{ ucfirst(Auth::user()->username) }} ({{ Auth::user()->rol() }})
                        </span>
                        <span class="symbol symbol-35 symbol-light-success">
                            <span class="symbol-label font-size-h5 ">
                                <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg>
                            </span>
                        </span>
                    </div>
                </div>

                <div class="dropdown-menu dropdown-menu-right" style="min-width: 150px;">
                    <a href="#" class="dropdown-item">
                        <span class="svg-icon svg-icon-xl svg-icon-primary mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        Perfil
                    </a>

                    <a href="#" class="dropdown-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <span class="svg-icon svg-icon-xl svg-icon-primary mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                                    <line x1="12" y1="2" x2="12" y2="12"></line>
                                </svg>
                            </span>
                            <button type="submit" class="btn-link btn-light rounded-pill pull-left" style="border: none;">
                                Salir
                            </button>
                        </form>
                    </a>
                </div>
            </div>
            {{-- end::user --}}

        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>