<div id="tc_header" class="header header-fixed mt-2 bg-dark">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper ">
            <div class="header-menu header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    <span class="menu-item  p-0" aria-haspopup="true">
                        <div class="btn  btn-clean btn-dropdown mr-0 p-0" id="tc_aside_toggle">
                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                <svg width="24px" height="24px" viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </span>
                            FENOVO SA ::
                            <span id="storeActiveHeader">
                                @if(Auth::user()->rol()=='base')
                                Tienda activa <span class=" active">
                                    {{ Auth::user()->store_active()}}
                                </span>
                                @endif
                            </span>
                        </div>
                    </span>
                </ul>
            </div>
        </div>

        <div class="topbar">

            <li class="dropdown">
                <span class="dropdown-toggle text-black-50 p-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="{{ Auth::user()->rol() }}">
                    {{ ucfirst(Auth::user()->username) }} <span class=" text-warning">[</span>{{ Auth::user()->rol() }}<span class=" text-warning">]</span>
                </span>
                <div class="dropdown-menu bg-dark " aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('users.editProfile') }}">
                        Perfil
                    </a>
                </div>
            </li>


            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-close text-black-50">
                    Salir
                </button>
            </form>



        </div>
    </div>
</div>