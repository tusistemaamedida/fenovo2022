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

    <script>
        const APP_URL = {!! json_encode(url('/')) !!};
    </script>

    @include('partials.scripts')

    @yield('js')

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}", "{{ Session::get('title') }}");
                    break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}", "{{ Session::get('title') }}");
                    break;

                case 'success':
                    toastr.success("{{ Session::get('message') }}", "{{ Session::get('title') }}");
                    break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}", "{{ Session::get('title') }}");
                    break;
            }
        @endif

        AOS.init();
        
    </script>

</body>

</html>
