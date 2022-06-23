<!DOCTYPE html>
<html lang="es">

@include('partials.head')

@yield('css')

<body id="tc_body" class="@auth aside-fixed aside-minimize @endauth">

    @auth        
        @include('partials.header')
        <div class="container-fluid">
            <div id="loader" class="lds-dual-ring hidden overlay"></div>
            @yield('content')
        </div>        
    @endauth

    @guest
        @yield('content')
    @endguest

    @include('partials.scripts')

    @yield('js')

</body>

</html>
