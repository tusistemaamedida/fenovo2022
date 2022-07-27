<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8" />
        <title>Fenovo</title>
        <meta name="description" content="fenovo frioteka congelados" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{asset('assets/css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    </head>


@yield('css')

<body>
    @yield('content')
    

        <script src="{{ asset('/js/app.js') }}"></script>
        <script src="{{asset('assets/js/plugin.bundle.min.js')}}"></script>
        <script src="{{asset('assets/js/popper.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/api/jqueryvalidate/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/api/pace/pace.js')}}"></script>
        <script src="{{asset('assets/api/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
        <script src="{{asset('assets/api/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap4.5.0.min.js')}}"></script>
        <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>

        <script src="{{asset('assets/api/datatable/datatables.min.js')}}"></script>
        <script src="{{asset('assets/api/datatable/moment.min.js')}}"></script>
        <script src="{{asset('assets/api/datatable/datetime.js')}}"></script>
        <script src="{{asset('assets/js/sweetalert.js')}}"></script>
        <script src="{{asset('assets/js/sweetalert1.js')}}"></script>
        <script src="{{asset('assets/js/script.bundle.js')}}"></script>
        <script src="{{asset('assets/js/toastr.min.js')}}"></script>
        <script src="{{asset('assets/js/ymz_box.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap-submenu.min.js')}}"></script>
        <script src="{{asset('assets/api/select2/select2.min.js')}}"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        

    @yield('js')

</body>

</html>
