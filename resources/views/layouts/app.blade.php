<!DOCTYPE html>
<html lang="es">

@include('partials.head')

@yield('css')

<body>
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
