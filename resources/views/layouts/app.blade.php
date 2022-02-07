<!DOCTYPE html>
<html lang="es">

@include('partials.head')

@yield('css')

<body id="tc_body" class="@auth header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed pace-done pace-done aside-minimize @endauth">
    @auth
    @include('partials.head-mobile')
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">

            @include('partials.aside')

            <div class="aside-overlay"></div>

            <div class="d-flex flex-column flex-row-fluid wrapper" id="tc_wrapper">

                @include('partials.header')

                <div class="content d-flex flex-column flex-column-fluid" id="tc_content">
                    <div id="loader" class="lds-dual-ring hidden overlay"></div>

                    @yield('content')

                </div>

                @include('partials.footer')

            </div>
        </div>
    </div>
    @endauth

    @guest
    @yield('content')
    @endguest

    @include('partials.scripts')

    @yield('js')

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
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
    </script>

</body>

</html>