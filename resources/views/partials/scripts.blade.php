@auth
    <script>
        const APP_URL = {!! json_encode(url('/')) !!};
    </script>


    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{asset('assets/js/plugin.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/api/jqueryvalidate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/api/pace/pace.js')}}"></script>
    <script src="{{asset('assets/api/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>

    <!-- DataTable / DataTable Buttons / DataTable Fixed Header / DataTable Moment -->
    <script src="{{asset('assets/api/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap4.5.0.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/api/datatable/datatables.min.js')}}"></script>{{--
    <script src="{{asset('assets/api/datatable/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/api/datatable/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/api/datatable/jszip.min.js')}}"></script>
    <script src="{{asset('assets/api/datatable/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/api/datatable/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/api/datatable/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/api/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/api/datatable/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('assets/api/datatable/dataTables.rowGroup.min.js')}}"></script> --}}
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

    <script>
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

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

        Aos.init();
    </script>


@endauth
